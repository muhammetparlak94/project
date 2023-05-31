<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EDJWTController;

Route::post('generate-jwt-token', [EDJWTController::class, 'generateJwtToken']);
Route::post('verify-jwt-token', [EDJWTController::class, 'verifyJwtToken']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/generate-token', [JWTController::class, 'generateToken']); 



//Route::post('token', [AuthController::class, 'getToken']);

//auth kullanıldığı zaman login hatası route[login hatası veriyor middleware('auth:api') ] 
/* Route::middleware('auth:api')->group([], function () {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{id}', [UserController::class, 'update']);
});
 */
/* Route::post('/login', [LoginController::class, 'login'])->name('login');
 */
