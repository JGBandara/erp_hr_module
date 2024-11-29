<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\CoveringOfficer;
use App\Models\Designation;
use App\Models\EmployeeCategory;
use App\Models\PersonalDetails;

class CoveringOfficerService
{
    public function getOfficersByCategotyId(int $id, int $empId){
        $empCategory = EmployeeCategory::find($id);
        $arr = [];
        foreach($empCategory->designations as $designation){

            $designationsWithEmployees = Designation::find($designation->id)
                ->employees()
                ->with('employee')
                ->get();

            foreach ($designationsWithEmployees as $employeeHistory) {
                $emp = $employeeHistory->employee;
                if($empId == 0){
                    $emp['active'] = false;
                }else{
                    try {
                        $officer = $this->getCoveringOfficerByEmployeeAndOfficerId($empId,$emp['id']);
                        if(!$officer->is_deleted){
                            $emp['active'] = true;
                        }else{
                            $emp['active'] = false;
                        }
                    }catch (CRUDException $e){
                        $emp['active'] = false;
                    }
                }
                $arr[] = $emp;
            }
        }
        $arr = array_map("unserialize", array_unique(array_map("serialize", $arr)));
        return $arr;
    }

    public function store(int $empId, int $coveringOfficerId, int $createdBy, int $locationId){
        CoveringOfficer::create([
            'emp_id'=>$empId,
            'covering_officer_id'=>$coveringOfficerId,
            'created_by'=>$createdBy,
            'location_id'=>$locationId,
        ]);
    }
    public function updateStatus(int $id, bool $status, int $deletedBy){
        $coveringOfficer = CoveringOfficer::find($id);
        $coveringOfficer->is_deleted = $status;
        $coveringOfficer->deleted_by = $deletedBy;

        $coveringOfficer->update();
    }
    public function getCoveringOfficerByEmployeeAndOfficerId($empId, $officerId){
        return CoveringOfficer::where([
            ['emp_id','=',$empId],
            ['covering_officer_id','=',$officerId]
        ])->firstOr(function(){
            throw new CRUDException('Record Not Found');
        });
    }
    public function getOfficersBelongsTo(int $emp_id){
        $personalDetails = PersonalDetails::find($emp_id);
        return $personalDetails->coveringOfficers;
    }
}
