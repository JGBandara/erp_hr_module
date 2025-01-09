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
        Schema::create('hr_for_approval', function (Blueprint $table) {
            $table->id();
            $table->integer('request_id');
            $table->integer('request_type_id');
            $table->integer('level')->default(1);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_pending')->default(true);
            $table->integer('action_by')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_for_approval');
    }
};
