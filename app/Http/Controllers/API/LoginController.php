<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
   
class LoginController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
            $user = Auth::user(); 

            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name']  =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else { 
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized user.']);
        } 
    }
}
