<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Currency extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'currency_uuid';
  protected $keyType = 'string'; 
  public $incrementing = false;
  protected $table = 'currencies';
  protected $fillable = [
    'currency_uuid',
    'name',
    'symbol',
    'exchange_rate',
    'status',
  ];
  public function services()
  {
    return $this->hasMany(Service::class, 'currency_uuid', 'currency_uuid');
  }
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->currency_uuid = (string) Str::uuid(); // Genera un UUID
    });

    static::deleting(function ($currency) {
      // Elimina con soft delete todos los servicios asociados
      $currency->services()->each(function ($service) {
        $service->delete();
      });
    });
    static::restoring(function ($currency) {
      $currency->services()->onlyTrashed()->each(function ($service) {
        $service->restore();
      });
    });
  }
}
