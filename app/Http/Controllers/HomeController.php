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
        $checkID = Setting::where('user_id',Auth::user()->id)->first();
        if ($checkID->user_id != null) {
            Setting::where('user_id',Auth::user()->id)->update(['display' => ""]);
        }else{
            $user_id = Auth::user()->id;
            $display_setting = new Setting;
            $display_setting->user_id = $user_id;
            $display_setting->display = "dark";
            $display_setting->save();
        }
        return response()->json(
            [
                "status"=>true,
                "msg"=>"You have successfully display,",
                "redirect_location"=>url("")
            ]
        );
    }
}
