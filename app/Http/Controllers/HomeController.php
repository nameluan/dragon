<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('feed.index');
    }
    public function explore()
    {
        return view('explore.index');
    }
    public function messages()
    {
        return view('messages.index');
    }
    public function market()
    {
        return view('marketplace.index');
    }
    public function trending()
    {
        return view('trending.index');
    }
    public function setting()
    {
        return view('settings.index');
    }
    public function display(Request $request){
        $checkID = Setting::where('user_id',Auth::user()->id)->get();
        dd($checkID);
        if (isset($checkID)) {
            dd("123");
        }else{
            dd("no");
        }
    }
}
