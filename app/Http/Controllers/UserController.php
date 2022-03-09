<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    const EMAIL_REGEX = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

    public function login (Request $request){
        if ($request->isMethod('get')) {
            return view('user.login');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',

            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors(),422);

            } else {
                $username = $request->username;
                $checkEmail = preg_match(self::EMAIL_REGEX, $username, $matches);
                if ($checkEmail == 1) {
                    if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                        if (Auth::user()->status == "on"){
                            return response()->json(["status"=>true,"redirect_location"=>url("/")]);
                        }else if (Auth::user()->status == "off"){
                            return response()->json(["msgErrOff" => "The account has been OFF, please contact admin"]);
                        }else if (Auth::user()->status == "block"){
                            return response()->json(["msgErrBlock" => "The account has been locked, please contact admin"]);
                        }
                    }
                }

                if ($checkEmail == 0) {
                    if (Auth::attempt(['phoneNumber' => $request->username, 'password' => $request->password, 'status' => 'on'])) {
                        if (Auth::user()->status == "on"){
                            return response()->json(["status"=>true,"redirect_location"=>url("/")]);
                        }else if (Auth::user()->status == "off"){
                            return response()->json(["msgErrOff" => "The account has been OFF, please contact admin"]);
                        }else if (Auth::user()->status == "block"){
                            return response()->json(["msgErrBlock" => "The account has been locked, please contact admin"]);
                        }
                    }else {
                        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 'on'])) {
                            if (Auth::user()->status == "on"){
                                return response()->json(["status"=>true,"redirect_location"=>url("/")]);
                            }else if (Auth::user()->status == "off"){
                                return response()->json(["msgErrOff" => "The account has been OFF, please contact admin"]);
                            }else if (Auth::user()->status == "block"){
                                return response()->json(["msgErrBlock" => "The account has been locked, please contact admin"]);
                            }
                        } else {
                            return response()->json(["msgErr" => "Please re-enter email, phone number or password!"]);
                        }
                    }
                }
            }
        }
    }
    public function register (Request $request){
        if ($request->isMethod('get')) {
            return view('user.register');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',

            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors(),422);

            } else {
                $User = new User;
                $idUser = Str::uuid();
                $User->id = $idUser;
                $User->role_id = '1';
                $User->firstName = $request->firstName;
                $User->lastName = $request->lastName;
                $User->username = changeTitleUsername($request->firstName)
                                . changeTitleUsername($request->lastName)
                                . Str::random(5);
                $User->email = $request->email;
                $User->password = bcrypt($request->password);
                $User->status = 'on';
                if (isset($request->avatarString)) {
                    $User->avatarString = $request->avatarString;
                } else {
                    $User->avatarString = 'avt.png';
                }

                $User->save();

                $setting = new Setting;
                $setting->user_id = $idUser;
                $setting->display = "light";
                $setting->save();

                return response()->json(
                    [
                        "status"=>true,
                        "msg"=>"You have successfully registered, Login to access your dashboard",
                        "redirect_location"=>url("user/login")
                    ]
                );

            }
        }
    }
    public function forgot (Request $request){
        if ($request->isMethod('get')) {
            return view('user.forgot');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);
            if ($validator->fails())
            {
                return response()->json(['error'=>$validator->errors()->all()]);

            }else{
                $token = Str::random(64);

                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);

                Mail::send('email.forgotPassword', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });

                return response()->json(
                    [
                        "status"=>true,
                        "msg"=>"We have e-mailed your password reset link!",
                    ]
                );
            }
        }
    }
    public function reset (Request $request, $token){
        if ($request->isMethod('get')) {
            return view('user.reset', ['token' => $token]);
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ]);
            if ($validator->fails())
            {
                return response()->json(['error'=>$validator->errors()->all()]);

            }else{
                $updatePassword = DB::table('password_resets')
                                    ->where([
                                    'email' => $request->email,
                                    'token' => $request->token
                                    ])
                                    ->first();

                if(!$updatePassword){
                    return back()->withInput()->with('error', 'Invalid token!');
                }

                $user = User::where('email', $request->email)
                            ->update(['password' => bcrypt($request->password)]);

                DB::table('password_resets')->where(['email'=> $request->email])->delete();

                return response()->json(
                    [
                        "status"=>true,
                        "msg"=>"You have successfully registered, Login to access your dashboard",
                        "redirect_location"=>url("user/login")
                    ]
                );
            }
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
    public function friend(){
        return view('user.profile-friend');
    }
}
