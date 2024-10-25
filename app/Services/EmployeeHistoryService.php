<?php
namespace App\Services;

use App\Models\EmployeeHistory;

class EmployeeHistoryService
{
    public function store(array $data){
        $empId = $data['emp_id'];
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
}
