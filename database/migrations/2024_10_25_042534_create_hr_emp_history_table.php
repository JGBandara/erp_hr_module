<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_emp_history', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->integer('type_id');
            $table->date('date_time');
            $table->integer('department_id');
            $table->integer('division');
            $table->integer('designation_id');
            $table->string('grade');
            $table->integer('workstation_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_emp_history');
    }
};
