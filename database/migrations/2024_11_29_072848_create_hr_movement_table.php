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
        Schema::create('hr_movement', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->dateTime('out_datetime');
            $table->string('out_location')->nullable();
            $table->dateTime('in_datetime');
            $table->string('in_location')->nullable();
            $table->string('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_movement');
    }
};
