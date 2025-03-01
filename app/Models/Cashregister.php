<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cashregister extends Model
{
    use HasFactory;
    protected $primaryKey = 'cashregister_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'cashregisters';
    protected $fillable = [
        'cashregister_uuid',
        'name',
        'status',
        'total',
        'denomination_uuid',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function incomes()
    {
        return $this->belongsToMany(Income::class, 'income_cashregisters', 'cashregister_uuid', 'income_uuid')
            ->withPivot(['total','type','index']);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_cashregisters', 'cashregister_uuid', 'sale_uuid')
            ->withPivot(['total','index']);
    }
    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_cashregisters', 'cashregister_uuid', 'expense_uuid')
            ->withPivot(['total']);
    }
    public function denomination()
    {
        return $this->belongsTo(Denomination::class, 'denomination_uuid', 'denomination_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->cashregister_uuid = (string) Str::uuid();
        });
        static::deleting(function ($model) {
            $model->denomination()->delete();
        });
    }
}
