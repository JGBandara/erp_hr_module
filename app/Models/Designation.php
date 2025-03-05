<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'hr_mst_designation';
    protected $fillable = [
        'employee_category_id',
        'code',
        'name',
        'salary_scale_id',
        'ot_allowed',
        'early_ot_allowed',
        'carder',
        'rank',
        'duties',
        'remark',
        'active',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];


    public function departments()
    {
        return $this->belongsToMany(Department::class,'hr_mst_department_has_designation','designation_id','department_id');
    }
    public function employees(){
        return $this->hasMany(EmployeeHistory::class,'designation_id','id')->with('employee');
    }
}
