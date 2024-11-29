<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePic extends Model
{
    use HasFactory;

    protected $table = 'hr_emp_profile_image';

    protected $fillable = [
        'emp_id',
        'img_key',
    ];
}
