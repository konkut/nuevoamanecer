<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;
    protected $primaryKey = 'activity_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'activities';
    protected $fillable = [
        'activity_uuid',
        'name',
        'start_date',
        'end_date',
        'description',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function companies()
    {
        return $this->hasMany(Company::class, 'activity_uuid', 'activity_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->activity_uuid = (string) Str::uuid();
        });
    }
}
