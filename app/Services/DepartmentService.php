<?php

namespace App\Services;

use App\Repositories\DepartmentRepository;
use App\Models\Department;
use App\Constants\ResponseConstants as response;
use App\Interfaces\DepartmentInterface;

class DepartmentService extends BaseService implements DepartmentInterface
{
    public function __construct()
    {
        $this->repository = new DepartmentRepository(new Department());
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->repository->getById($id);

        if (!$result) {
            $this->doErrorLog('Department not found.', [$result]);
            return $this->apiResponse(response::REQUEST_NOT_FOUND, 'Department not found.');
        }

        return array_merge($this->apiResponse(response::SUCCESS_CODE, 'Success.'), ['data' => $result]);
    }

    public function create(array $data): array
    {
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $data['company_id'] = $user->company_id;

        $result = $this->repository->create($data);

        if (!$result) {
            $this->doErrorLog('Create department failed.', [$result]);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Create department failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Department created.');        
    }

    public function update(int $id, array $data): array
    {
        $result = $this->repository->update($id, $data);

        if (is_array($result) === true && array_key_exists('code', $result) === true) {
            $this->doErrorLog('Update department failed.', $result);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Update department failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Department updated.');  
    }

    public function delete(int $id): array 
    {
        $result = $this->repository->delete($id);

        if (is_array($result) === true && array_key_exists('code', $result) === true) {
            $this->doErrorLog('Delete department failed.', $result);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Delete department failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Department deleted.');
    }
}
