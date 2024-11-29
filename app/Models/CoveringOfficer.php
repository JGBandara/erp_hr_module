<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoveringOfficer extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_covering_officer';
    protected $fillable = [
        'emp_id',
        'covering_officer_id',
        'created_by',
        'modified_by',
        'deleted_by',
        'is_deleted',
        'location_id',
    ];
}
