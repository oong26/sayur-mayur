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
    return view('app');
});
// Route::get('/dashboard', 'Backend\DashboardController@index')->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    Route::prefix('master')->group(function () {
        Route::get('dashboard', 'Backend\DashboardController@index')->name('dashboard');
        Route::resource('user', 'Backend\AdminController');
        Route::resource('courrier', 'Backend\CourrierController');
        Route::resource('supplier', 'Backend\SupplierController');
        Route::resource('product', 'Backend\ProductController');
        Route::resource('recipe', 'Backend\RecipeController');
        Route::resource('ingredients', 'Backend\IngredientController');
    });
});

require __DIR__.'/auth.php';
