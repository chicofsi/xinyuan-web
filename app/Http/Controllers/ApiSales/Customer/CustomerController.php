<?php

namespace App\Http\Controllers\ApiSales\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ValueMessage;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\Area as AreaResource;

use App\Models\Customer;
use App\Models\CustomerLevel;
use App\Models\CustomerPhoto;
use App\Models\Area;

class CustomerController extends Controller
{
    public function getArea(Request $request)
    {
        $area=Area::get();

        if($area->isEmpty()){
            return response()->json(new ValueMessage(['value'=>0,'message'=>'Area Doesn\'t Exist!','data'=> '']), 404);
        }

        foreach ($area as $key => $value) {
            $dataArea[$key]=new AreaResource($value);
        }

        return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Area List Success!','data'=> $dataArea]), 200);

    }

    public function getLevel(Request $request)
    {
        $customerlevel=CustomerLevel::get();

        return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Level List Success!','data'=> $customerlevel]), 200);
    }

    public function registerCustomer(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_area' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'administrator_name' => 'required',
            'administrator_id' => 'required',
            'administrator_phone' => 'required',
            'id_level' => 'required',
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            $companyphone=null;
            $companynpwp=null;
            $administratorbirthdate=null;
            $administratornpwp=null;
            $administratoraddress=null;

            if($request->has('company_phone')){
                $companyphone=$request->company_phone;
            }

            if($request->has('company_npwp')){
                $companynpwp=$request->company_npwp;
            }

            if($request->has('administrator_address')){
                $administratoraddress=$request->administrator_address;
            }

            if($request->has('administrator_birthdate')){
                $administratorbirthdate=$request->administrator_birthdate;
            }

            if($request->has('administrator_npwp')){
                $administratornpwp=$request->administrator_npwp;
            }
            
            
            $customer = Customer::create([
                'id_area' => $request->id_area,
                'invited_by' => $request->user()->id,
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_phone' => $companyphone,
                'company_npwp' => $companynpwp,
                'administrator_name' => $request->administrator_name,
                'administrator_id' => $request->administrator_id,
                'administrator_birthdate' => $administratorbirthdate,
                'administrator_npwp' => $administratornpwp,
                'administrator_phone' => $request->administrator_phone,
                'administrator_address' => $administratoraddress,
                'id_level' => $request->id_level
            ]);

            

            $data=Customer::where('id',$customer->id)->with('customerlevel','customerphoto')->first();

            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Customer Register Success!','data'=>  new CustomerResource($data)]), 200);;
            
        }

    }

    public function getCustomer(Request $request)
    {
        $customer=Customer::where('invited_by',$request->user()->id)->with('customerlevel','customerphoto')->get();
        if($customer->isEmpty()){
            return response()->json(new ValueMessage(['value'=>0,'message'=>'Not Registered A Customer Yet!','data'=> '']), 404);
        }
        else{
            foreach ($customer as $key => $value) {
                $data[$key]=new CustomerResource($value);
            }
        }
        return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Customer Success!','data'=> $data]), 200);
        
        

    }

    public function uploadCustomerPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_customer' => 'required',
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            if($request->has('ktp')){
                $fileName= str_replace(' ','-', $request->id_customer.'_KTP_'.date('d-m-Y_H-i-s'));

                $guessExtension = $request->file('ktp')->guessExtension();

                //store file into document folder
                $file = $request->ktp->storeAs('public/customer/'.$request->id_customer,$fileName.'.'.$guessExtension);

                $customerphoto=CustomerPhoto::create([
                    'id_customer' => $request->id_customer,
                    'id_customer_photo_category' => 1,
                    'photo_url' => substr($file, 7)
                ]);

            }

            if($request->has('foto_toko')){
                $fileName= str_replace(' ','-', $request->id_customer.'_foto-toko_'.date('d-m-Y_H-i-s'));

                $guessExtension = $request->file('foto_toko')->guessExtension();

                //store file into document folder
                $file = $request->foto_toko->storeAs('public/customer/'.$request->id_customer,$fileName.'.'.$guessExtension);

                $customerphoto=CustomerPhoto::create([
                    'id_customer' => $request->id_customer,
                    'id_customer_photo_category' => 2,
                    'photo_url' => substr($file, 7)
                ]);

            }


            if($request->has('npwp_pengurus')){
                $fileName= str_replace(' ','-', $request->id_customer.'_npwp-pengurus_'.date('d-m-Y_H-i-s'));

                $guessExtension = $request->file('npwp_pengurus')->guessExtension();

                //store file into document folder
                $file = $request->foto_toko->storeAs('public/customer/'.$request->id_customer,$fileName.'.'.$guessExtension);

                $customerphoto=CustomerPhoto::create([
                    'id_customer' => $request->id_customer,
                    'id_customer_photo_category' => 3,
                    'photo_url' => substr($file, 7)
                ]);

            }

            if($request->has('npwp_perusahaan')){
                $fileName= str_replace(' ','-', $request->id_customer.'_npwp-perusahaan_'.date('d-m-Y_H-i-s'));

                $guessExtension = $request->file('npwp_perusahaan')->guessExtension();

                //store file into document folder
                $file = $request->npwp_perusahaan->storeAs('public/customer/'.$request->id_customer,$fileName.'.'.$guessExtension);

                $customerphoto=CustomerPhoto::create([
                    'id_customer' => $request->id_customer,
                    'id_customer_photo_category' => 4,
                    'photo_url' => substr($file, 7)
                ]);

            }
            return response()->json(new ValueMessage(['value'=>1,'message'=>'Upload Customer Photo Success!','data'=> '']), 200);
        }   
    }

    public function checkCustomerID(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'administrator_id' => 'required',
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            if(Customer::where('administrator_id',$request->administrator_id)->first()){
                return response()->json(new ValueMessage(['value'=>0,'message'=>'ID Taken!','data'=> '']), 400);

            }else{

                return response()->json(new ValueMessage(['value'=>1,'message'=>'ID Available!','data'=> '']), 200);
            }
        }
    }
    
}
