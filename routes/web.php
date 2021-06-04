<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistersController;

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
//Route::get('/dashboard','DashboardController@index');
//OR
//Route::get('/dashboard',[DashboardController::class,'index']);
Route::get('admin/categories',[CategoriesController::class,'index']);
Route::get('admin/categories/create',[CategoriesController::class,'create']);
Route::post('admin/categories/create',[CategoriesController::class,'store']);
Route::get('admin/categories/{id}/edit',[CategoriesController::class,'edit']);
Route::put('admin/categories/{id}',[CategoriesController::class,'update']);
Route::delete('admin/categories/{id}',[CategoriesController::class,'destroy']);
//Route::get('/categories/{id}/{title}',[CategoriesController::class,'show']);
Route::get('admin/tags/{id}/products',[TagsController::class,'products']);
Route::resource('admin/products','Admin\ProductsController');


Route::get('register',[RegistersController::class,'create']);
Route::post('register',[RegistersController::class,'store']);

Route::get('admin/users/{id}',[UsersController::class,'show'])->name('admin.users.show');

/*Route::get('regexp',function(){
    $test='059-7230922,059-2457963';
    $exp='/(059|056)\-?([0-9]{7})/';
    preg_match_all($exp,$test,$matches);
    dd($matches);
});*/

