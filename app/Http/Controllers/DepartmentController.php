<?php

namespace App\Http\Controllers;

use App\Interfaces\DepartmentInterface;
use App\Http\Requests\DepartmentRequest;
use App\Constants\ResponseConstants as response;

class DepartmentController extends BaseController
{
    public function __construct(DepartmentInterface $departmentService)
    {
        $this->service = $departmentService;
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

    public function store(DepartmentRequest $request)
    {
        $result = $this->service->create($request->validated());
        return response()->json($result, $result['code']);
    }

    public function update(DepartmentRequest $request, $id)
    {
        $result = $this->service->update((int)$id, $request->validated());
        return response()->json($result, $result['code']);
    }

    public function destroy($id)
    {
        $result = $this->service->delete((int)$id);
        return response()->json($result, $result['code']);
    }
}
