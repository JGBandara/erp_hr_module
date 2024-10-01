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
        Schema::create('hr_emp_personal_details', function (Blueprint $table) {
            $table->id();
            $table->string('personal_file_no');
            $table->string('serial_no');
            $table->string('title');
            $table->string('initials');
            $table->string('surname');
            $table->string('full_name');
            $table->string('nic');
            $table->date('dob');
            $table->enum('civil_status',['single','married']);
            $table->enum('gender',['male','female']);
            $table->string('religion');
            $table->string('permanent_address');
            $table->string('mobile');
            $table->string('personal_email');
            $table->string('current_address');
            $table->string('residence_phone_number');
            $table->string('emerg_phone_and_cont_num')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_emp_personal_details');
    }
};
