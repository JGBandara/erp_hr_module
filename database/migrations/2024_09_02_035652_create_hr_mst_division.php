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
            $table->string('div_code')->unique();
            $table->string('div_name');
            $table->integer('div_dep_id');
            $table->integer('div_head');
            $table->string('div_remark');
            $table->integer('div_status');
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