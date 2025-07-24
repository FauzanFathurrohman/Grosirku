<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan semua produk
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
    
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
    
        $products = $query->latest()->paginate(10);
        $categories = Category::all();
    
        return view('admin.products.index', compact('products', 'categories'));
    }
    

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,png|max:2048',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
        ]);
    
        // Simpan gambar
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/products'), $imageName);
    
        // Simpan produk
        Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'category_id' => $request->category_id,
        'image' => $imageName,
        'description' => $request->description,
        ]);
    
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate.');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
        return view('katalog.show', compact('product')); // Asumsi ada view 'katalog/show.blade.php'
    }
}
