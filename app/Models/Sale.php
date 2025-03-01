<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Sale extends Model
{
    use HasFactory;
    protected $primaryKey = 'sale_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'sales';
    protected $fillable = [
        'sale_uuid',
        'observation',
        'denomination_uuid',
        'cashshift_uuid',
    ];
    public function cashshift()
    {
        return $this->belongsTo(Cashshift::class, 'cashshift_uuid', 'cashshift_uuid');
    }
    public function denomination()
    {
        return $this->belongsTo(Denomination::class, 'denomination_uuid', 'denomination_uuid');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_products', 'sale_uuid', 'product_uuid')
            ->withPivot(['quantity','amount','index']);
    }
    public function cashregisters()
    {
        return $this->belongsToMany(Cashregister::class, 'sale_cashregisters', 'sale_uuid', 'cashregister_uuid')
            ->withPivot(['total','index']);
    }
    public function bankregisters()
    {
        return $this->belongsToMany(Bankregister::class, 'sale_bankregisters', 'sale_uuid', 'bankregister_uuid')
            ->withPivot(['total','index']);
    }
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'sale_platforms', 'sale_uuid', 'platform_uuid')
            ->withPivot(['total','index']);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->sale_uuid = (string) Str::uuid();
        });
    }
}
