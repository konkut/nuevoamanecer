<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Servicewithprice extends Model
{
    use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'servicewithprice_uuid';
  protected $keyType = 'string';
  public $incrementing = false;
  protected $table = 'servicewithprices';
  protected $fillable = [
    'servicewithprice_uuid',
    'name',
    'description',
    'amount',
    'commission',
    'status',
    'category_uuid',
    'user_id',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_uuid', 'category_uuid');
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
    public function paymentwithoutprice()
    {
        return $this->hasMany(Paymentwithoutprice::class, 'servicewithprice_uuid', 'servicewithprice_uuid');
    }
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->servicewithprice_uuid = (string) Str::uuid();
    });
      static::deleting(function ($model) {
          $model->paymentwithoutprice()->each(function ($row) {
              $row->delete();
          });
      });
  }

}
