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
        Schema::create('claim_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('claim_id');
            $table->string('service_code')->nullable();
            $table->string('description');
            $table->enum('category', ['Consultation', 'Lab', 'Drug', 'Procedure', 'Other']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('claim_id')->references('id')->on('claims')->onDelete('cascade');
            $table->foreign('service_code')->references('service_code')->on('tariffs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_items');
    }
};
