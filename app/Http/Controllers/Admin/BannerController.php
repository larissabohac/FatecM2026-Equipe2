<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('position')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'link'  => 'nullable|string|max:255',
            'position' => 'nullable|integer'
        ]);

        $path = $request->file('image')->store('banners', 'public');

        \App\Models\Banner::create([
            'title'    => $request->title,
            'image'    => $path,
            'link'     => $request->link,
            'active'   => $request->has('active'),
            'position' => $request->position ?? 1,
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner criado com sucesso!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return back();
    }
}