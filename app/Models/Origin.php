<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use HasFactory;

    public $table = 'origins';
    
    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;
   
    public function products() {
        return $this->hasMany(Product::class, 'origin_id');
    }
}
