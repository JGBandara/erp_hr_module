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
        Schema::create('hr_mst_resign_type', function (Blueprint $table) {
            $table->id();
            $table->string('rsg_name');
            $table->string('rsg_remarks');
            $table->integer('rsg_status')->default(1);
            $table->integer('rsg_is_deleted')->default(0);
            $table->integer('rsg_modified_by')->nullable();
            $table->integer('rsg_deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_resign_type');
    }
};
