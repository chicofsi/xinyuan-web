<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Sales;
use App\Models\SalesTarget;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Transaction;

class ManageTarget extends Controller
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
    public function index()
    {
        $arealist = Area::all();

        return view('admin.sales.target',compact('arealist'));
        
    }


    public function list($id_area = null)
    {
        $sales=Sales::where('active','active')->with('target');
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

                $transaction=Transaction::where('id_sales',$value->id)->whereMonth('date','=',(date('m',strtotime(date('Y-m')))))->with('transactionpayment')->get();

                $sell=0;
                $bill=0;
                if(!$transaction->isEmpty()){
                    foreach ($transaction as $key => $val) {
                        $sell+=$val->total_payment;
                        foreach ($val->transactionpayment as $key => $v) {
                            $bill+=$v->paid;
                        }
                    }
                }
                $widthsales=(($sell/$value->target->sales_target)*100);
                if($widthsales>100){
                    $widthsales=100;
                }
                $widthbill=(($bill/$value->target->billing_target)*100);
                if($widthbill>100){
                    $widthbill=100;
                }

                $statsales="progress-bar-danger";
                if($widthsales==0){
                    $statsales="progress-bar-danger";
                }else if($widthsales<=50){
                    $statsales="progress-bar-warning";
                }else if($widthsales<100){
                    $statsales="progress-bar-info";
                }else if($widthsales>=100){
                    $statsales="progress-bar-success";
                }
                $statbill="progress-bar-danger";
                if($widthbill==0){
                    $statbill="progress-bar-danger";
                }else if($widthbill<=50){
                    $statbill="progress-bar-warning";
                }else if($widthbill<100){
                    $statbill="progress-bar-info";
                }else if($widthbill>=100){
                    $statbill="progress-bar-success";
                }

                $data.= "<tr>
                            <td>".$value->id."</td>
                            <td><img class='img-row' src=".$value->photo_url."></span></td>
                            <td>".$value->name."</td>
                            <td>".$value->target->sales_target."</td>
                            <td>".$value->target->billing_target."</td>
                            <td>
                                <div class=details>
                                    <div class='progress  progress-striped'>
                                        <div class='progress-bar ".$statsales."' role='progressbar' aria-valuenow='".$sell."' aria-valuemin='0' aria-valuemax=".$value->target->sales_target." style='width: ".$widthsales."%'>
                                            <span>".$sell."</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class=details>
                                    <div class='progress progress-striped'>
                                        <div class='progress-bar ".$statbill."' role='progressbar' aria-valuenow='".$bill."' aria-valuemin='0' aria-valuemax=".$value->target->billing_target." style='width: ".$widthbill."%'>
                                            <span>".$bill."</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
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
        $salesId = $request->id_sales;
 
        $target   =   SalesTarget::where('id_sales',$salesId)->update(
                    [
                    'sales_target' => $request->SalesTarget, 
                    'billing_target' => $request->BillingTarget, 
                    ]);    
                         
        return Response()->json($target);
        
    }

    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $sales  = Sales::where('id',$request->id)->with('area','transaction','customer','target')->first();


        if($sales->photo_url==null){
            $sales->photo_url="sales/default.png";
        }
        
        $sales['photo_url']= URL::to('storage/'.$sales->photo_url);


        $transaction=Transaction::where('id_sales',$request->id)->whereMonth('date','=',(date('m',strtotime(date('Y-m')))))->with('transactionpayment')->get();

        $sell=0;
        $bill=0;
        if(!$transaction->isEmpty()){
            foreach ($transaction as $key => $val) {
                $sell+=$val->total_payment;
                foreach ($val->transactionpayment as $key => $v) {
                    $bill+=$v->paid;
                }
            }
        }
        $widthsales=(($sell/$sales->target->sales_target)*100);
        if($widthsales>100){
            $widthsales=100;
        }
        $widthbill=(($bill/$sales->target->billing_target)*100);
        if($widthbill>100){
            $widthbill=100;
        }


        $sales['sell']=$sell;
        $sales['bill']=$bill;
        $sales['widthsales']=$widthsales;
        $sales['widthbill']=$widthbill;
        
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
                            <td>".$value->sales->name."</td>
                            <td>".$value->date."</td>
                            <td>".$value->total_payment."</td>
                            <td>".$value->paid."</td>
                            <td>".$value->transactiondetails->count()."</td>
                        </tr>";
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
        $where = array('id_sales' => $request->id);
        $post  = SalesTarget::where($where)->first();

        return Response()->json($post);
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
        //
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
