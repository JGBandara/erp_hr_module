<?php

namespace App\Services\abstract;

use App\Services\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class CrudService
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

     public function store(array $data): array
     {
         return $this->model::create($data)->toArray();
     }

     public function update(array $data)
     {
         $updateModel = $this->model::find($data['id']);
         if(!$updateModel){
             throw new ModelNotFoundException();
         }
         $updateModel->update($data);
     }

     public function getAll()
     {
         return $this->model::where('is_deleted', false)->get();
     }

     public function getById($id)
     {
        return $this->model::where([
            'is_deleted'=>false,
            'id'=>$id,
        ])->first();
     }

     public function delete($id, $actionBy)
     {
         $deleteModel = $this->getById($id)->toArray();
         if(!$deleteModel){
             throw new ModelNotFoundException();
         }
         $deleteModel['deleted_by'] = $actionBy;
         $deleteModel['is_deleted'] = true;
         $this->update($deleteModel);
     }
 }
