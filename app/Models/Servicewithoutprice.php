<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servicewithoutprice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'servicewithoutprice_uuid';
    protected $table = 'servicewithoutprices';
    protected $fillable = [
      'servicewithoutprice_uuid',
      'name',
      'description',
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
    /*public function paymentwithoutprice()
    {
        return $this->hasMany(Paymentwithoutprice::class, 'servicewithoutprice_uuid', 'servicewithoutprice_uuid');
    }*/
    /*
    public function incomefromtransfer()
  {
    return $this->hasMany(Incomefromtransfer::class, 'service_uuid', 'service_uuid');
  }
    */
    protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->servicewithoutprice_uuid = (string) Str::uuid(); // Genera un UUID
    });
      static::deleting(function ($model) {
          $model->paymentwithoutprice()->each(function ($row) {
              $row->delete();
          });
      });
  }
}
