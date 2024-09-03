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
        Schema::create('hr_mst_eb_exam', function (Blueprint $table) {
            $table->id();
            $table->date('ebx_date');
            $table->integer('ebx_type_id');
            $table->time('ebx_time');
            $table->string('ebx_venue');
            $table->string('ebx_remark');
            $table->integer('ebx_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_eb_exam');
    }
};
