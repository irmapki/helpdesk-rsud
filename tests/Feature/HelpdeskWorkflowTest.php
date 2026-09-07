<?php

use App\Models\Category;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\Unit;
use App\Models\User;

beforeEach(function () {
    // Seed master data required for tests
    Unit::firstOrCreate(['code' => 'IGD'], ['name' => 'Instalasi Gawat Darurat (IGD)', 'location' => 'Gedung A Lantai 1']);
    Category::firstOrCreate(['name' => 'SIMRS & Bridging BPJS']);
    Priority::firstOrCreate(['name' => 'Medium'], ['sla_hours' => 8, 'badge_class' => 'bg-amber-100 text-amber-800']);
    Role::firstOrCreate(['name' => 'admin'], ['label' => 'Admin Helpdesk']);
    Role::firstOrCreate(['name' => 'teknisi'], ['label' => 'Teknisi IT']);
});

test('guest can access landing page and ticket create form', function () {
    $response = $this->get('/');
    $response->assertStatus(200);

    $response = $this->get('/guest/ticket/create');
    $response->assertStatus(200);
});

test('guest can create a ticket with valid inputs', function () {
    $unit = Unit::first();
    $category = Category::first();

    $response = $this->post('/guest/ticket', [
        'guest_name' => 'Dokter Jaga IGD',
        'guest_phone' => '081234567890',
        'unit_id' => $unit->id,
        'category_id' => $category->id,
        'title' => 'Komputer SIMRS IGD tidak bisa simpan resep',
        'description' => 'Saat klik tombol simpan resep keluar error database lock.',
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('tickets', [
        'guest_name' => 'Dokter Jaga IGD',
        'title' => 'Komputer SIMRS IGD tidak bisa simpan resep',
        'validation_status' => 'pending',
    ]);
});

test('admin can validate ticket into open pool, direct assign, and release', function () {
    $adminRole = Role::where('name', 'admin')->first();
    $teknisiRole = Role::where('name', 'teknisi')->first();

    $admin = User::firstOrCreate(['email' => 'admin_test@rsud.test'], [
        'name' => 'Admin Test',
        'password' => bcrypt('password'),
        'role_id' => $adminRole->id,
        'is_active' => true,
    ]);

    $tech = User::firstOrCreate(['email' => 'tech_test@rsud.test'], [
        'name' => 'Ayu Test',
        'password' => bcrypt('password'),
        'role_id' => $teknisiRole->id,
        'specialization' => 'SIMRS',
        'is_active' => true,
    ]);

    $ticket = Ticket::create([
        'ticket_number' => Ticket::generateTicketNumber(),
        'title' => 'Error SIMRS',
        'description' => 'Test error SIMRS',
        'unit_id' => Unit::first()->id,
        'category_id' => Category::first()->id,
        'priority_id' => Priority::first()->id,
        'status' => 'open',
        'validation_status' => 'pending',
    ]);

    // 1. Admin validates into Open Pool
    $response = $this->actingAs($admin)->post("/admin/tickets/{$ticket->id}/validate", [
        'assign_mode' => 'open_pool',
        'admin_notes' => 'Tervalidasi tim software',
    ]);
    $response->assertRedirect();

    $ticket->refresh();
    expect($ticket->validation_status)->toBe('validated');
    expect($ticket->assigned_to)->toBeNull();

    // 2. Admin assigns directly to technician
    $response = $this->actingAs($admin)->post("/admin/tickets/{$ticket->id}/assign", [
        'assigned_to' => $tech->id,
        'assignment_note' => 'Mohon ditangani segera',
    ]);
    $response->assertRedirect();

    $ticket->refresh();
    expect($ticket->assigned_to)->toBe($tech->id);
    expect($ticket->status)->toBe('assigned');

    // 3. Admin releases back to open pool
    $response = $this->actingAs($admin)->post("/admin/tickets/{$ticket->id}/release");
    $response->assertRedirect();

    $ticket->refresh();
    expect($ticket->assigned_to)->toBeNull();
    expect($ticket->status)->toBe('open');
});

test('technician can claim ticket from open pool, invite team collaborator, and resolve', function () {
    $teknisiRole = Role::where('name', 'teknisi')->first();

    $ayu = User::firstOrCreate(['email' => 'ayu_claim@rsud.test'], [
        'name' => 'Ayu Claim',
        'password' => bcrypt('password'),
        'role_id' => $teknisiRole->id,
        'specialization' => 'SIMRS',
        'is_active' => true,
    ]);

    $yuda = User::firstOrCreate(['email' => 'yuda_collab@rsud.test'], [
        'name' => 'Yuda Collab',
        'password' => bcrypt('password'),
        'role_id' => $teknisiRole->id,
        'specialization' => 'Jaringan',
        'is_active' => true,
    ]);

    $ticket = Ticket::create([
        'ticket_number' => Ticket::generateTicketNumber(),
        'title' => 'Troubleshoot Jaringan & SIMRS',
        'description' => 'Test kolaborasi tim',
        'unit_id' => Unit::first()->id,
        'category_id' => Category::first()->id,
        'priority_id' => Priority::first()->id,
        'status' => 'open',
        'validation_status' => 'validated',
    ]);

    // 1. Ayu claims ticket from Open Pool
    $response = $this->actingAs($ayu)->post("/teknisi/tickets/{$ticket->id}/claim");
    $response->assertRedirect();

    $ticket->refresh();
    expect($ticket->assigned_to)->toBe($ayu->id);
    expect($ticket->status)->toBe('assigned');

    // 2. Ayu invites Yuda to collaborate
    $response = $this->actingAs($ayu)->post("/teknisi/tickets/{$ticket->id}/collaborators", [
        'collaborator_id' => $yuda->id,
    ]);
    $response->assertRedirect();

    $ticket->refresh();
    expect($ticket->collaborators->pluck('id'))->toContain($yuda->id);

    // 3. Yuda can see this ticket in his dashboard
    $response = $this->actingAs($yuda)->get('/teknisi/dashboard?scope=team');
    $response->assertStatus(200);
    $response->assertSee($ticket->ticket_number);

    // 4. Ayu updates status to resolved
    $response = $this->actingAs($ayu)->post("/teknisi/tickets/{$ticket->id}/status", [
        'status' => 'resolved',
        'resolution_notes' => 'Kabel LAN di-crimping ulang dan modul SIMRS dites normal.',
    ]);
    $response->assertRedirect();

    $ticket->refresh();
    expect(in_array($ticket->status, ['resolved', 'pending_review']))->toBeTrue();
});

