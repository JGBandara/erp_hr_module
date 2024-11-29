<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_employee_category';
    protected $fillable = ['emp_cat_code', 'emp_cat_name', 'emp_cat_level','emp_cat_rank','emp_cat_remark', 'emp_cat_status'];

    public function designations(){
        return $this->hasMany(Designation::class,'des_emp_cat_id','id');
    }

}
