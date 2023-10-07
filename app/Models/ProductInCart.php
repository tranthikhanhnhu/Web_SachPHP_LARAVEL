<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInCart extends Model
{
    use HasFactory;

    protected $table = 'products_in_carts';

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'rent_time',
        'pick_up_date',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
