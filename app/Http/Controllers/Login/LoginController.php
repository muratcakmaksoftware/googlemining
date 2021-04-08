<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {

        $site_name = settings("site_name");
        $logo = Storage::disk('upload')->url(settings("logo"));
        return view('login.index')
            ->with("site_name", $site_name)
            ->with("logo", $logo);
    }

    public function auth(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $errorMessage = [
            'username.required' => 'Lütfen Kullanıcı Adını Giriniz!',
            'password.required' => 'Lütfen Şifrenizi Giriniz!'
        ];
        $validator = Validator::make($request->all(), $rules, $errorMessage);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $username = $request->get("username");
        $password = $request->get("password");

        $credentials = [
            'username' => $username,
            'password' => $password,
        ];

        $auth = auth()->guard('web');
        if($auth->attempt($credentials)){
            return redirect()->route('admin.home');
        }else{
            $errorMessage = "Kullanıcı Adı veya Şifre Yanlış!";
            return redirect()->back()->with('errorMessage', $errorMessage);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login.index');
    }
}
