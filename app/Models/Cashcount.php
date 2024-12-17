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
  protected $keyType = 'string';
  public $incrementing = false;
  protected $table = 'cashcounts';
  protected $fillable = [
    'cashcount_uuid',
    'physical_balance',
      'system_balance',
      'difference',
    'observation',
    'cashshift_uuid',
      'user_id',
      'status'
  ];

    public function denominations(){
        return $this->morphToMany(Denomination::class,'denominationable','denominationables','denominationable_uuid','denomination_uuid','cashcount_uuid','denomination_uuid');
    }
    public function denominationable()
    {
        return $this->hasMany(Denominationables::class, 'denominationable_uuid', 'cashcount_uuid');
    }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->cashcount_uuid = (string) Str::uuid();
    });
    static::deleting(function ($model) {
        $model->denominations()->delete();
        $model->denominationable()->delete();
    });
  }
}
