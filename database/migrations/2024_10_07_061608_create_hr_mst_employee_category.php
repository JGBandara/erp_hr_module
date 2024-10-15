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
        Schema::create('hr_mst_employee_category', function (Blueprint $table) {
            $table->id();
            $table->string('emp_cat_code');
            $table->string('emp_cat_name');
            $table->string('emp_cat_level');
            $table->string('emp_cat_rank');
            $table->string('emp_cat_remark');
            $table->string('emp_cat_status')->default(1);
            $table->integer('emp_cat_is_deleted')->default(0);
            $table->integer('emp_cat_modified_by')->nullable();
            $table->integer('emp_cat_deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_employee_category');
    }
};
