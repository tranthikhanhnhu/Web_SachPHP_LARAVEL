<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    public function products() {
        return $this->belongsToMany(Product::class, 'products_in_categories', 'category_id');
    }
}
