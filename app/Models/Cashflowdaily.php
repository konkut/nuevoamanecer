<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cashflowdaily extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'cashflowdaily_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'cashflowdailies';
    protected $fillable = [
        'cashflowdaily_uuid',
        'date',
        'total_opening',
        'total_closing',
        'total_incomes',
        'total_expenses',
        'total_physical',
        'total_services',
        'total_opening_uuid',
        'total_closing_uuid',
        'total_incomes_uuid',
        'total_expenses_uuid',
        'total_physical_uuid',
    ];
    public function total_denominations_opening(){
        return $this->belongsTo(Denomination::class,'total_opening_uuid','denomination_uuid');
    }
    public function total_denominations_closing(){
        return $this->belongsTo(Denomination::class,'total_closing_uuid','denomination_uuid');
    }
    public function total_denominations_incomes(){
        return $this->belongsTo(Denomination::class,'total_incomes_uuid','denomination_uuid');
    }
    public function total_denominations_expenses(){
        return $this->belongsTo(Denomination::class,'total_expenses_uuid','denomination_uuid');
    }
    public function total_denominations_physical(){
        return $this->belongsTo(Denomination::class,'total_physical_uuid','denomination_uuid');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->cashflowdaily_uuid = (string) Str::uuid();
        });
        static::deleting(function ($model) {
            //$model->denominations()->delete();
        });
    }
}
