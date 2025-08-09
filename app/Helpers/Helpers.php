<?php

use App\Models\Back\AcademicYears;
use App\Models\Back\Setting;
use App\Models\Back\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// start get curren academic_yaer
if (!function_exists('GetAcademicYaer')) {
    function GetAcademicYaer(){
        $activeYear = AcademicYears::where('status', 1)->first();
        return $activeYear->id;
    }
}
// end get curren academic_yaer



// start get GeneralSettingsInfo
    if (!function_exists('GeneralSettingsInfo')) {
        function GeneralSettingsInfo(){
            return Setting::first();
        }
    }
// end get GeneralSettingsInfo



// start get authUserInfo
    if (!function_exists('authUserInfo')) {
        function authUserInfo(){
            return User::where('users.id', auth()->user()->id)
                        ->leftJoin('roles_permissions', 'roles_permissions.id', '=', 'users.user_status')
                        ->select(
                            'users.*',
                            'roles_permissions.role_name'
                        )
                        ->first();
        }
    }
// end get authUserInfo


// start show الارقام العشريه

    //if (!function_exists('display_number')) {
    //    function display_number($number) {
    //        // تأكد أنه رقم
    //        if (!is_numeric($number)) {
    //            return $number;
    //        }

    //        if (strpos($number, '.') !== false) {
    //            // إذا كانت فقط .00 أو أصفار بعد الفاصلة
    //            if (preg_match('/\.0+$/', $number)) {
    //                return number_format((int)$number);
    //            }

    //            // إزالة الأصفار الزائدة بعد الفاصلة بدون تقريب
    //            $trimmed = rtrim(rtrim($number, '0'), '.');
    //            return number_format($trimmed, strlen(substr(strrchr($trimmed, '.'), 1)), '.', ',');
    //        }

    //        // رقم صحيح بدون فاصل عشري
    //        return number_format($number);
    //    }
    //}

    if (!function_exists('display_number')) {
        function display_number($number) {
            // تأكد أنه رقم
            if (!is_numeric($number)) {
                return $number;
            }

            // تحويل إلى سلسلة نصية للتحقق من الفاصلة العشرية
            $number_str = (string)$number;

            if (strpos($number_str, '.') !== false) {
                // فصل الأجزاء قبل وبعد الفاصلة
                $parts = explode('.', $number_str);
                $integer_part = $parts[0];
                $decimal_part = substr($parts[1], 0, 2); // أخذ منزلتين عشريتين فقط
                
                // إعادة تجميع الرقم مع منزلتين عشريتين
                $trimmed_number = $integer_part . '.' . $decimal_part;
                
                // تنسيق الرقم مع الفواصل كآلاف
                return number_format((float)$trimmed_number, strlen($decimal_part), '.', ',');
            }

            // رقم صحيح بدون فاصل عشري
            return number_format((float)$number);
        }
    }

// end show الارقام العشريه


// start function role_permissions
function userPermissions(){
    $permissions = DB::table('users')
            ->where('users.id', auth()->user()->id)
            ->leftJoin('roles_permissions', 'roles_permissions.id', '=', 'users.user_role')
            ->select('roles_permissions.*')
            ->first();
        
    return $permissions;
}
// end function role_permissions
