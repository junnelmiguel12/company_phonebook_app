<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [RegisterController::class, 'register'])->middleware('first-user');
Route::post('login', [LoginController::class, 'login']);

Route::middleware(['json', 'auth:api'])->group(function () {
    Route::resources([
        'companies'   => CompanyController::class,
        'departments' => DepartmentController::class,
        'employees'   => EmployeeController::class
    ]);

    Route::post('send-sms', [EmployeeController::class, 'sendSms']);
});
