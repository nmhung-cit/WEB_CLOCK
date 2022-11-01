<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\admin\ApiRegisterRequest;
use App\Http\Requests\admin\ApiLoginRequest;
use App\Models\Admin\admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiAdminController extends Controller
{
    public function register(ApiRegisterRequest $request){
        $admin = new admin;
        $admin -> fill($request->all());
        $admin->password = Hash::make($request->password);

        $admin->save();

        return response()->json($admin);
    }
    public function login(ApiLoginRequest $request){
        if(auth('admin')->attempt([
        'username' => $request->username,
        'password' => $request->password]))
        {
           $Admin = admin::Where('username','=',$request -> username)->first();
           $Admin->token = $Admin->createToken('Admin', ['admin'])->accessToken;
           return response()->json($Admin);
        }
        {
           return response()->json(['message'=>'sai tên đăng nhập hoặc mật khẩu'],401);
        }
    }

    public function adminInfor(Request $request){
        return response()->json($request->user('api_admin'));
    }

    
}
