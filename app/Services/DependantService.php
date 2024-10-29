<?php

namespace App\Services;

use App\Models\Dependent;
use App\Models\PersonalDetails;

class DependantService
{
    public function store(array $data){
        $emp_id = $data['emp_id'];
        PersonalDetails::find($emp_id)->dependents()->delete();
        foreach ($data['data'] as $dependant){
            Dependent::create([
                'emp_id'=>$emp_id,
                'dependant_name'=>$dependant['Dependence Name'],
                'relation'=>$dependant['Relation'],
                'dob'=>$dependant['Date Of Birth'],
                'occupation'=>$dependant['Occupation'],
            ]);
        }
    }
    public function getAll(int $id){
        $emp = PersonalDetails::find($id);
        return $emp->dependents;
    }
}
