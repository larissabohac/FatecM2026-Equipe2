<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
       $query = Product::query()->with('category');

        // busca
        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // filtro categoria
        if ($request->input('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // ordenação
        if ($request->input('sort') == 'price_asc') {
            $query->orderBy('price', 'asc');
        }

        if ($request->input('sort') == 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // buscar categorias
        $categories = Category::where('active', 1)->get();

        return view('pages.products', compact('products','categories'));
    }
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
            ->where('stock', '>', 0)
            ->paginate(12);

        return view('pages.category', compact('category','products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug',$slug)->with('category')->firstOrFail();

        $relatedProducts = Product::where('category_id',$product->category_id)
        ->where('id','!=',$product->id)
        ->take(4)
        ->get();

        return view('pages.product', compact('product','relatedProducts'));
    }
}
