<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'stock', 'image', 'featured', 'category_id'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Auto-generate slug if missing
    public static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . substr(uniqid(), -4);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
