<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactionmethod extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'transactionmethod_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'transactionmethods';
    protected $fillable = [
      'transactionmethod_uuid',
      'name',
      'description',
        'balance',
      'status',
    ];

    protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->transactionmethod_uuid = (string) Str::uuid();
    });

    static::deleting(function ($transactionmethod) {
      // Elimina con soft delete todos los servicios asociados
      /*$service->incomefromtransfer()->each(function ($service) {
        $service->delete();
      });*/
    });
  }
}
