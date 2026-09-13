<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->string('approval_email')->nullable()->after('user_id');
            $table->string('otp_code')->nullable()->after('approval_email');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            $table->timestamp('approved_at')->nullable()->after('otp_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn(['approval_email', 'otp_code', 'otp_expires_at', 'approved_at']);
        });
    }
};