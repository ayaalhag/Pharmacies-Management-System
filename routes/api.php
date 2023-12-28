<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharmacistController;
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
/*
Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/logout',[PharmacistController::class,'logout']);
});*/
Route::middleware('token')->group(function () {
    Route::get('/logout',[PharmacistController::class,'logout']);
});