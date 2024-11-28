<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Incomefromtransfer extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'incomefromtransfer_uuid';
  protected $keyType = 'string'; // Asegura que Laravel trate el primaryKey como string
  public $incrementing = false;
  protected $table = 'incomefromtransfers';
  protected $fillable = [
    'incomefromtransfer_uuid',
    'code',
    'amounts',
    'commissions',
    'service_uuids',
    /*'amount',
    'commission',*/
    'observation',
    'status',
    /*'service_uuid',*/
    'denomination_uuid',
    'user_id',
  ];

  protected $casts = [
    'amounts' => 'array',
    'commissions' => 'array',
    'service_uuids' => 'array',
  ];

  public function service()
  {
    return $this->belongsTo(Service::class, 'service_uuid', 'service_uuid');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function denomination()
  {
    return $this->hasOne(Denomination::class, 'denomination_uuid', 'denomination_uuid');
  }
  // Generar un UUID automáticamente al crear un nuevo modelo
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->incomefromtransfer_uuid = (string) Str::uuid(); // Genera un UUID
    });
    static::deleting(function ($incomefromtransfer) {
      $incomefromtransfer->denomination()->delete();
    });
    static::restoring(function ($incomefromtransfer) {
      $incomefromtransfer->services()->onlyTrashed()->each(function ($incomefromtransfer) {
        $incomefromtransfer->restore();
      });
    });
  }
}
