<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('site.pages.index',compact('categories'));
    }

}
