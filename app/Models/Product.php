<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'product_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'products';
    protected $fillable = [
        'product_uuid',
        'name',
        'description',
        'price',
        'stock',
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
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_products', 'product_uuid', 'sale_uuid')
            ->withPivot(['quantity','amount','index']);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->product_uuid = (string)Str::uuid();
        });
        /*
        static::deleting(function ($model) {
            $model->paymentwithoutprice()->each(function ($row) {
                $row->delete();
            });
        });*/
    }
}
