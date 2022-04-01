<?php

use App\Http\Controllers\Api\AttributesController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ProductController::class)->group(function(){

    Route::get('/products','index');
    Route::post('/product','store');
    Route::get('/product/{id}','show');
    Route::put('/product/{id}','update');
    Route::delete('/product/{id}','destroy');

});

Route::controller(CategoryController::class)->group(function(){

    Route::get('/categories','index');

});

Route::controller(AttributesController::class)->group(function(){

    Route::get('/attributes/{category_id}','index');

});
