<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
Route::get('/search', 'searchBoarding');
Route::get('/',  [\App\Http\Controllers\HomeController::class , 'index'])->name('homepage');
Route::get('boarding',  [\App\Http\Controllers\PropertyController::class , 'index'])->name('boarding.index');
Route::get('boarding/detail/{boarding:slug}',  [\App\Http\Controllers\PropertyController::class , 'show'])->name('boarding.show');
Route::get('boarding/category/{category:slug}',  [\App\Http\Controllers\CategoryController::class , 'index'])->name('category.index');
Route::get('agents',  [\App\Http\Controllers\AgentController::class , 'index'])->name('agent.index');
Route::get('contact',  [\App\Http\Controllers\ContactController::class , 'index'])->name('contact.index');
Route::post('contact',  [\App\Http\Controllers\ContactController::class , 'store'])->name('contact.store');

Route::group(['middleware' => 'isAdmin','prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('welcome', function() {
        return view('admin.welcome');
    })->name('welcome.index');
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    
    // user management
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // boarding management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('boarding', \App\Http\Controllers\Admin\PropertyController::class);
    Route::resource('boarding.features', \App\Http\Controllers\Admin\FeatureController::class);
    Route::resource('boarding.galleries', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class)->only('index','destroy');
    Route::get('agents/{user:id}', [\App\Http\Controllers\Admin\AgentController::class, 'edit'])->name('agents.edit');
    Route::put('agents/{user:id}', [\App\Http\Controllers\Admin\AgentController::class, 'update'])->name('agents.update');
});

Auth::routes();

