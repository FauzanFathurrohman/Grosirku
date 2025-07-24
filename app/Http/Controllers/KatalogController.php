<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Pencarian
        if ($request->q) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
    
        // Filter kategori
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
    
        // Sortir
        if ($request->sort == 'lowest') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'highest') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
    
        $products = $query->paginate(12);
        $categories = Category::all(); // untuk filter kategori
    
        return view('katalog.index', compact('products', 'categories'));
    }
}
