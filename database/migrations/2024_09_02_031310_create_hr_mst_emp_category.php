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
            $table->string('code')->unique();
            $table->string('name');
            $table->string('level');
            $table->integer('rank');
            $table->string('remark');
            $table->boolean('active')->default(true);
            $table->integer('created_by');
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
        Schema::dropIfExists('hr_mst_emp_category');
    }
};
