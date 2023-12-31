<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UploadController;
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

Route::post('/login',[AuthController::class,'login']);



Route::group(['middleware'=>'auth:sanctum'], function () {
    
    Route::resource('/products', ProductController::class);
    Route::resource('/order', OrderController::class);
    Route::resource('/tables', TableController::class);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/upload', [UploadController::class, 'upload']);

 


// Route for Tables


// Route for Orders
// Route::resource('orders', OrderController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
