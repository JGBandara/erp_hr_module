<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_division';
    protected $fillable = [
        'code',
        'name',
        'department_id',
        'head_of_department_id',
        'remark',
        'active',
        'created_by',
        'is_deleted',
        'deletedBy',
    ];
}
