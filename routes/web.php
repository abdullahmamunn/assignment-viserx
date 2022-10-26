<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Settings\RolePermission;

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

Route::post('registation',[AuthController::class,'UserRegistationFormSubmit'])->name('user.resgistration');
Route::post('login',[AuthController::class,'UserLoginFormSubmit'])->name('user.login');

Route::middleware(['UserAuthCheck'])->group(function (){
    Route::get('login',[AuthController::class,'loginForm'])->name('login');
    Route::get('registation',[AuthController::class,'registationForm'])->name('registation');
    Route::get('logout',[AuthController::class,'logout'])->name('logout');
    Route::middleware(['Permission'])->group(function () {
        Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');
        Route::resource('product', ProductController::class);
        Route::post('filter',[ProductController::class,'filterProduct'])->name('product.filter');

        // assign role to users
        Route::get('assign-role',[RolePermission::class, 'assignRole'])->name('user.assign.role');
        Route::get('assign-role/{id}',[RolePermission::class, 'assignUserRole'])->name('assign.role');
        Route::get('user-role-store',[RolePermission::class, 'userRoleStore'])->name('user.role.store');

        // assign permission
        Route::get('assign-route',[RolePermission::class, 'assignRoute'])->name('user.assign.route');
        Route::get('user.route.store',[RolePermission::class, 'userRouteStore'])->name('user.route.store');

        // insert dataset to product
        Route::get('insert-data',[ProductController::class, 'Dataset'])->name('insert.data');
        // Route::get('truncate-data',[ProductController::class, 'Dataset'])->name('insert.data');

    });
});



