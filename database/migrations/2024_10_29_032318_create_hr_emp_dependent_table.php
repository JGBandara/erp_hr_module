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
        Schema::create('hr_emp_dependent', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('dependant_name');
            $table->string('relation');
            $table->date('dob');
            $table->string('occupation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_emp_dependent');
    }
};
