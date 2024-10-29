<?php
namespace App\Services;

use App\Models\EmployeeHistory;
use App\Models\PersonalDetails;

class EmployeeHistoryService
{
    private PersonalDetailsService $personalDetailsService;

    public function __construct(PersonalDetailsService $personalDetailsService)
    {
        $this->personalDetailsService = $personalDetailsService;
    }

    public function store(array $data){
        $empId = $data['emp_id'];
        PersonalDetails::find($empId)->history()->delete();
        foreach ($data['data'] as $item) {
            EmployeeHistory::create([
                'emp_id' => $empId,
                'type_id' => $item['Type'],
                'date_time' => $item['Date'],
                'department_id' => $item['Department'],
                'division' => $item['Division'],
                'designation_id' => $item['Designation'],
//                'grade' => $item['Grade'],
                'grade' => 1,
                'workstation_id' => $item['Workstation'],
            ]);
        }
        return $data['data'];
    }
    public function getAllBelongsTo(int $empId){
        return $this->personalDetailsService->getAllHistory($empId);
    }
}
