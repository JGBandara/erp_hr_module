<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbExamType extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_eb_exam_type';
    protected $fillable = [
        'name',
        'remark',
        'active',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];

}
