<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique(); // e.g. AHMR-20260905-0001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('device_brand');
            $table->string('device_model');
            $table->text('issue');
            $table->text('diagnosis')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->string('status')->default('requested');
            // Possible statuses: requested, received, diagnosed, repairing,
            // ready-for-pickup, completed, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};