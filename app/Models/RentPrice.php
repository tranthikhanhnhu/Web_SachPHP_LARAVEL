<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentPrice extends Model
{
    use HasFactory;

    protected $table = 'rent_prices';

    protected $fillable = [
        'created_at',
        'updated_at',
        'product_id',
        'price',
        'number_of_days'
    ];

    public $timestamps = false;

    public function products() {
        $this->belongsTo(Product::class);
    }
}
