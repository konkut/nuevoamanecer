<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Voucherdetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'voucherdetail_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'voucherdetails';
    protected $fillable = [
        'voucherdetail_uuid',
        'debit',
        'credit',
        'index',
        'voucher_uuid',
        'analyticalaccount_uuid',
    ];
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_uuid', 'voucher_uuid');
    }
    public function analyticalaccount()
    {
        return $this->belongsTo(Analyticalaccount::class, 'analyticalaccount_uuid', 'analyticalaccount_uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->voucherdetail_uuid = (string) Str::uuid();
        });
    }
}
