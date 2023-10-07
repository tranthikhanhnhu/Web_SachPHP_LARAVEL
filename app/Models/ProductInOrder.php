<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInOrder extends Model
{
    use HasFactory;    protected $table = 'products_in_orders';

    const STATUS = [
        'cancel' => 'cancel',
        'wait_for_pick_up' => 'wait_for_pick_up',
        'picked_up' => 'picked_up',
        'returned_good' => 'returned_good',
        'returned_bad' => 'returned_bad',
        'some_returned_good' => 'some_returned_good',
        'some_returned_bad' => 'some_returned_bad',
    ];

    const STATUS_WAIT_FOR_PICK_UP = 'wait_for_pick_up';
    const STATUS_CANCEL = 'cancel';
    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_RETURNED_GOOD = 'returned_good';
    const STATUS_RETURNED_BAD = 'returned_bad';
    const STATUS_SOME_RETURNED_BAD = 'some_returned_bad';
    const STATUS_SOME_RETURNED_GOOD = 'some_returned_good';


    protected $fillable = [
        'order_id',
        'product_id',
        'status',
        'rent_time',
        'pick_up_date',
        'return_date',
        'expected_pick_up_date',
        'expected_return_date',
        'product_name',
        'product_price',
        'product_quantity',
        'returned_bad_quantity',
        'returned_good_quantity',
        'deposit',
        'deposit_return',
        'lated',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
