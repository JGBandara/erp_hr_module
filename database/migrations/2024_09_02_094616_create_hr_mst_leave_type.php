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
            $table->string('lv_code');
            $table->string('lv_name');
            $table->integer('period_id')->default(0);
            $table->string('lv_salary_deduct');
            $table->integer('lv_count_working_days');
            $table->decimal('lv_default_count');
            $table->integer('lv_has_limit');
            $table->integer('lv_allow_attendance_bonus');
            $table->string('lv_remarks');
            $table->integer('lv_status')->default(1);
            $table->integer('lv_is_deleted')->default(0);
            $table->integer('lv_modified_by')->nullable();
            $table->integer('lv_deleted_by')->nullable();
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
