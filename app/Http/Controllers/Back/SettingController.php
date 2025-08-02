<?php

namespace App\Http\Controllers\Back;

use DB;
use App\Models\Back\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index()
    {
        $pageNameAr = 'الإعدادات العامة';
        $pageNameEn = 'general_settings';
        $find = DB::table('settings')->where('id', 1)->first();

        //dd($find->name);
        return view('back.general_settings.index', compact('pageNameAr', 'pageNameEn', 'find'));
    }

    public function update(Request $request)
    {
        $find = DB::table('settings')->where('id', 1)->first();

        $this->validate($request , [
            'name' => 'required',
            'phone1' => 'required',
            'address' => 'required',
            'logo_website' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:1500',
            'logo_dashboard' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:1500',
            'fav_icon' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:1500',
        ],[
            'name.required' => 'اسم البرنامج مطلوب',
            'phone1.required' => 'رقم التلفون الأول مطلوب',
            'address.required' => 'العنوان مطلوب',
            'logo_website.max' => 'صورة الموقع حجمها أكبر من :max بيكسل.',
            'logo_website.mimes' => 'صورة الموقع يجب أن تكون من نوع JPG أو PNG أو JPEG أو GIF.',
            'logo_dashboard.max' => 'صورة لوحة التحكم حجمها أكبر من :max بيكسل.',
            'logo_dashboard.mimes' => 'صورة لوحة التحكم يجب أن تكون من نوع JPG أو PNG أو JPEG أو GIF.',
            'fav_icon.max' => ':attribute حجمها أكبر من :max بيكسل.',
            'fav_icon.mimes' => ':attribute يجب أن تكون من نوع JPG أو PNG أو JPEG أو GIF.',
        ]);


        DB::transaction(function () use($find) {
            
            if(request()->hasFile('logo_website')){
                File::delete(public_path('back/images/settings/'.$find->logo_website));
    
                $file = request('logo_website');
                $logo_website = 'logo_website' . '.' .$file->getClientOriginalExtension();
                $path = public_path('back/images/settings');
                $file->move($path , $logo_website);
    
            }else{
                $logo_website = request('logo_website_hidden');
            }
    
            if(request()->hasFile('logo_dashboard')){
                File::delete(public_path('back/images/settings/'.$find->logo_dashboard));
    
                $file = request('logo_dashboard');
                $logo_dashboard = 'logo_dashboard' . '.' .$file->getClientOriginalExtension();
                $path = public_path('back/images/settings');
                $file->move($path , $logo_dashboard);
    
            }else{
                $logo_dashboard = request('logo_dashboard_hidden');
            }
    
            if(request()->hasFile('fav_icon')){
                File::delete(public_path('back/images/settings/'.$find->fav_icon));
    
                $file = request('fav_icon');
                $fav_icon = 'fav_icon' . '.' .$file->getClientOriginalExtension();
                $path = public_path('back/images/settings');
                $file->move($path , $fav_icon);
    
            }else{
                $fav_icon = request('fav_icon_hidden');
            }
    
            $data = [
                'name' => request('name'),
                'description' => request('description'),
                'footer_text' => request('footer_text'),
                'address' => request('address'),
                'city' => request('city'),
                'zip_code' => request('zip_code'),
                'email' => request('email'),
                'phone1' => request('phone1'),
                'phone2' => request('phone2'),
                'logo_website' => $logo_website,
                'logo_dashboard' => $logo_dashboard,
                'fav_icon' => $fav_icon,
                'mail_driver' => request('mail_driver'),
                'from' => request('from'),
                'to' => request('to'),
                'host' => request('host'),
                'port' => request('port'),
                'encryption' => request('encryption'),
                'username' => request('username'),
                'password' => request('password'),
                'facebook' => request('facebook'),
                'twitter' => request('twitter'),
                'instagram' => request('instagram'),
                'google' => request('google'),
                'tiktok' => request('tiktok'),
                'youtube' => request('youtube'),
                //'maintenance_mode' => request('maintenance_mode') == null ? 0 : 1,
            ];
    
            DB::table('settings')->where('id', 1)->update($data);
            
        });

    }
}