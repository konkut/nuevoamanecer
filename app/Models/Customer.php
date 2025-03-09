<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'customer_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'customers';
    protected $fillable = [
        'customer_uuid',
        'name',
        'nit',
        'email',
        'phone',
        'address',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->customer_uuid = (string) Str::uuid();
        });
    }
}
