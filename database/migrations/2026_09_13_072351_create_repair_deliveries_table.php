<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Stores the customer's "I have received my device" confirmation,
        // including a required photo, from the Track Repair page.
        Schema::create('repair_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('photo');
            $table->boolean('disclaimer_accepted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_deliveries');
    }
};