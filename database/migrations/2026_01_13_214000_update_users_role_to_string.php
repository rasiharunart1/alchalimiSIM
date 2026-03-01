<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PostgreSQL enum-based check constraints need to be dropped manually
        if (config('database.default') === 'pgsql') {
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        }

        Schema::table('users', function (Blueprint $table) {
            // - [x] Register: Update registration view with Role & Token fields <!-- id: 244 -->
            // - [ ] UI/UX Enhancements & Notifications <!-- id: 250 -->
            //     - [ ] Add "Dashboard" link to Topbar <!-- id: 251 -->
            //     - [ ] Implement Notification System (Threads, Messages, Unit Usaha) <!-- id: 252 -->
            //         - [ ] Database: Add `notifications` table or unread trackers <!-- id: 253 -->
            //         - [ ] UI: Add Notification dropdown/modal in Topbar <!-- id: 254 -->
            //         - [ ] Logic: Trigger notifications for new content <!-- id: 255 -->
            // Change to string to be more flexible, or we could use enum with the new value
            // but string is safer for long-term if we keep adding roles.
            $table->string('role')->default('wali_santri')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert logic is complex for enums in pgsql, leaving as string is usually fine
        });
    }
};
