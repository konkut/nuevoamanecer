<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Method extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'method_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'methods';
    protected $fillable = [
        'method_uuid',
        'name',
        'description',
        'status',
        'user_id',
        'bankregister_uuid'
    ];
    public function bankregister()
    {
        return $this->belongsTo(Bankregister::class, 'bankregister_uuid', 'bankregister_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->method_uuid = (string) Str::uuid();
        });

        static::deleting(function ($model) {
            // Elimina con soft delete todos los servicios asociados
            /*$service->incomefromtransfer()->each(function ($service) {
              $service->delete();
            });*/
        });
    }
}
