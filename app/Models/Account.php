<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory;
    protected $primaryKey = 'account_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'accounts';
    protected $fillable = [
        'account_uuid',
        'code',
        'name',
        'description',
        'accountsubgroup_uuid',
        'status',
        'user_id'
    ];
    public function accountsubgroup()
    {
        return $this->belongsTo(Accountsubgroup::class, 'accountsubgroup_uuid', 'accountsubgroup_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->account_uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
