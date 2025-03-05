<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_department';
    protected $fillable = [
        'code',
        'name',
        'remark',
        'active',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];

    public function designations(){
        return $this->belongsToMany(Designation::class,'hr_mst_department_has_designation');
    }
}
