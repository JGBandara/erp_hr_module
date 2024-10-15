<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignType extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_resign_type';
    protected $fillable = ['rsg_name', 'rsg_remarks', 'rsg_status'];
  
}
