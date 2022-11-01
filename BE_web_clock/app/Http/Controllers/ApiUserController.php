<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\user\ApiRegisterRequest;
use App\Http\Requests\user\ApiLoginRequest;
use App\Http\Requests\user\ApiUpdatePasswordRequest;
use App\Http\Requests\user\ApiUserUpdateRequest;
use App\Http\Requests\user\ApiShipmentDetailRequest;

use Illuminate\Support\Facades\File;
use App\Models\User\user;
use App\Models\User\ShipmentDetails;

class ApiUserController extends Controller
{
    public function register(ApiRegisterRequest $request){
        $user = new user;
        $user -> fill($request->all());
        $user->password = Hash::make($request->password);
        $user->image = 'null';
        $user->save();

        return response()->json($user);
    }
    public function login(ApiLoginRequest $request){
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(Auth::guard('user')->attempt([
        $fieldType => $request->username,
        'password' => $request->password]))
        {
            $User = user::where('username','=',$request->username)->first();
            $User -> token = $User->createToken('User', ['user'])->accessToken;
            return response()->json($User);
        }
        {
            return response()->json(['message'=>'sai tên đăng nhập hoặc mật khẩu'],401);
        }
    }
    public function userInfor(Request $request){
        
        return response()->json($request->user('api_user'));
    }
    public function UpdatePassword(ApiUpdatePasswordRequest $request){
        $User = user::find(Auth::user()->id);
        $old_password = $request->password;
        $newpassword = Hash::make($request->newpassword);
        $password = Auth::user()->password;

        if(Hash::check($old_password, $password)){
            $User->update([
                'password'=>$newpassword
            ]);
            return response()->json(['message'=>'Đổi mật khẩu thành công']);
        }
        else{
            return response()->json(['message'=>'Mật khẩu bạn nhập không chính xác'],401);
        }
    }
    public function UpdateUser(ApiUserUpdateRequest $request){
        $User = user::find(Auth::user()->id);
        $image = $User->image;

        $User->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        if($request->hasFile('image')){
            $pathToFile = $request->file('image')->store('public/images/users');
            $NameImage = $request->file('image')->hashName();
            $User->update([
                'image'=>$NameImage,
            ]);
            $destination = 'storage/images/users/'.$image;
            if(File::exists($destination)){
                File::delete($destination);
            }
        }
        return response()->json($User);
    }
    public function ShipmentDetails(Request $request){
        $shipmentDatail = ShipmentDetails::where('id_user',$request->id)->get();
        return response()->json($shipmentDatail);
    }
    public function UpShipmentDetails(ApiShipmentDetailRequest $request){
        $details = ShipmentDetails::where('id_user','=',$request->id_user)->first();
        if($details ===null){
            $shipmentDatail = new ShipmentDetails;
            $shipmentDatail->fill($request->all());
            $shipmentDatail->save();            
        }
        else{
            $shipmentDatail = ShipmentDetails::where('id_user',$request->id_user)->first();
            $shipmentDatail->update([
                'name'=>$request->name,
                'surname'=>$request->surname,
                'phone_number'=>$request->phone_number,
                'city_province'=>$request->city_province,
                'district'=>$request->district,
                'wards'=>$request->wards,
                'address'=>$request->address,
            ]);
        }
        return response()->json($shipmentDatail);

    }
}
