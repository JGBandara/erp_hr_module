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
        Schema::create('hr_emp_professional_qualification', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('course_name');
            $table->string('level');
            $table->string('university');
            $table->year('comp_year');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_emp_professional_qualification');
    }
};
