<?php

use App\Http\Controllers\User\UserController;
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


Route::apiResource('user','API\Users\UserController');
Route::get('findUser','API\Users\UserController@search');




Route::apiResource('categories','API\Category\CategoryController');
Route::apiResource('categories.subcategories','API\Category\CategorySubCategoryController',['only'=>['index']]);




Route::apiResource('subcategories','API\SubCategory\SubCategoryController');



Route::apiResource('components','API\Components\ComponentssController');



Route::apiResource('items','API\Items\ItemController');
// Route::apiResource('items.orders','API\Items\ItemController');


Route::apiResource('orders','API\Order\OrderController');
Route::apiResource('orders.items','API\Order\OrderItemController');



Route::apiResource('purches','API\Purches\PurchesController');


Route::apiResource('reports','API\Reports\ReportController');




Route::get('profile','API\Users\UserController@profile');
Route::put('profile','API\Users\UserController@updateProfile');


