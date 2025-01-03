<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Denomination extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'denomination_uuid';
    protected $keyType = 'string'; // Asegura que Laravel trate el primaryKey como string
    public $incrementing = false;
    protected $table = 'denominations';
    protected $fillable = [
        'denomination_uuid',
        'type',
        'bill_200',
        'bill_100',
        'bill_50',
        'bill_20',
        'bill_10',
        'coin_5',
        'coin_2',
        'coin_1',
        'coin_0_5',
        'coin_0_2',
        'coin_0_1',
        'physical_cash',
        'digital_cash',
        'total',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->denomination_uuid = (string)Str::uuid(); // Genera un UUID
        });
        /*
          static::deleting(function ($model) {
              $model->paymentwithoutprice()->delete();
          });*/
        /*
        static::restoring(function ($denomination) {
          $denomination->services()->onlyTrashed()->each(function ($denomination) {
            $denomination->restore();
          });
        });*/
    }
}
