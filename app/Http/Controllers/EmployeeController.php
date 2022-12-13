<?php

namespace App\Http\Controllers;

use App\Interfaces\EmployeeInterface;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\SendSmsRequest;
use App\Constants\ResponseConstants as response;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{

    public function __construct(EmployeeInterface $employeeService)
    {
        $this->service = $employeeService;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), response::SUCCESS_CODE);
    }

    public function show($id)
    {
        $result = $this->service->getById((int)$id);
        return response()->json($result, $result['code']);
    }

    public function store(EmployeeRequest $request)
    {
        $result = $this->service->create($request->validated());
        return response()->json($result, $result['code']);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $result = $this->service->update((int)$id, $request->validated());
        return response()->json($result, $result['code']);
    }

    public function destroy($id)
    {
        $result = $this->service->delete((int)$id);
        return response()->json($result, $result['code']);
    }

    public function sendSms(SendSmsRequest $request)
    {
        $result = $this->service->sendSms($request->validated());
        return response()->json($result, $result['code']);
    }
}
