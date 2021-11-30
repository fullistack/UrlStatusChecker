<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('/home', App\Http\Controllers\HomeController::class)->middleware("auth");
Route::get("/start_check",[\App\Http\Controllers\HomeController::class,"startCheck"])->name("start_check")->middleware("auth");
Route::get("/start_check_single/{id}",[\App\Http\Controllers\HomeController::class,"checkSingle"])->name("start_check_single")->middleware("auth");

Route::get("server_check",function (){
    return "SERVER_STATUS_TRUE";
})->name("server.check");
