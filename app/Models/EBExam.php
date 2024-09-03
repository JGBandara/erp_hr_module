<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EBExam extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_eb_exam';
    protected $fillable = [ 'ebx_date','ebx_type_id','ebx_time','ebx_venue', 'ebx_remark', 'ebx_status'];
}
