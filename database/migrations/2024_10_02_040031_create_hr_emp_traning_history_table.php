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
        Schema::create('hr_emp_training_history', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('program');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('bond_value');
            $table->integer('emp_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_emp_training_history');
    }
};
