<?php
namespace App\Helpers;

use App\Models\Back\UserActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogHelper
{
    public static function logActivity(Model $model, string $action)
    {
        UserActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'old_data' => $action === 'تعديل' ? $model->getOriginal() : null, 
            'new_data' => $action !== 'حذف' ? $model->getAttributes() : null,
            'user_agent' => request()->userAgent(),
        ]);
    }
}