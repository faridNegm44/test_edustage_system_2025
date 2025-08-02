<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\FacebookReviews;
use App\Models\Back\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $facebook_reviews = FacebookReviews::orderBy('id', 'ASC')->take(4)->get();
        return view('front.welcome', compact('facebook_reviews'));
    }

    public function contact(){
        $settings = Setting::first();
        return view('front.contact', compact('settings'));
    }
}
