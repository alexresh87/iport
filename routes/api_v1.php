<?php

use App\Http\Controllers\api\v1\IndexController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\OfferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::apiResources([
    'category' => CategoryController::class,
    'offer' => OfferController::class
]);


