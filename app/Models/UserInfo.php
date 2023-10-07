<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users_info';

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'gender',
        'dob',
        'image_url',
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;

}
