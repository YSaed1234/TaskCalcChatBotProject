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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('message')->group(function () {
//    Route::get('/get/{id}', [HierarchyController::class, 'getOne']);
//    Route::get('lastSerial', [HierarchyController::class, 'getlastRow']);
//    Route::post('search', [HierarchyController::class, 'search']);
    Route::post('send', [\App\Http\Controllers\HomeController::class, 'send']);
//    Route::put('edit/{id}', [HierarchyController::class, 'edit']);
//    Route::delete('delete/{id}', [HierarchyController::class, 'delete']);
});