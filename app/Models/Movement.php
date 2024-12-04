<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    protected $table = 'hr_movement';
    protected $fillable = [
        'emp_id',
        'out_datetime',
        'out_location',
        'in_datetime',
        'in_location',
        'reason',
    ];
}
