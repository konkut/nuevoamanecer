<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Denominationables extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'denominationable_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'denominationables';
    protected $fillable = [
        'denominationable_uuid',
        'denominationable_type',
        'denomination_uuid',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->denominationable_uuid = (string) Str::uuid(); // Genera un UUID
        });
       /* static::deleting(function ($denomination) {
            $denomination->incomefromtransfer()->delete();
        });
        static::restoring(function ($denomination) {
            $denomination->services()->onlyTrashed()->each(function ($denomination) {
                $denomination->restore();
            });
        });*/
    }
}
