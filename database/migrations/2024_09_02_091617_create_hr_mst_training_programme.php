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
        Schema::create('hr_mst_training_programme', function (Blueprint $table) {
            $table->id();
            $table->string('htp_name');
            $table->integer('htp_category_id');
            $table->integer('htp_type_id');
            $table->integer('htp_is_domestic');
            $table->integer('htp_country_id');
            $table->string('htp_institute');
            $table->string('htp_period');
            $table->decimal('htp_amount');
            $table->integer('htp_bond_required');
            $table->integer('htp_bond_value');
            $table->integer('htp_bond_period');
            $table->string('htp_remark');
            $table->integer('htp_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mst_training_programme');
    }
};
