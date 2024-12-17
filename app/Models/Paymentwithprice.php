<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Paymentwithprice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'paymentwithprice_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'paymentwithprices';
    protected $fillable = [
        'paymentwithprice_uuid',
        'names',
        'amounts',
        'commissions',
        'observation',
        'servicewithoutprice_uuids',
        'transactionmethod_uuids',
        'user_id',
        'cashshift_uuid',
    ];
    protected $casts = [
        'names' => 'array',
        'amounts' => 'array',
        'commissions' => 'array',
        'servicewithoutprice_uuids' => 'array',
        'transactionmethod_uuids' => 'array',
    ];

    public function servicewithoutprice()
    {
        return $this->belongsTo(Servicewithoutprice::class, 'servicewithoutprice_uuid', 'servicewithoutprice_uuid');
    }

    public function denominations()
    {
        return $this->morphToMany(Denomination::class, 'denominationable', 'denominationables', 'denominationable_uuid', 'denomination_uuid', 'paymentwithprice_uuid', 'denomination_uuid');
    }

    public function denominationable()
    {
        return $this->hasMany(Denominationables::class, 'denominationable_uuid', 'paymentwithprice_uuid');
    }

    public function transactionmethod()
    {
        return $this->belongsTo(Transactionmethod::class, 'transactionmethod_uuid', 'transactionmethod_uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->paymentwithprice_uuid = (string)Str::uuid();
        });
        static::deleting(function ($model) {
            $model->denominations()->delete();
            $model->denominationable()->delete();
        });
        /*
        static::restoring(function ($incomefromtransfer) {
          $incomefromtransfer->services()->onlyTrashed()->each(function ($incomefromtransfer) {
            $incomefromtransfer->restore();
          });
        });*/
    }
}
