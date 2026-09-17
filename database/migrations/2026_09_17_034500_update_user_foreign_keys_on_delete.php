<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            return;
        }

        // 1. Tickets table: assigned_to & created_by set null on delete
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_assigned_to_foreign');
            $table->dropForeign('tickets_created_by_foreign');

            $table->foreign('assigned_to')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });

        // 2. Ticket Status Logs table: changed_by set null on delete
        Schema::table('ticket_status_logs', function (Blueprint $table) {
            $table->dropForeign('ticket_status_logs_changed_by_foreign');

            $table->foreign('changed_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });

        // 3. Ticket Collaborators table: user_id cascade on delete
        Schema::table('ticket_collaborators', function (Blueprint $table) {
            $table->dropForeign('ticket_collaborators_user_id_foreign');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });

        // 4. Ticket Technician table: user_id cascade on delete if exists
        if (Schema::hasTable('ticket_technician')) {
            Schema::table('ticket_technician', function (Blueprint $table) {
                try {
                    $table->dropForeign('ticket_technician_user_id_foreign');
                    $table->foreign('user_id')
                          ->references('id')
                          ->on('users')
                          ->cascadeOnDelete();
                } catch (\Throwable $e) {}
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropForeign(['created_by']);

            $table->foreign('assigned_to')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });

        Schema::table('ticket_status_logs', function (Blueprint $table) {
            $table->dropForeign(['changed_by']);
            $table->foreign('changed_by')->references('id')->on('users');
        });

        Schema::table('ticket_collaborators', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
