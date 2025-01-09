<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequestAttachments extends Model
{
    use HasFactory;
    protected $table = 'hr_leave_request_attachments';
    protected $fillable = [
        'request_id',
        'file_path',
    ];

}
