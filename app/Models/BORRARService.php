<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'service_uuid';
  protected $keyType = 'string'; // Asegura que Laravel trate el primaryKey como string
  public $incrementing = false;
  protected $table = 'services';
  protected $fillable = [
    'service_uuid',
    'name',
    'description',
    /*'amount',
    'commission',
    'currency_uuid',*/
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

  public function incomefromtransfer()
  {
    return $this->hasMany(Incomefromtransfer::class, 'service_uuid', 'service_uuid');
  }

  // Generar un UUID automáticamente al crear un nuevo modelo
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->service_uuid = (string) Str::uuid(); // Genera un UUID
    });
    static::deleting(function ($service) {
      // Elimina con soft delete todos los servicios asociados
      $service->incomefromtransfer()->each(function ($service) {
        $service->delete();
      });
    });
  }
}
