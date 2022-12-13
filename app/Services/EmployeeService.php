<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use App\Models\Employee;
use App\Constants\ResponseConstants as response;
use App\Interfaces\EmployeeInterface;
use App\Sms\SmsInterface;

class EmployeeService extends BaseService implements EmployeeInterface
{
    private $sendSms;

    public function __construct(SmsInterface $sms)
    {
        $this->repository = new EmployeeRepository(new Employee());
        $this->sendSms = $sms;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->repository->getById($id);

        if (!$result) {
            $this->doErrorLog('Employee not found.', [$result]);
            return $this->apiResponse(response::REQUEST_NOT_FOUND, 'Employee not found.');
        }

        return array_merge($this->apiResponse(response::SUCCESS_CODE, 'Success.'), ['data' => $result]);
    }

    public function create(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;

        $result = $this->repository->create($data);

        if (!$result) {
            $this->doErrorLog('Create employee failed.', [$result]);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Create employee failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Employee created.');        
    }

    public function update(int $id, array $data): array
    {
        $result = $this->repository->update($id, $data);

        if (is_array($result) === true && array_key_exists('code', $result) === true) {
            $this->doErrorLog('Update employee failed.', $result);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Update employee failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Employee updated.');  
    }

    public function delete(int $id): array 
    {
        $result = $this->repository->delete($id);

        if (is_array($result) === true && array_key_exists('code', $result) === true) {
            $this->doErrorLog('Delete employee failed.', $result);
            return $this->apiResponse(response::BAD_REQUEST_CODE, 'Delete employee failed.');
        }
        
        return $this->apiResponse(response::SUCCESS_CODE, 'Employee deleted.');
    }

    public function sendSms(array $data): array
    {
        $employees = array_key_exists('department_id', $data) === true ?
            $this->repository->getWithWhereData(['department_id' => $data['department_id']]) :
            $employees = $this->repository->getEmployeeByIds($data['employee_list']);

        if ($employees->isEmpty() === true) {
            return $this->apiResponse(response::SUCCESS_CODE, 'Selected department has no employee/s.');
        }

        foreach ($employees as $employee) {
            $this->sendSms->send($employee->id, $employee->phone_number, $data['message']);
        }

        return $this->apiResponse(response::SUCCESS_CODE, 'Message sent.');
    }
}
