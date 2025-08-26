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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nhis_number')->unique();
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('sex', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('scheme_type', ['NHIS', 'Private']);
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
