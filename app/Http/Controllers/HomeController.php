<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured',1)
            ->where('stock','>',0)
            ->latest()
            ->take(20)
            ->get();

        $banners = Banner::where('active',1)
            ->orderBy('created_at','desc')
            ->get();

        return view('pages.home', compact('featuredProducts','banners'));
    }
}
