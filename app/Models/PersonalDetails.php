<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_personal_details';
    protected $fillable = [
        'personal_file_no',
        'serial_no',
        'title',
        'initials',
        'surname',
        'full_name',
        'nic',
        'dob',
        'civil_status',
        'gender',
        'religion',
        'permanent_address',
        'mobile',
        'personal_email',
        'current_address',
        'residence_phone_number',
        'emerg_phone_and_cont_num',
    ];
    public function history(){
        return $this->hasMany(EmployeeHistory::class,'emp_id','id');
    }
    public function olResults(){
        return $this->hasMany(OLExamination::class,'emp_id','id');
    }
    public function alResults(){
        return $this->hasMany(ALExamination::class,'emp_id','id');
    }
    public function professionalQualifications(){
        return $this->hasMany(ProfessionalQualification::class,'emp_id','id');
    }
    public function dependents(){
        return $this->hasMany(Dependent::class,'emp_id','id');
    }
}
