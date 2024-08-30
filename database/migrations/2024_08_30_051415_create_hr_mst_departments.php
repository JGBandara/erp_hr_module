<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
            public function up()
{
    if (!Schema::hasTable('hr_mst_departments')) {
        Schema::create('hr_mst_departments', function (Blueprint $table) {
            $table->id();
            $table->string('dep_code');
            $table->string('dep_name');
            $table->string('dep_remark');
            $table->integer('dep_status');
            $table->timestamps();
        });
    }
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_departments');
    }
};
