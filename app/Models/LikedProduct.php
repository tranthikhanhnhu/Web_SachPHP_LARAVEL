<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedProduct extends Model
{
    use HasFactory;

    protected $table = 'liked_products';

    protected $fillable = [
        'product_id',
        'user_id',
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
