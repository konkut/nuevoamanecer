<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Paymentwithoutprice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'paymentwithoutprice_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'paymentwithoutprices';
    protected $fillable = [
      'paymentwithoutprice_uuid',
      'observation',
      'servicewithprice_uuids',
      'transactionmethod_uuids',
      'user_id',
        'cashshift_uuid',
    ];
    protected $casts = [
        'servicewithprice_uuids' => 'array',
        'transactionmethod_uuids' => 'array',
    ];
    public function servicewithprice()
    {
      return $this->belongsTo(Servicewithprice::class, 'servicewithprice_uuid', 'servicewithprice_uuid');
    }
    public function denominations(){
        return $this->morphToMany(Denomination::class,'denominationable','denominationables','denominationable_uuid','denomination_uuid','paymentwithoutprice_uuid','denomination_uuid');
    }
    public function denominationable()
    {
        return $this->hasMany(Denominationables::class, 'denominationable_uuid', 'paymentwithoutprice_uuid');
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
        $model->paymentwithoutprice_uuid = (string) Str::uuid();
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
