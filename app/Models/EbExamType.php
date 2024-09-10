<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbExamType extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_eb_exam_type';
    protected $fillable = [ 'ext_name','ext_emp_cat_id','ext_grade_id', 'ext_remark', 'ext_status'];
 
}
class EbExamTypeDesignation extends Model
{
    protected $table = 'hr_mst_eb_type_designation';
    protected $fillable= [ 'extd_exam_type_id','extd_designation_id', 'extd_remark', 'extd_status'];
    
}
class EbExamTypeSubject extends Model
{
    protected $table = 'hr_mst_eb_type_subject';
    protected $fillable= [ 'exts_exam_type_id', 'exts_subject','exts_remark', 'exts_status'];
}