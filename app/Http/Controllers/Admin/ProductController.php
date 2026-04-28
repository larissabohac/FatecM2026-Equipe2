<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;

class ProductController extends Controller
{
    // aplicar middleware auth no grupo de rotas (routes/web.php)
    public function index()
    {
        $products = Product::with('category') ->orderBy('created_at','desc')
        ->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('active',1)
        ->orderBy('name')
        ->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
       $data = $request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'nullable|string|max:255|unique:products,slug',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'category_id'=>'required|exists:categories,id',
            'image'=>'nullable|image|max:2048',
            'featured'=>'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . substr(uniqid(), -4);
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success','Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
           'name'=>'required|string|max:255',
            'slug'=>['nullable','string','max:255', Rule::unique('products','slug')->ignore($product->id)],
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'category_id'=>'required|exists:categories,id',
            'image'=>'nullable|image|max:2048',
            'featured'=>'nullable|boolean',
        ]);
    

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Produto removido.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }
}
