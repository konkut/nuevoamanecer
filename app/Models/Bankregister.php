<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Bankregister extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'bankregister_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'bankregisters';
    protected $fillable = [
        'bankregister_uuid',
        'name',
        'account_number',
        'owner_name',
        'total',
        'status',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cashshifts()
    {
        return $this->belongsToMany(Cashshift::class, 'cashshift_bankregisters', 'bankregister_uuid', 'cashshift_uuid')
            ->withPivot(['total','type']);
    }
    public function incomes()
    {
        return $this->belongsToMany(Income::class, 'income_bankregisters', 'bankregister_uuid', 'income_uuid')
            ->withPivot(['total','type','index']);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_bankregisters', 'bankregister_uuid', 'sale_uuid')
            ->withPivot(['total','index']);
    }
    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_bankregisters', 'bankregister_uuid', 'expense_uuid')
            ->withPivot(['total']);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->bankregister_uuid = (string) Str::uuid();
        });
    }
}
