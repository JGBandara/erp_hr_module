<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_emp_category';
    protected $fillable = [
        'code',
        'name',
        'level',
        'rank',
        'remark',
        'active',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];

    public function designations(){
        return $this->hasMany(Designation::class,'des_emp_cat_id','id');
    }

}
