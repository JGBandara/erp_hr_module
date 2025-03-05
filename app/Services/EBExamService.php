<?php

namespace App\Services;

use App\Models\EBExam;
use App\Services\Interfaces\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EBExamService implements Service
{
    public function store(array $data):array{
        return EBExam::create($data)->toArray();
    }

    public function update(array $data)
    {
        $ebExam = $this->getById($data['id']);
        if(!$ebExam){
            throw new ModelNotFoundException("EB Exam type not found!");
        }
        $ebExam->update($data);
    }

    public function getAll()
    {
        return EBExam::select([
            'id',
            'name',
            'remark',
            'active',
        ])->where('is_deleted',false)->get();
    }

    public function getById($id)
    {
        return EBExam::select([
            'id',
            'name',
            'remark',
            'active',
        ])->where(['is_deleted'=>false,'id'=>$id])->first();
    }

    public function delete($id, $actionBy)
    {
        $ebExam = $this->getById($id)->toArray();
        $ebExam['is_deleted'] = true;
        $ebExam['deleted_by'] = $actionBy;
        $this->update($ebExam);
    }
}
