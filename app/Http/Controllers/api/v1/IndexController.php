<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){
        return ["api_version" => 1];
    }
}
