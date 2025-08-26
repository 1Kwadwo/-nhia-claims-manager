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
        Schema::create('claims', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('claim_number')->unique();
            $table->uuid('provider_id');
            $table->uuid('beneficiary_id');
            $table->date('date_of_service');
            $table->enum('visit_type', ['OPD', 'IPD', 'Maternity', 'Referral']);
            $table->json('diagnoses')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'UnderReview', 'Approved', 'Rejected', 'Paid'])->default('Draft');
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('restrict');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
