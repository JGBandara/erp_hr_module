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
        Schema::create('hr_mst_designation', function (Blueprint $table) {
            $table->id();
            $table->string('des_emp_cat_id');
            $table->string('des_code')->unique();
            $table->string('des_name');
            $table->string('des_salary_scale_id');
            $table->string('des_ot_allowed');
            $table->string('des_early_ot_allowed');
            $table->integer('des_carder');
            $table->integer('des_rank');
            $table->string('des_duties');
            $table->string('des_remark');
            $table->string('des_status')->default(1);
            $table->integer('des_is_deleted')->default(0);
            $table->integer('des_modified_by')->nullable();
            $table->integer('des_deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_designation');
    }
};
