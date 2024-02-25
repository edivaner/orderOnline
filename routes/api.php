<?php

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NfeController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Cliente (Customer)
Route::post("/customer", [CustomerController::class, 'store']);
Route::put("/customer/{id}", [CustomerController::class, 'update']);
Route::get("/customer", [CustomerController::class, 'index']);
Route::get("/customer/{id}", [CustomerController::class, 'show']);
Route::delete("/customer/{id}", [CustomerController::class, 'delete']);

//Funcionarios (employee)
Route::post("/employee", [EmployeeController::class, 'store']);
Route::put("/employee/{id}", [EmployeeController::class, 'update']);
Route::get("/employee", [EmployeeController::class, 'index']);
Route::get("/employee/{id}", [EmployeeController::class, 'show']);
Route::delete("/employee/{id}", [EmployeeController::class, 'delete']);

//Filial (Affiliate)
Route::post("/affiliate", [AffiliateController::class, 'store']);
Route::put("/affiliate/{id}", [AffiliateController::class, 'update']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::resource("/nfe-sped", NfeController::class);
