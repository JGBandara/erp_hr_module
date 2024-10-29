<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ALExamination extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_al_examination';
    protected $fillable=[
        'subject',
        'grade',
        'emp_id'
    ];
}
