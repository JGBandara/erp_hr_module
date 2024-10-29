<?php

namespace App\Services;

use App\Models\ALExamination;
use App\Models\OLExamination;
use App\Models\PersonalDetails;
use App\Models\ProfessionalQualification;

class QualificationService
{
    public function storeOL(array $data){
        $empId = $data['emp_id'];
        PersonalDetails::find($empId)->olResults()->delete();

        foreach ($data['ol']as $result){
            OLExamination::create([
                'subject'=>$result['Subject'],
                'grade'=>$result['Grade'],
                'emp_id'=>$empId,
            ]);
        }
    }
    public function getOLResults(int $id){
        $emp = PersonalDetails::find($id);
        return $emp->olResults;
    }
    public function storeAL(array $data){
        $empId = $data['emp_id'];
        PersonalDetails::find($empId)->alResults()->delete();

        foreach ($data['al']as $result){
            ALExamination::create([
                'subject'=>$result['Subject'],
                'grade'=>$result['Grade'],
                'emp_id'=>$empId,
            ]);
        }
    }
    public function getALResults(int $id){
        $emp = PersonalDetails::find($id);
        return $emp->alResults;
    }
    public function storeProfessionQualification(array $data){
        $empId = $data['emp_id'];
        PersonalDetails::find($empId)->professionalQualifications()->delete();

        foreach ($data['prof']as $result){
            ProfessionalQualification::create([
                'course_name'=>$result['Course Name'],
                'level'=>$result['Degree/Diploma'],
                'university'=>$result['University/Institute'],
                'comp_year'=>$result['Complete Year'],
                'status'=>$result['Status'],
                'emp_id'=>$empId,
            ]);
        }
    }
    public function getProfessionalQualifications(int $id){
        $emp = PersonalDetails::find($id);
        return $emp->professionalQualifications;
    }
}
