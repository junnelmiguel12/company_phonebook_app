<?php

namespace App\Repositories;

use App\Interfaces\CompanyInterface;
use Exception;

class CompanyRepository extends BaseRepository implements CompanyInterface
{
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('departments', 'departments.employees')->get();
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
        return $this->model->with('departments', 'departments.employees','employees')->find($id);
    }

    public function update(int $id, array $data): mixed
    {
        try{
            return $this->model->findOrFail($id)->update($data);
        } catch(Exception $error) {
            return $this->errorResponse($error);
        }
    }
}
