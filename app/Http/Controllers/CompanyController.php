<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyInterface;
use App\Http\Requests\CompanyRequest;
use App\Constants\ResponseConstants as response;

class CompanyController extends BaseController
{
    public function __construct(CompanyInterface $companyService)
    {
        $this->service = $companyService;
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

    public function store(CompanyRequest $request)
    {
        $result = $this->service->create($request->validated());
        return response()->json($result, $result['code']);
    }

    public function update(CompanyRequest $request, $id)
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
