<?php

namespace App\Services;

use App\Interfaces\CompanyInterface;
use App\Repositories\CompanyRepository;
use App\Models\Company;
use App\Constants\ResponseConstants as response;

class CompanyService extends BaseService implements CompanyInterface
{
    public function __construct()
    {
        $this->repository = new CompanyRepository(new Company());
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->repository->getById($id);

        if (!$result) {
            $this->doErrorLog('Company not found.', [$result]);
            return $this->apiResponse(response::REQUEST_NOT_FOUND, 'Company not found.');
        }

        return array_merge($this->apiResponse(response::SUCCESS_CODE, 'Success.'), ['data' => $result]);
    }

    public function create(array $data): array
    {
        $result = $this->repository->create($data);

        if (!$result) {
            $this->doErrorLog('Create company failed.', [$result]);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Create company failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Company created.');        
    }

    public function update(int $id, array $data): array
    {
        $result = $this->repository->update($id, $data);

        if (is_array($result) === true && array_key_exists('code', $result) === true) {
            $this->doErrorLog('Update company failed.', $result);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Update company failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Company updated.');  
    }

    public function delete(int $id): array 
    {
        $result = $this->repository->delete($id);

        if (is_array($result) === true && array_key_exists('code', $result) === true) {
            $this->doErrorLog('Delete company failed.', $result);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Delete company failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Company deleted.');
    }
}
