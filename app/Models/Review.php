<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_name',
        'user_id',
        'product_id',
        'content',
        'rating',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
