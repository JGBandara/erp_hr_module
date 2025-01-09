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
        Schema::create('hr_mst_leave_balance', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->integer('leave_type_id');
            $table->double('count');
            $table->integer('location_id');
            $table->integer('created_by');
            $table->integer('modified_by')->default(0);
            $table->boolean('is_deleted')->default(false);
            $table->integer('deleted_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_leave_balance');
    }
};
