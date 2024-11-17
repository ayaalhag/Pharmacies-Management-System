<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\TokenMiddleware;
use App\Http\Middleware\Authenticate;

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

// Route::middleware('auth:passport')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("register/Pharmacy",[PharmacistController::class,"register"]);
Route::post("login/Pharmacy",[PharmacistController::class,"login"]);
Route::post("login/Dashboard",[DashboardController::class,"login"]);


Route::middleware('token')->group(function () {
    Route::get('/logout',[PharmacistController::class,'logout']);
    Route::get('/showCategory',[PharmacistController::class,"showCategory"]);
    Route::get('/showStores',[PharmacistController::class,"showStores"]);

    Route::post('/showProducts',[PharmacistController::class,"showProducts"]);
    Route::post('/addProducts',[DashboardController::class,"storeProduct"]);
    Route::post('/editProduct',[DashboardController::class,"editProduct"]);
    Route::post("/getProduct",[DashboardController::class,"getProduct"]);
    Route::post('/deleteProduct',[DashboardController::class,"deleteProduct"]);
   
    Route::post("/addOrder",[OrderController::class,"addOrder"]);
    
    Route::post("/getOrdersByPharmacist",[OrderController::class,"getOrdersByPharmacist"]);
    Route::post("/getOrderByStore",[OrderController::class,"getOrderByStore"]);
    Route::post("/getOrdersById",[OrderController::class,"getOrdersById"]);

    Route::post("/editStatuse",[OrderController::class,"editStatuse"]);
    
    Route::post("/favoriteProducts",[OrderController::class,"favoriteProducts"]);
    Route::post("/generateReport",[DashboardController::class,"generateReport"]);
});