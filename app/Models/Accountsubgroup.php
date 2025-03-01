<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accountsubgroup extends Model
{
    use HasFactory;
    protected $primaryKey = 'accountsubgroup_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'accountsubgroups';
    protected $fillable = [
        'accountsubgroup_uuid',
        'code',
        'name',
        'description',
        'accountgroup_uuid',
        'status',
        'user_id'
    ];
    public function accountgroup()
    {
        return $this->belongsTo(Accountgroup::class, 'accountgroup_uuid', 'accountgroup_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function accounts()
    {
        return $this->hasMany(Account::class, 'accountsubgroup_uuid', 'accountsubgroup_uuid')->orderBy('code', 'asc');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->accountsubgroup_uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
