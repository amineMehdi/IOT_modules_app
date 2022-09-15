<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuleController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [ModuleController::class, 'index'])->middleware('auth')->name('module.index');
Route::post('/module', [ModuleController::class, 'store'])->middleware('auth')->name('module.store');

Route::get('/module/info/{module}', [ModuleController::class, 'info'])->middleware('auth')->name('module.info');

Route::put('/module/{module}', [ModuleController::class, 'update'])->middleware('auth')->name('module.update');
Route::delete('/module/{module}', [ModuleController::class, 'destroy'])->middleware('auth')->name('module.destroy');

Route::get('/module/new', [ModuleController::class, 'create'])->middleware('auth')->name('module.create');


Route::get('/module/{module}/edit', [ModuleController::class, 'edit'])->middleware('auth')->name('module.edit');
Route::get('/module/status/update', [ModuleController::class, 'updateStatus'])->middleware('auth')->name('module.updateStatus');

Route::get('/module/history/{module}', [ModuleController::class, 'historyModule'])->middleware('auth')->name('module.historyModule');
Route::get('/module/types', [ModuleController::class, 'types'])->middleware('auth')->name('module.types');
