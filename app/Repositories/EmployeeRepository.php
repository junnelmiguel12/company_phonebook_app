<?php

namespace App\Repositories;

use App\Interfaces\EmployeeInterface;
use Exception;

class EmployeeRepository extends BaseRepository implements EmployeeInterface
{
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('company', 'department')->where('company_id', auth()->user()->company_id)->get();
    }

    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    public function delete(int $id): mixed
    {
        try{
            return $this->model->findOrFail($id)->delete();
        } catch(Exception $error) {
            return $this->errorResponse($error);
        }
    }

    public function getById(int $id)
    {
        return $this->model->with('company', 'department')->find($id);
    }

    public function update(int $id, array $data): mixed
    {
        try{
            return $this->model->findOrFail($id)->update($data);
        } catch(Exception $error) {
            return $this->errorResponse($error);
        }
    }

    public function getWithWhereData(array $whereData)
    {
        return $this->model->where($whereData)->get();
    }

    public function getEmployeeByIds(array $employeeIds)
    {
        return $this->model->whereIn('id', $employeeIds)->get();
    }
}
