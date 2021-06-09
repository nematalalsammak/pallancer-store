<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;

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
Route::get('/',[HomeController::class,'index']);

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//Route::get('/', 'TemplateController@index');


//Route::get('/dashboard','DashboardController@index');
//OR
//Route::get('/dashboard',[DashboardController::class,'index']);
Route::namespace('Admin')
->prefix('admin')
->as('admin.')
->group(function(){
Route::group([
    'prefix' => 'categories',
    'as' => 'categories.',
], function () {
    //admin.categories.index
    Route::get('/', 'CategoriesController@index')->name('index');
    Route::get('/create', [CategoriesController::class, 'create'])->name('create');
    //Route::get('/{id}',[CategoriesController::class,'show'])->name('show');
    Route::post('/create', [CategoriesController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
    //Route::get('/categories/{id}/{title}',[CategoriesController::class,'show']);
});
    Route::resource('products', 'ProductsController');
});

Route::get('admin/tags/{id}/products', [TagsController::class, 'products']);
//Route::get('register', [RegistersController::class, 'create']);
//Route::post('register', [RegistersController::class, 'store']);

Route::get('admin/users/{id}', [UsersController::class, 'show'])->name('admin.users.show');

/*Route::get('regexp',function(){
    $test='059-7230922,059-2457963';
    $exp='/(059|056)\-?([0-9]{7})/';
    preg_match_all($exp,$test,$matches);
    dd($matches);
});*/
