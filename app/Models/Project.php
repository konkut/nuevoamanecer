<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    protected $primaryKey = 'project_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'projects';
    protected $fillable = [
        'project_uuid',
        'name',
        'description',
        'start_date',
        'end_date',
        'budget',
        'status',
        'company_uuid',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_uuid', 'company_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->project_uuid = (string) Str::uuid();
        });
    }
}
