<?php

namespace App\Models\Back;

use App\Helpers\ActivityLogHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'user_status',
        'active',
        'last_login_time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role_relation(){
        return $this->belongsTo("App\Models\Back\RolesPermissions" , "role");
    }

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
