<?php

namespace App\Http\Controllers\ApiSales\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Storage;

use App\Models\Sales;

use App\Http\Resources\ValueMessage;
use App\Http\Resources\Sales as SalesResource;

class AuthController extends Controller
{
    
    public $successStatus = 200;

    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'device_name' => 'required',
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(new ValueMessage(['value'=>0,'message'=>'Field Empty!','data'=> $validator->errors()]), 400);
        }
        else{
            if(auth()->guard('sales')->attempt($request->only('email','password'))){

                $user = auth()->guard('sales')->user();
                if($user->active=='active'){
                    $user->tokens()->delete();
                    $success['token'] =  $user->createToken($request->device_name)->plainTextToken;
                
                    return response()->json(new ValueMessage(['value'=>1,'message'=>'Login Success!','data'=> $success]), $this->successStatus);
                }else{

                    return response()->json(new ValueMessage(['value'=>0,'message'=>'User Suspended!','data'=> '']), 403);
                }
            }
            else{
                return response()->json(new ValueMessage(['value'=>0,'message'=>'User Credential Wrong!','data'=> '']), 401);
            }     
        }
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(new ValueMessage(['value'=>1,'message'=>'Logout Success','data'=> '']),$this->successStatus);
    }


    public function detail(Request $request)
    {
        if($request->user()->photo_url==null){
            $data=$request->user(); 
            $data->photo='user_photo/default_user.jpg';
        }else{
            $data=$request->user();
        }
   		return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Data Success','data'=> new SalesResource($data)]),$this->successStatus);
    }


    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(new ValueMessage(['value'=>0,'message'=>'Field Empty!','data'=> $validator->errors()]), 400);         
        }else{
            if(auth()->guard('sales')->attempt(['email'=>$request->user()->email,'password'=>$request->current_password])){

                Sales::where('id',$request->user()->id)->update([
                    'password'=>Hash::make($request->new_password)
                ]);

                return response()->json(new ValueMessage(['value'=>1,'message'=>'Change Password Success','data'=>'']),$this->successStatus);
            }else{
                return response()->json(new ValueMessage(['value'=>0,'message'=>'Password Wrong','data'=> '']),401);
            }
            
        }
    
    }
    public function changePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(new ValueMessage(['value'=>0,'message'=>'Field Empty!','data'=> $validator->errors()]), 400);         
        }else{
            $sales=Sales::where('id',Auth::id())->first();

            if($sales->photo_url!=null){
                Storage::disk('public')->delete($sales->photo_url);
            }
            $photo=null;
            if($request->has('photo')){
                $fileName= str_replace(' ','-', $sales->name.'_'.$sales->id.'_'.date('d-m-Y_H-i-s'));

                $guessExtension = $request->file('photo')->guessExtension();

                $file = $request->photo->storeAs('public/sales/photo',$fileName.'.'.$guessExtension);
                $photo=substr($file, 7);
            }

            $sales  = Sales::where('id',Auth::id())->update([
                'photo_url' => $photo, 
            ]);
            $sales=Sales::where('id',Auth::id())->first();

            return response()->json(new ValueMessage(['value'=>1,'message'=>'Update Photo Success','data'=> new SalesResource($sales)]),$this->successStatus);
            
        }
    }
    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_area' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(new ValueMessage(['value'=>0,'message'=>'Field Empty!','data'=> $validator->errors()]), 400);         
        }else{
            $where = array('id' => Auth::id());
            $sales  = Sales::where($where)->update([
                'id_area' => $request->id_area,
                'name' => $request->name, 
                'email' => $request->email, 
                'phone' => $request->phone, 
                'address' => $request->address, 
                'gender' => $request->gender, 
            ]);


            $sales=Sales::where('id',Auth::id())->first();

            return response()->json(new ValueMessage(['value'=>1,'message'=>'Update Profile Success','data'=> new SalesResource($sales)]),$this->successStatus);
          
        }
    }
}
