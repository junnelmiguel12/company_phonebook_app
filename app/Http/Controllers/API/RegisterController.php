<?php
   
namespace App\Http\Controllers\API;
   
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\BaseController;
use App\Models\Company;
use App\Models\User;

class RegisterController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $input = $request->validated();

        if (array_key_exists('first-user', $request->header()) === true) {
            $company = Company::create($input);
            $input['company_id'] = $company->id;
        }

        $input['password'] = bcrypt($input['password']);
        $user              = User::create($input);
        $success['token']  = $user->createToken('MyApp')->accessToken;
        $success['name']   = $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
}