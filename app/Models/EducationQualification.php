<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationQualification extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_education_qualification';
    protected $fillable = [ 'qua_name', 'qua_remark', 'qua_status'];
}
