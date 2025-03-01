<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Platform extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'platform_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'platforms';
    protected $fillable = [
        'platform_uuid',
        'name',
        'description',
        'status',
        'total',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cashshifts()
    {
        return $this->belongsToMany(Cashshift::class, 'cashshift_platforms', 'platform_uuid', 'cashshift_uuid')
            ->withPivot(['total','type']);
    }
    public function incomes()
    {
        return $this->belongsToMany(Income::class, 'income_platforms', 'platform_uuid', 'income_uuid')
            ->withPivot(['total','type','index']);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_platforms', 'platform_uuid', 'sale_uuid')
            ->withPivot(['total','index']);
    }
    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_platforms', 'platform_uuid', 'expense_uuid')
            ->withPivot(['total']);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->platform_uuid = (string) Str::uuid();
        });

        static::deleting(function ($model) {
            // Elimina con soft delete todos los servicios asociados
            /*$service->incomefromtransfer()->each(function ($service) {
              $service->delete();
            });*/
        });
    }
}
