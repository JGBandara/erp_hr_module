<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_dependent';
    protected $fillable = [
        'dependant_name',
        'relation',
        'dob',
        'occupation',
        'emp_id',
    ];
}
