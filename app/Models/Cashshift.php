<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cashshift extends Model
{
    use HasFactory;
    protected $primaryKey = 'cashshift_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'cashshifts';
    protected $fillable = [
        'cashshift_uuid',
        'start_time',
        'end_time',
        'status',
        'observation',
        'user_id',
        'cashregister_uuid',
    ];
    public function bankregisters()
    {
        return $this->belongsToMany(Bankregister::class, 'cashshift_bankregisters', 'cashshift_uuid', 'bankregister_uuid')
            ->withPivot(['total','type']);
    }
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'cashshift_platforms', 'cashshift_uuid', 'platform_uuid')
            ->withPivot(['total','type']);
    }
    public function denominations()
    {
        return $this->belongsToMany(Denomination::class, 'cashshift_denominations', 'cashshift_uuid', 'denomination_uuid')
            ->withPivot(['type']);
    }
    public function cashregister()
    {
        return $this->belongsTo(Cashregister::class, 'cashregister_uuid', 'cashregister_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sales(){
        return $this->hasMany(Sale::class, 'cashshift_uuid', 'cashshift_uuid');
    }
    public function expenses(){
        return $this->hasMany(Expense::class, 'cashshift_uuid', 'cashshift_uuid');
    }
    public function incomes(){
        return $this->hasMany(Income::class, 'cashshift_uuid', 'cashshift_uuid');
    }



    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->cashshift_uuid = (string) Str::uuid();
        });
        static::deleting(function ($model) {
            /*$model->denominations_opening()->delete();
            $model->denominations_closing()->delete();
            $model->denominations_physical()->delete();
            $model->denominations_incomes()->delete();
            $model->denominations_expenses()->delete();
            $model->denominations_difference()->delete();*/
        });
    }
}
