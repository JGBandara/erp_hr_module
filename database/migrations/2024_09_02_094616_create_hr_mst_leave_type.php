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
        Schema::create('hr_mst_leave_type', function (Blueprint $table) {
            $table->id();
            $table->string('lv_name');
            $table->integer('lv_salary_deduct');
            $table->integer('lv_count_working_days');
            $table->decimal('lv_default_count');
            $table->integer('lv_has_limit');
            $table->integer('lv_allow_attendance_bonus');
            $table->string('lv_remarks');
            $table->integer('lv_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_leave_type');
    }
};
