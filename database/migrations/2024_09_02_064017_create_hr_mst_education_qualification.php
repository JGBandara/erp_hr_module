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
        Schema::create('hr_mst_education_qualification', function (Blueprint $table) {
            $table->id();
            $table->string('qua_name');
            $table->string('qua_remark');
            $table->string('qua_status')->default(1);
            $table->integer('qua_is_deleted')->default(0);
            $table->integer('qua_modified_by')->nullable();
            $table->integer('qua_deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_education_qualification');
    }
};
