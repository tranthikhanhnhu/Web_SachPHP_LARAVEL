<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInCategory extends Model
{
    use HasFactory;

    protected $table = 'products_in_categories';

    public $timestamps = false;
}
