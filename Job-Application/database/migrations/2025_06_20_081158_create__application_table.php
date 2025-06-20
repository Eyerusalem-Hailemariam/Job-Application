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
    Schema::create('applications', function (Blueprint $table) {
        $table->id(); 
        $table->unsignedBigInteger('applicant_id');
        $table->unsignedBigInteger('job_id');

        $table->string('resume_link');
        $table->string('cover_letter')->nullable();

        $table->enum('status', ['Applied', 'Interview', 'Reviewed', 'Rejected', 'Hired'])->default('Applied');
        $table->timestamps();

      
        $table->foreign('applicant_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_application');
    }
};
