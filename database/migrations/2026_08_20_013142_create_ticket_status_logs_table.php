<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('ticket_status_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ticket_id')->constrained();
        $table->string('status');
        $table->foreignId('changed_by')->nullable()->constrained('users');
        $table->text('note')->nullable();
        $table->timestamps();
    });
}
};
