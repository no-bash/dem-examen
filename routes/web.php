<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [MainController::class, 'main_page']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/profile', [UserController::class, 'profile_page']);
Route::post('/profile/app-add', [UserController::class, 'app_add']);
Route::get('/profile/app/{app_id}/delete', [UserController::class, 'app_delete']);

Route::get('/admin/', [AdminController::class, 'admin_page']);
Route::post('/admin/category/add', [AdminController::class, 'category_add']);
Route::post('/admin/category/delete', [AdminController::class, 'category_delete']);
Route::post('/admin/app/approve', [AdminController::class, 'app_approve']);
Route::post('/admin/app/reject', [AdminController::class, 'app_reject']);
