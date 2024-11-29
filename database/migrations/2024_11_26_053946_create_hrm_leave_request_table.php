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
        Schema::create('hrm_leave_request', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->unique();
            $table->year('year');
            $table->integer('emp_id');
            $table->integer('leave_type_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->double('no_of_days');
            $table->string('purpose');
            $table->string('remark');
            $table->integer('location_id');
            $table->integer('covering_officer_id');
            $table->integer('created_by');
            $table->boolean('is_deleted')->default(false);
            $table->integer('deleted_by')->default(0);
            $table->integer('last_modified_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_leave_request');
    }
};
