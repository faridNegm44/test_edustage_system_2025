<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Blog;
use App\Models\Back\Courses;
use App\Models\Back\Faq;
use App\Models\Back\Setting;
use App\Models\Back\Teacher;
use App\Models\Back\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        // $settings = Setting::first();

        // delete all dates before today from time_table
        $today = Carbon::now()->toDateString();
        DB::table('time_tables')->whereDate('date', '<', $today)->delete();

        $academic_years = DB::table('academic_years')->get();

        if(auth()->user()->user_status != 3){
            $selected_academic_years = DB::table('users')->where('id', auth()->user()->id)->first();
        }

        return view('back.welcome', get_defined_vars());
    }

    public function login_post(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ],[
            'email.required' => 'البريد الإلكتروني مطلوب',
            'password.required' => 'الرقم السري مطلوب',
        ]);

        $email = request('email');
        $password = request('password');
        $user = User::where('email', $email)->first();

        if(!$user){
            session()->put('error_email_or_password', 'من فضلك تأكد من البريد الإلكتروني و الرقم السري');
            return redirect()->back();
        }

        if ($user->pass_type === 'text') { // start check if $user->pass_type === 'text'
            if ($email === $user->email && $password === $user->password){  // check if $email === $user->email and $password === $user->password

                User::where('email', $email)->update([
                    'password' => Hash::make($password),
                    'pass_type' => 'hash',
                    'last_login_time' => now(),
                ]);

                Auth::attempt(['email' => $email , 'password' => $password]);
                return redirect('/')->with("success_login", "");

                // delete all dates before today from time_table
                $today = Carbon::now()->toDateString();
                DB::table('time_tables')->whereDate('date', '<', $today)->delete();
            }else{
                session()->put('error_email_or_password', 'من فضلك تأكد من البريد الإلكتروني و الرقم السري');
                return redirect()->back();
            }

        }else{ // check if $user->pass_type === 'hash'

            if(Auth::attempt(['email' => $email , 'password' => $password])){
                User::where('email', $email)->update([
                    'last_login_time' => now(),
                ]);
                return redirect('/')->with("success_login", "");

                // delete all dates before today from time_table
                $today = Carbon::now()->toDateString();
                DB::table('time_tables')->whereDate('date', '<', $today)->delete();

            }else{
                session()->put('error_email_or_password', 'من فضلك تأكد من البريد الإلكتروني و الرقم السري');
                return redirect()->back();
            }
        } // end check if $user->pass_type === 'text'  ||  'hash'
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
