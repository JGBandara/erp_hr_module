<?php

namespace App\Services\Interfaces;

interface Service
{
    public function store(array $data):array;
    public function update(array $data);
    public function getAll();
    public function getById($id);
    public function delete($id, $actionBy);
}
