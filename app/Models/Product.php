<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'stock', 'category_id', 'price', 'image'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
