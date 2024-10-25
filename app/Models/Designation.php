<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'hr_mst_designation';
    protected $fillable = ['des_emp_cat_id', 'des_code', 'des_name', 'des_salary_scale_id', 'des_ot_allowed', 'des_early_ot_allowed', 'des_carder', 'des_rank', 'des_dep_id', 'des_duties', 'des_remark', 'des_status'];

    public function departments()
    {
        return $this->belongsToMany(Department::class,'hr_mst_department_has_designation');
    }
}
