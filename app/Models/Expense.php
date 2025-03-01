<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Expense extends Model
{
    use HasFactory;
    protected $primaryKey = 'expense_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'expenses';
    protected $fillable = [
        'expense_uuid',
        'amount',
        'observation',
        'category_uuid',
        'denomination_uuid',
        'cashshift_uuid',
    ];
    public function cashshift()
    {
        return $this->belongsTo(Cashshift::class, 'cashshift_uuid', 'cashshift_uuid');
    }
    public function denomination()
    {
        return $this->hasOne(Denomination::class, 'denomination_uuid', 'denomination_uuid');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'category_uuid');
    }
    public function cashregisters()
    {
        return $this->belongsToMany(Cashregister::class, 'expense_cashregisters', 'expense_uuid', 'cashregister_uuid')
            ->withPivot(['total',]);
    }
    public function bankregisters()
    {
        return $this->belongsToMany(Bankregister::class, 'expense_bankregisters', 'expense_uuid', 'bankregister_uuid')
            ->withPivot(['total',]);
    }
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'expense_platforms', 'expense_uuid', 'platform_uuid')
            ->withPivot(['total']);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->expense_uuid = (string)Str::uuid();
        });
        static::deleting(function ($model) {
            //$model->denominations()->delete();
        });
        /*
        static::restoring(function ($incomefromtransfer) {
          $incomefromtransfer->services()->onlyTrashed()->each(function ($incomefromtransfer) {
            $incomefromtransfer->restore();
          });
        });*/
    }
}
