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
      'servicewithprice_uuid',
      'transactionmethod_uuid',
      'denomination_uuid',
      'user_id',
    ];

    public function servicewithprice()
    {
      return $this->belongsTo(Servicewithprice::class, 'servicewithprice_uuid', 'servicewithprice_uuid');
    }

    public function transactionmethod()
    {
      return $this->belongsTo(Transactionmethod::class, 'transactionmethod_uuid', 'transactionmethod_uuid');
    }

    public function denomination()
    {
      return $this->hasOne(Denomination::class, 'denomination_uuid', 'denomination_uuid');
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
          $model->denomination()->delete();
      });
      /*
      static::restoring(function ($incomefromtransfer) {
        $incomefromtransfer->services()->onlyTrashed()->each(function ($incomefromtransfer) {
          $incomefromtransfer->restore();
        });
      });*/
    }
}
