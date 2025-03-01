<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Income extends Model
{
    use HasFactory;
    protected $primaryKey = 'income_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'incomes';
    protected $fillable = [
        'income_uuid',
        'observation',
        'cashshift_uuid',
    ];
    protected $guarded = [];
    public function cashshift()
    {
        return $this->belongsTo(Cashshift::class, 'cashshift_uuid', 'cashshift_uuid');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'income_services', 'income_uuid', 'service_uuid')
            ->withPivot(['code','quantity','amount','commission','index']);
    }
    public function denominations()
    {
        return $this->belongsToMany(Denomination::class, 'income_denominations', 'income_uuid', 'denomination_uuid')
            ->withPivot(['type']);
    }
    public function cashregisters()
    {
        return $this->belongsToMany(Cashregister::class, 'income_cashregisters', 'income_uuid', 'cashregister_uuid')
            ->withPivot(['total','type','index']);
    }
    public function bankregisters()
    {
        return $this->belongsToMany(Bankregister::class, 'income_bankregisters', 'income_uuid', 'bankregister_uuid')
            ->withPivot(['total','type','index']);
    }
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'income_platforms', 'income_uuid', 'platform_uuid')
            ->withPivot(['total','type','index']);
    }
    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'income_uuid', 'income_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->income_uuid = (string)Str::uuid();
        });
    }
}
