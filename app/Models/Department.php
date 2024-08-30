<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_department';
    protected $fillable = ['dep_code', 'dep_name', 'dep_remark', 'dep_status'];
}
