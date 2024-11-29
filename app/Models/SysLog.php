<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysLog extends Model
{
    use HasFactory;
    protected $table = 'hr_sys_log';
    protected $fillable = [
        'user_id',
        'location_id',
        'remark',
    ];
}
