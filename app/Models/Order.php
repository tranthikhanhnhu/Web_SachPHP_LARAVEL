<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    protected $fillable = [
        'user_id',
        'total',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;
   
    public function productsInOrder() {
        return $this->hasMany(ProductInOrder::class, 'order_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
