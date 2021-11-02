<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\Sales;
use App\Models\SalesTarget;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\SalesToDo;

class ManageSales extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_area = null)
    {
        $arealist = Area::all();

        if($id_area != null){
            $area = Area::where('id',$id_area)->first();

            return view('admin.sales.index',compact('arealist','area'));
        }



        return view('admin.sales.index',compact('arealist'));
        
    }


    public function list($id_area = null)
    {
        $sales=Sales::where('active','active');
        if($id_area != null)
            $sales=$sales->where('id_area',$id_area);
        
        $sales=$sales->get();
        if($sales->isEmpty()){
            return;
        }else{
            $data="";
            foreach ($sales as $key => $value) {
                if($value->photo_url==null){
                    $sales[$key]->photo_url= URL::to('storage/sales/default.png');
                } else{
                    $sales[$key]->photo_url= URL::to('storage/'.$value->photo_url);
                }

                $data.= "<tr>
                            <td>".$value->id."</td>
                            <td><img class='img-row' src=".$value->photo_url."></span></td>
                            <td>".$value->name."</td>
                            <td>".$value->phone."</td>
                            <td>".$value->email."</td>
                            <td>".$value->area->name."</td>
                            <td><a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";

            }

            $filterarea=Area::select('name')->get();

            foreach ($filterarea as $key => $value) {
                $area[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='area' value='".$value->name."' checked><label>".$value->name."</label></div></div>";

            }

            

            $returndata['data']=$data;
            $returndata['area']=$area;

            return $returndata;
        }

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->password==$request->confirm_password){
            $photo=null;
            if($request->has('photo')){
                $fileName= str_replace(' ','-', $request->name.'_'.$request->id.'_'.date('d-m-Y_H-i-s'));

                $guessExtension = $request->file('photo')->guessExtension();

                $file = $request->photo->storeAs('public/sales/photo',$fileName.'.'.$guessExtension);
                $photo=substr($file, 7);
            }
            
            
            $sales   =   Sales::create([
                'id_area' => $request->id_area,
                'name' => $request->name, 
                'email' => $request->email, 
                'password' => Hash::make($request->password), 
                'password_unhash' => $request->password, 
                'phone' => $request->phone, 
                'address' => $request->address, 
                'gender' => $request->gender, 
                'photo_url' => $photo,
                'active' => 'active', 
                ]);    
            $salestarget = SalesTarget::create([
                'id_sales' => $sales->id,
                'sales_target' => 1000000,
                'billing_target' => 1000000
            ]);


            // AdminLogs::create([
            //    'id_admin' => Auth::id(),
            //    'id_admin_activity' => 8,
            //    'message' => 'Admin added a job category named '.$request->name
            // ]);
                             
            return Response()->json($sales);
        }
        
    }

    public function addCustomer(Request $request)
    {

        $companyphone=null;
        $companynpwp=null;
        $administratorbirthdate=null;
        $administratornpwp=null;
        $administratoraddress=null;

        if($request->has('company_phone')){
            $companyphone=$request->companyphone;
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
                'invited_by' => $request->id_sales,
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_phone' => $companyphone,
                'company_npwp' => $companynpwp,
                'level' => 'D',
                'administrator_name' => $request->administrator_name,
                'administrator_id' => $request->administrator_id,
                'administrator_birthdate' => $administratorbirthdate,
                'administrator_npwp' => $administratornpwp,
                'administrator_phone' => $request->administrator_phone,
                'administrator_address' => $administratoraddress,
                'tempo' => '0',
                'loan_limit' => '0',
            ]);
        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 8,
        //    'message' => 'Admin added a job category named '.$request->name
        // ]);
                         
        return Response()->json($sales);
    
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $sales  = Sales::where('id',$request->id)->with('area','transaction','customer','todo')->first();


        if($sales->photo_url==null){
            $sales->photo_url="sales/default.png";
        }
        
        $sales['photo_url']= URL::to('storage/'.$sales->photo_url);

        
        if($sales->customer->isEmpty()){
            $sales['customercount']=0;
        }else{
            $sales['customercount']=$sales->customer->count();
        }

        if($sales->transaction->isEmpty()){
            $sales['transactioncount']=0;
        }else{
            $sales['transactioncount']=$sales->transaction->count();
        }

        $sales['joined']=date("d F Y", strtotime($sales->created_at));

        $customer=Customer::where('invited_by',$request->id)->with('transaction','area')->get();
        if($customer->isEmpty()){
            $sales['customerlist']="EMPTY";
        }else{
            $sales['customerlist']="";
            foreach ($customer as $key => $value) {
                $sales['customerlist'].= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->company_name."</td>
                            <td>".$value->administrator_name."</td>
                            <td>".$value->area->name."</td>
                            <td>".$value->level."</td>
                            <td>".$value->tempo."</td>
                            <td>".$value->loan_limit."</td>
                        </tr>";
            }
        }

        $transaction=Transaction::where('id_sales',$request->id)->with('customer','transactiondetails','sales')->get();
        if($transaction->isEmpty()){
            $sales['transactionlist']="EMPTY";
        }else{
            $sales['transactionlist']="";
            foreach ($transaction as $key => $value) {
                $sales['transactionlist'].= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->invoice_number."</td>
                            <td>".$value->customer->company_name."</td>
                            <td>".$value->date."</td>";
                            // <td>".$value->total_payment."</td>
                            // <td>".$value->paid."</td>

                $sales['transactionlist'].="<td>";
                foreach ($value->transactiondetails as $key => $prod){
                    $product=Product::where('id', $prod->id_product)->with('type','size','colour','logo')->first();
                    $sales['transactionlist'].="<div class='row'>
                                    <div class='col-sm-12'>
                                    ".$product->type->name." ".$product->size->width."X".$product->size->height." ".$product->colour->name."
                                    </div>
                                </div>";
                }
                $sales['transactionlist'].="</td><td>";
                foreach ($value->transactiondetails as $key => $prod){
                    $sales['transactionlist'].="<div class='row'>
                                    <div class='col-sm-12'>
                                    ".$prod->quantity."
                                    </div>
                                </div>";
                }
                $sales['transactionlist'].="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    $sales['transactionlist'].="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->price."
                                </div>
                            </div>";
                }
                $sales['transactionlist'].="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    $sales['transactionlist'].="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->total."
                                </div>
                            </div>";
                }
                $sales['transactionlist'].="</td>";

                $sales['transactionlist'].= "<td>".$value->total_payment."</td></tr>";
            }
        }
        for ($i=0; $i < 12; $i++) { 
            $transaction=Transaction::where('id_sales',$request->id)->whereYear('date','=',(date('Y',strtotime(date('Y-m').' -'.$i.' month'))))->whereMonth('date','=',(date('m',strtotime(date('Y-m').' - '.$i.' month'))))->get();
            $data[$i]["year"]=(date('Y',strtotime(date('Y-m').' -'.$i.' month')));
            $data[$i]["month"]=(date('m',strtotime(date('Y-m').' -'.$i.' month')));

            $data[$i]["selling"]=0;
            if($transaction->isEmpty()){
                $data[$i]["transaction"]=0;
            }else{
                $data[$i]["transaction"]=$transaction->count();
                foreach ($transaction as $key => $value) {
                    $data[$i]["selling"]+=$value->total_payment;
                }
            }
            


        }
        $sales->chart=$data;
        

        $todo=SalesToDo::where('id_sales',$request->id)->get();
        if($todo->isEmpty()){
            $sales['todolist']="EMPTY";
        }else{
            $sales['todolist']="";
            foreach ($todo as $key => $value) {
                if($value->done==1){
                    $sales['todolist'].= "<li class='clearfix'>
                                            <span class='drag-marker'>
                                            <i></i>
                                            </span>
                                            <div class='todo-check pull-left'>
                                                <input type='hidden' value='".$value->id."' id='id_todo'  />
                                                <input type='checkbox' id='todo-check' checked disabled/>
                                                <label for='todo-check'></label>
                                            </div>
                                            <p class='todo-title line-through'>".$value->message."</p><p class=''>Date Task Done: ".$value->done_date."</p>
                                            <div class='todo-actionlist pull-right clearfix'>
                                                
                                                <a href='#'  class='remove-todo'><i class='fas fa-trash'></i></a>
                                            </div>
                                        </li>";
                }else{
                    $sales['todolist'].= "<li class='clearfix'>
                                            <span class='drag-marker'>
                                            <i></i>
                                            </span>
                                            <div class='todo-check pull-left'>
                                                <input type='hidden' value='".$value->id."' id='id_todo'  />
                                                <input type='checkbox' id='todo-check'  disabled/>
                                                <label for='todo-check'></label>
                                            </div>
                                            <p class='todo-title '>".$value->message."</p>
                                            <div class='todo-actionlist pull-right clearfix'>
                                                <a href='#' class='remove-todo'><i class='fas fa-trash'></i></a>
                                            </div>
                                        </li>";
                }
                
            }
        }

        // foreach ($company['address'] as $key => $value) {
        //     $company['address'][$key]['city']=City::where('id',$value->id_city)->select('name')->first()->name;
        // }
        // foreach ($company['photo'] as $key => $value) {
        //     $company['photo'][$key]['photo_url']= URL::to('storage/'.$value->photo_url);
        // }
      
        return Response()->json($sales);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $sales  = Sales::where($where)->update([
            'id_area' => $request->id_area,
            'name' => $request->name, 
            'email' => $request->email, 
            'phone' => $request->phone, 
            'address' => $request->address, 
            'gender' => $request->gender, 
        ]);
      
        return Response()->json($sales);
    }

    public function editPhoto(Request $request)
    {
        $where = array('id' => $request->id);
        $sales=Sales::where($where)->first();

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

        $sales  = Sales::where($where)->update([
            
            'photo_url' => $photo, 
        ]);
      
        return Response()->json($sales);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    public function changePassword(Request $request)
    {
        $sales=Sales::where('id',$request->id_sales)->update(['password'=>Hash::make($request->password_change),'password_unhash'=>$request->password_change]);
        $sales=Sales::where('id',$request->id_sales)->first();
        return Response()->json($sales);
    }

    public function suspend(Request $request)
    {
        $sales=Sales::where('id',$request->id)->update(['active'=>'suspended']);

        return Response()->json($sales);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(Request $request)
    {
        $sub = PostSubCategory::where('id_category',$request->id)->delete();
        $post = PostCategory::where('id',$request->id)->delete();
      
        return Response()->json($post);
    }
}
