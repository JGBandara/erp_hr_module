<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_division';
    protected $fillable = ['div_code', 'div_name','div_dep_id', 'div_head', 'div_remark', 'div_status'];
}
