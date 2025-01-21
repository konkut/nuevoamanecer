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
    protected $keyType = 'string';
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
        'total',
        'cashregister_uuid',
        'cashshift_uuid',
        'income_uuid',
        'expense_uuid',
        'sale_uuid',
    ];
    protected $attributes = [
        'bill_200' => 0.00,
        'bill_100' => 0.00,
        'bill_50' => 0.00,
        'bill_20' => 0.00,
        'bill_10' => 0.00,
        'coin_5' => 0.00,
        'coin_2' => 0.00,
        'coin_1' => 0.00,
        'coin_0_5' => 0.00,
        'coin_0_2' => 0.00,
        'coin_0_1' => 0.00,
        'total' => 0.00,
    ];
    public function cashregister()
    {
        return $this->belongsTo(Cashregister::class, 'cashregister_uuid', 'cashregister_uuid');
    }

    public function cashshift()
    {
        return $this->belongsTo(Cashshift::class, 'cashshift_uuid', 'cashshift_uuid');
    }
    public function income()
    {
        return $this->belongsTo(Income::class, 'income_uuid', 'income_uuid');
    }
    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_uuid', 'expense_uuid');
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_uuid', 'sale_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->denomination_uuid = (string)Str::uuid();
        });
    }
}
