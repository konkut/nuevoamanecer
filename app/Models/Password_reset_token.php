<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_reset_token extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'password_reset_tokens';
    protected $fillable = [
        'id',
        'user_id',
        'token',
        'expires_at',
        'created_at',
        'updated_at'
    ];
}
