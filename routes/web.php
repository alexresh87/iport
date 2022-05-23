<?php

use App\Jobs\ParseXML;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    $response = Http::get(config('app.url_xml'));
    Storage::disk('local')->put('data.xml', $response);
    return "OK";
});

Route::get('/parse', function(){
   ParseXML::dispatch();
});

Route::get('/remove', function(){
    Category::deleteAll();
    Offer::deleteAll();
});