<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accountgroup extends Model
{
    use HasFactory;
    protected $primaryKey = 'accountgroup_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'accountgroups';
    protected $fillable = [
        'accountgroup_uuid',
        'code',
        'name',
        'description',
        'accountclass_uuid',
        'status',
        'user_id'
    ];
    public function accountclass()
    {
        return $this->belongsTo(Accountclass::class, 'accountclass_uuid', 'accountclass_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subgroups()
    {
        return $this->hasMany(Accountsubgroup::class, 'accountgroup_uuid', 'accountgroup_uuid')->orderBy('code', 'asc');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->accountgroup_uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
