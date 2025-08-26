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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('service_code')->unique();
            $table->string('description');
            $table->enum('category', ['Consultation', 'Lab', 'Drug', 'Procedure', 'Other']);
            $table->decimal('unit_price', 10, 2);
            $table->date('effective_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
