<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accountsubgroup extends Model
{
    use HasFactory;
    protected $primaryKey = 'accountsubgroup_uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'accountsubgroups';
    protected $fillable = [
        'accountsubgroup_uuid',
        'code',
        'name',
        'description',
        'accountgroup_uuid',
        'status',
        'user_id'
    ];
    public function accountgroup()
    {
        return $this->belongsTo(Accountgroup::class, 'accountgroup_uuid', 'accountgroup_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mainaccounts()
    {
        $project = Project::where('project_uuid',session('project_uuid'))->with(['company.businesstype'])->first();
        $businesstype_uuid = $project->company->businesstype->businesstype_uuid;
        return $this->hasMany(Mainaccount::class, 'accountsubgroup_uuid', 'accountsubgroup_uuid')
            ->join('mainaccount_businesstypes','mainaccount_businesstypes.mainaccount_uuid', '=','mainaccounts.mainaccount_uuid')
            ->where('mainaccount_businesstypes.businesstype_uuid',$businesstype_uuid)
            ->orderByRaw('CAST(mainaccounts.code AS UNSIGNED) ASC');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->accountsubgroup_uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
