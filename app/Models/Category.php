<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $primaryKey = 'category_uuid';
  protected $keyType = 'string';
  public $incrementing = false;
  protected $table = 'categories';
  protected $fillable = [
    'category_uuid',
    'name',
    'description',
    'status',
  ];
  // Generar un UUID automáticamente al crear un nuevo modelo
  public function services()
  {
    return $this->hasMany(Service::class, 'category_uuid', 'category_uuid');
  }
  
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->category_uuid = (string) Str::uuid(); // Genera un UUID
    });
    static::deleting(function ($category) {
      // Elimina con soft delete todos los servicios asociados
      $category->services()->each(function ($category) {
        $category->delete();
      });
    });
    static::restoring(function ($category) {
      $category->services()->onlyTrashed()->each(function ($service) {
        $service->restore();
      });
    });
  }
}