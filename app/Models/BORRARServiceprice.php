<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Serviceprice extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'serviceprice_uuid';
  protected $keyType = 'string'; 
  public $incrementing = false;
  protected $table = 'serviceprices';
  protected $fillable = [
    'service_uuid',
    'name',
    'description', 
    'amount',
    'commission',
    /*'currency_uuid',*/
    'status',
    'category_uuid',
    'user_id',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_uuid', 'category_uuid');
  }

  /*
  public function currency()
  {
    return $this->belongsTo(Currency::class, 'currency_uuid', 'currency_uuid');
  }*/

  public function user()
  {
    return $this->belongsTo(User::class);
  }
/*
  public function incomefromtransfer()
  {
    return $this->hasMany(Incomefromtransfer::class, 'service_uuid', 'service_uuid');
  }*/

  // Generar un UUID automáticamente al crear un nuevo modelo
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->serviceprice_uuid = (string) Str::uuid(); // Genera un UUID
    });
    /*
    static::deleting(function ($serviceprice) {
      // Elimina con soft delete todos los servicios asociados
      $serviceprice->incomefromtransfer()->each(function ($serviceprice) {
        $serviceprice->delete();
      });
    });*/
  }
}
