<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'service_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'services';
    protected $fillable = [
        'service_uuid',
        'name',
        'description',
        'amount',
        'commission',
        'status',
        'category_uuid',
        'user_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'category_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function incomes()
    {
        return $this->belongsToMany(Income::class, 'income_services', 'service_uuid', 'income_uuid')
            ->withPivot(['code','quantity','amount','commission','index']);
    }




    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->service_uuid = (string)Str::uuid();
        });
        static::deleting(function ($model) {
            /*$model->paymentwithoutprice()->each(function ($row) {
                $row->delete();
            });*/
        });
    }
}
