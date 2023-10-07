<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'level',
        'status',
        'phone_number',
        'created_at',
        'updated_at',
    ];

    public function userInfo() {
        return $this->hasOne(UserInfo::class);
    }

    public function productsInCarts() {
        return $this->hasMany(ProductInCart::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
    
    public $timestamps = false;
}