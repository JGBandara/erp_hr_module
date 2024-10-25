<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hr_mst_department_has_designation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->on('hr_mst_department');
            $table->foreignId('designation_id')->constrained()->on('hr_mst_designation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_mst_department_has_designation');
    }
};
