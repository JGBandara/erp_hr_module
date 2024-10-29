<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalQualification extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_professional_qualification';
    protected $fillable = [
        'emp_id',
        'course_name',
        'level',
        'university',
        'comp_year',
        'status',
    ];
}
