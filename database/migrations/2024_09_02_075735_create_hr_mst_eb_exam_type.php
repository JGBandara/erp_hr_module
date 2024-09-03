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
        Schema::create('hr_mst_eb_exam_type', function (Blueprint $table) {
            $table->id();
            $table->string('ext_name');
            $table->integer('ext_emp_cat_id');
            $table->integer('ext_grade_id');
            $table->string('ext_remark');
            $table->integer('ext_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_eb_exam_type');
    }
};
