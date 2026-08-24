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
        // Update users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'specialization')) {
                $table->string('specialization')->nullable()->after('unit_id'); // e.g. Hardware, Jaringan, SIMRS
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('specialization');
            }
        });

        // Update units table if description/location doesn't exist
        Schema::table('units', function (Blueprint $table) {
            if (!Schema::hasColumn('units', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('units', 'location')) {
                $table->string('location')->nullable()->after('description'); // e.g. Gedung A Lantai 1
            }
        });

        // Update categories table if description doesn't exist
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });

        // Update priorities table if color/description doesn't exist
        Schema::table('priorities', function (Blueprint $table) {
            if (!Schema::hasColumn('priorities', 'color')) {
                $table->string('color')->default('gray')->after('sla_hours'); // red, yellow, green, blue
            }
            if (!Schema::hasColumn('priorities', 'description')) {
                $table->text('description')->nullable()->after('color');
            }
        });

        // Update tickets table for guest support and triage workflow
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'guest_name')) {
                $table->string('guest_name')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('tickets', 'guest_email')) {
                $table->string('guest_email')->nullable()->after('guest_name');
            }
            if (!Schema::hasColumn('tickets', 'guest_phone')) {
                $table->string('guest_phone')->nullable()->after('guest_email');
            }
            if (!Schema::hasColumn('tickets', 'attachment')) {
                $table->string('attachment')->nullable()->after('description');
            }
            if (!Schema::hasColumn('tickets', 'validation_status')) {
                $table->string('validation_status')->default('pending')->after('status'); // pending, validated, rejected
            }
            if (!Schema::hasColumn('tickets', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('validation_status');
            }
            if (!Schema::hasColumn('tickets', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('admin_notes');
            }
            if (!Schema::hasColumn('tickets', 'rating')) {
                $table->unsignedTinyInteger('rating')->nullable()->after('closed_at');
            }
            if (!Schema::hasColumn('tickets', 'feedback')) {
                $table->text('feedback')->nullable()->after('rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'specialization', 'is_active']);
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn(['description', 'location']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['description']);
        });

        Schema::table('priorities', function (Blueprint $table) {
            $table->dropColumn(['color', 'description']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'guest_name',
                'guest_email',
                'guest_phone',
                'attachment',
                'validation_status',
                'admin_notes',
                'rejection_reason',
                'rating',
                'feedback',
            ]);
        });
    }
};
