<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Receipt extends Model
{
    use HasFactory;
    protected $primaryKey = 'receipt_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'receipts';
    protected $fillable = [
        'receipt_uuid',
        'code',
        'amount',
        'date',
        'income_uuid',
    ];
    public function income()
    {
        return $this->belongsTo(Income::class, 'income_uuid', 'income_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->receipt_uuid = (string)Str::uuid();
        });
    }
}
