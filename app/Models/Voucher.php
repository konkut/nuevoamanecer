<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Voucher extends Model
{
    use HasFactory;
    protected $primaryKey = 'voucher_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'vouchers';
    protected $fillable = [
        'voucher_uuid',
        'number',
        'type',
        'date',
        'narration',
        'cheque_number',
        'ufv',
        'usd',
        'company_uuid',
        'project_uuid',
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
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_uuid', 'project_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->voucher_uuid = (string) Str::uuid();
        });
    }
}
