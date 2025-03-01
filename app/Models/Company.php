<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;
    protected $primaryKey = 'company_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'companies';
    protected $fillable = [
        'company_uuid',
        'name',
        'nit',
        'description',
        'status',
        'user_id',
        'activity_uuid',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_uuid', 'activity_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->company_uuid = (string) Str::uuid();
        });
    }
}
