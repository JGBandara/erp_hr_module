<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForApproval extends Model
{
    use HasFactory;
    protected $table = 'hr_for_approval';
    protected $fillable = [
        'request_id',
        'request_type_id',
        'level',
        'is_approved',
        'is_pending',
        'action_by',
        'remark',
    ];
    public function actionOfficer(){
        return $this->hasOne(PersonalDetails::class,'action_by','id');
    }
    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'request_id', 'id');
    }
}
