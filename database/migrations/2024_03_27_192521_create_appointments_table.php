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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('flag');
            $table->string('reference_number')->unique();
            $table->string('company_name')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->json('address')->nullable();
            $table->json('service_details')->nullable();
            $table->json('availability')->nullable();
            $table->json('extras')->nullable();
            $table->json('extras_2')->nullable();
            $table->text('additional_instructions')->nullable();
            $table->json('image_paths')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
