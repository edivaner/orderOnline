<?php

use App\Http\Controllers\CustomerController;
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
Route::delete("/customer/{id}", [CustomerController::class, 'delete']);



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
