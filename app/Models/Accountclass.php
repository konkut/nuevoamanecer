<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Accountclass extends Model
{
    use HasFactory;
    protected $primaryKey = 'accountclass_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'accountclasses';
    protected $fillable = [
        'accountclass_uuid',
        'code',
        'name',
        'description',
        'status',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function groups()
    {
        return $this->hasMany(Accountgroup::class, 'accountclass_uuid', 'accountclass_uuid')->orderBy('code', 'asc');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->accountclass_uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
