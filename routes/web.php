<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeacherController;

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
    Route::middleware(['Permission'])->group(function () {
        Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');
        Route::get('/show-data',[AuthController::class, 'getData'])->name('show.data');
        Route::get('/get-data',[AuthController::class, 'getData'])->name('get.data');
        Route::get('logout',[AuthController::class,'logout'])->name('logout');
    });
});

Route::resource('product', ProductController::class);

Route::post('filter',[ProductController::class,'filterProduct'])->name('product.filter');

// Route::get('ajax',[TeacherController::class,'index']);
// Route::get('ajax/get-all',[TeacherController::class,'getData']);
// Route::post('ajax/create-new-teacher',[TeacherController::class,'createTeacher']);
// Route::get('ajax/edit-teacher/{id}',[TeacherController::class,'editTeacher']);
// Route::post('ajax/update-teacher/{id}',[TeacherController::class,'updateTeacher']);
// Route::get('ajax/delete/{id}',[TeacherController::class,'deleteTeacher']);
