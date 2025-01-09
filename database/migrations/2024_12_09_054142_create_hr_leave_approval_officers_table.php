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
        Schema::create('hr_leave_approval_offices', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->integer('officer_id');
            $table->integer('level');
            $table->boolean('status')->default(true);
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->integer('location_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_leave_approve');
    }
};
