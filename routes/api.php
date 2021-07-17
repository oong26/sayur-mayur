<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// user
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

// home
Route::get('newer-recipe', 'API\HomeController@newerRecipe');
Route::get('recipe', 'API\HomeController@recipe');

// recipe
Route::get('all-recipe', 'API\RecipeController@allRecipe');
Route::get('ingredients/{recipe_code}', 'API\RecipeController@ingredients');

// favorit
Route::get('list-favorit/{id_user}', 'API\FavoritController@listFavorit');
Route::get('check-favorit/{id_user}/{recipe_code}', 'API\FavoritController@checkFavorit');
Route::post('add-favorit', 'API\FavoritController@addFavorit');
Route::get('delete-favorit/{id_user}/{recipe_code}', 'API\FavoritController@deleteFavorit');