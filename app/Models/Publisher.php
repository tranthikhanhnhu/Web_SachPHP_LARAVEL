<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    public $table = 'publishers';
    
    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function products() {
        return $this->hasMany(Product::class, 'publisher_id');
    }
   
}
