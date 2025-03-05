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
        Schema::create('hr_mst_division', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('department_id');
            $table->integer('head_of_department_id');
            $table->string('remark')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('created_by');
            $table->boolean('is_deleted')->default(false);
            $table->integer('deletedBy')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_division');
    }
};
