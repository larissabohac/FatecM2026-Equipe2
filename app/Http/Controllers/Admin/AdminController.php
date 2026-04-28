<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
    $totalProducts = Product::count();
    $featured = Product::where('featured', true)->count();
    $totalUsers = User::count();
    $totalOrders = \App\Models\Order::count();

    return view('admin.dashboard', compact(
        'totalProducts',
        'featured',
        'totalUsers',
        'totalOrders'
    ));
    }
}
