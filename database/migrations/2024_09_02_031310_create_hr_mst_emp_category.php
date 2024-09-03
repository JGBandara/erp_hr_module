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
        Schema::create('hr_mst_emp_category', function (Blueprint $table) {
            $table->id();
            $table->string('emp_code')->unique();
            $table->string('emp_name');
            $table->string('emp_level');
            $table->integer('emp_rank');
            $table->string('emp_remark');
            $table->integer('emp_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_emp_category');
    }
};
