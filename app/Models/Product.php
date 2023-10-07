<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'status',
        'price',
        'publisher_id',
        'book_layout',
        'origin_id',
        'height',
        'width',
        'thickness',
        'weight',
        'number_of_pages',
        'publish_year',
        'author',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function categories() {
        return $this->belongsToMany(Category::class, 'products_in_categories', 'product_id');
    }

    public function productImages() {
        return $this->hasMany(ProductImage::class);
    }

    public function rentPrice() {
        return $this->hasMany(RentPrice::class);
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function origin() {
        return $this->belongsTo(Origin::class);
    }

    public function productsInCarts() {
        return $this->hasMany(ProductInCart::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function productInOrders() {
        return $this->hasMany(ProductInOrder::class);
    }
}
