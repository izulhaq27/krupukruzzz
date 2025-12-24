<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relasi ke produk (many to many)
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    /**
     * Scope untuk kategori aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor untuk mendapatkan URL gambar lengkap
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Generate slug otomatis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
                
                // Cek apakah slug sudah ada
                $originalSlug = $category->slug;
                $count = 1;
                
                while (static::where('slug', $category->slug)->exists()) {
                    $category->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
                
                // Cek apakah slug sudah ada (kecuali milik sendiri)
                $originalSlug = $category->slug;
                $count = 1;
                
                while (static::where('slug', $category->slug)
                    ->where('id', '!=', $category->id)
                    ->exists()) {
                    $category->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        // Detach semua relasi produk saat kategori dihapus
        static::deleting(function ($category) {
            $category->products()->detach();
        });
    }
}