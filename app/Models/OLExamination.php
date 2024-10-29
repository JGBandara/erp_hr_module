<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OLExamination extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_ol_examination';
    protected $fillable=[
        'subject',
        'grade',
        'emp_id'
    ];
}
