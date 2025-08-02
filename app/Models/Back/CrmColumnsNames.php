<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActivityLogHelper;


class CrmColumnsNames extends Model
{
    protected $table = 'crm_columns_names';
    protected $fillable = ['category', 'order', 'status', 'name_ar'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            ActivityLogHelper::logActivity($model, 'إضافة');
        });

        static::updated(function ($model) {
            ActivityLogHelper::logActivity($model, 'تعديل');
        });

        static::deleted(function ($model) {
            ActivityLogHelper::logActivity($model, 'حذف');
        });
    }
}
