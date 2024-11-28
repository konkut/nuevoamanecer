<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cashcount extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'cashcount_uuid';
  protected $keyType = 'string'; // Asegura que Laravel trate el primaryKey como string
  public $incrementing = false;
  protected $table = 'cashcounts';
  protected $fillable = [
    'cashcount_uuid',
    'date',
    'opening',
    'closing',
    'opening_denomination_uuid',
    'closing_denomination_uuid',
    'user_id',
  ];

  public function opening_denomination()
  {
    return $this->hasOne(Denomination::class, 'denomination_uuid', 'opening_denomination_uuid');
  }

  public function closing_denomination()
  {
    return $this->hasOne(Denomination::class, 'denomination_uuid', 'closing_denomination_uuid');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // Generar un UUID automáticamente al crear un nuevo modelo
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->cashcount_uuid = (string) Str::uuid(); // Genera un UUID
    });
    static::deleting(function ($cashcount) {
      $cashcount->denomination()->delete();
    });
  }
}
