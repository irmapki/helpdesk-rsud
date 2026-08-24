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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->string('ticket_number')->unique();
        $table->string('title');
        $table->text('description');
        $table->foreignId('category_id')->constrained();
        $table->foreignId('priority_id')->constrained();
        $table->foreignId('unit_id')->constrained();
        $table->foreignId('created_by')->nullable()->constrained('users');
        $table->foreignId('assigned_to')->nullable()->constrained('users');
        $table->string('status')->default('open');
        $table->timestamp('assigned_at')->nullable();
        $table->timestamp('resolved_at')->nullable();
        $table->timestamp('closed_at')->nullable();
        $table->timestamps();
    });
}
};
