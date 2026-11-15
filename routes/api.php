<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/catalog', [CatalogController::class, 'index']);
Route::get('/catalog/{slug}', [CatalogController::class, 'show']);

Route::apiResource('products', ProductController::class)
    ->names('api.products');

Route::apiResource('categories', CategoryController::class)
    ->names('api.categories');
