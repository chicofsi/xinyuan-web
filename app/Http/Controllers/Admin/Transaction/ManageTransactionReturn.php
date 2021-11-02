<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Sales;
use App\Models\Transaction;
use App\Models\TransactionRefund;
use App\Models\TransactionReturn;
use App\Models\TransactionPayment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\TransactionDetails;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;
use App\Models\Company;

class ManageTransactionReturn extends Controller
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
    public function index(Request $request)
    {
        $company = Company::get();

        return view('admin.transaction.return',compact('company'));
        
    }
    
    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $nice=$request->nice;
        $company=$request->company;

        $refund=TransactionRefund::with('transaction','transactionreturn')->whereBetween('date', [$from, $to])->get();


        if($refund->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='9'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($refund as $key => $value) {
                $customer=Customer::where('id',$value->transaction->id_customer)->with('customerlevel')->first();

                if(! Auth::guard('web')->check()){
                    if($customer->invited_by!=Auth::id()){
                        continue;
                    }
                }
                if($nice!=2){
                    if($customer->customerlevel->nice!=$nice){
                        continue;
                    }
                }

                if($company!=0){
                    if($value->transaction->id_company!=$company){

                        continue;
                    }
                }
                

                $return=TransactionReturn::where('id_transaction_refund',$value->id)->get();

                $data.= "<tr>
                            <td rowspan=".(intval($return->count())+1).">".$value->transaction->invoice_number."</td>
                            <td rowspan=".(intval($return->count())+1).">".$value->date."</td>
                            <td rowspan=".(intval($return->count())+1).">".$value->cashback."</td>";
                if($return->count()==0){
                    $data.="<td colspan='9'>No Product Return</td>";
                    $data.="<td class='cashback'>".$value->total_cashback."</td>";
                    $data.="<td >".$value->note."</td>";
                    $data.="</tr>";
                }

                foreach ($return as $key => $val) {
                    $transactiondetails=TransactionDetails::where('id',$val->id_transaction_details)->first();
                    $product=Product::where('id',$transactiondetails->id_product)->first();
                    

                    $data.="<tr>
                                <td>".$product->type->name."</td>
                                <td>".$product->size->width."X".$product->size->height."</td>
                                <td>".$product->weight->weight."</td>
                                <td>".$product->grossweight->gross_weight."</td>
                                <td>".$product->colour->name."</td>
                                <td>".$product->logo->name."</td>
                                <td>".$product->factories->name."</td>
                                <td>".$val->qty."</td>
                                <td>".$val->total_refund."</td>";
                    if($key==0){
                        $data.="<td rowspan=".$return->count()." class='cashback'>".$value->total_cashback."</td>";
                        $data.="<td rowspan=".$return->count().">".$value->note."</td>";
                    }
                    $data.="</tr>";
                }
            }

            $returndata['data']=$data;

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
    public function detail(Request $request)
    {
        $refund=TransactionRefund::where('id',$request->id)->with('transactionreturn','transaction')->first();
        $refund->date=Date('m/d/Y', strtotime($refund->date));
        return $refund;
    }

    public function show(Request $request)
    {
        $refund=TransactionRefund::where('id',$request->id)->first();
        $return=TransactionReturn::where('id_transaction_refund',$request->id)->get();

        if($refund){
            $data= "<tr>
                        <td rowspan=".(intval($return->count())+1).">".$refund->date."</td>
                        <td rowspan=".(intval($return->count())+1).">".$refund->cashback."</td>";
            if($return->count()==0){
                $data.="<td colspan='9'>No Product Return</td>";
                $data.="<td class='cashback'>".$refund->total_cashback."</td>";
                $data.="<td >".$refund->note."</td>
                        <td><a href='javascript:void(0)' onClick=editRefund(".$refund->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-warning btn-sm'>Edit</a></td>";
            }
            $data.="</tr>";

            foreach ($return as $key => $value) {
                $transactiondetails=TransactionDetails::where('id',$value->id_transaction_details)->first();
                $product=Product::where('id',$transactiondetails->id_product)->first();

                $data.="<tr>
                            <td>".$product->type->name."</td>
                            <td>".$product->size->width."X".$product->size->height."</td>
                            <td>".$product->weight->weight."</td>
                            <td>".$product->grossweight->gross_weight."</td>
                            <td>".$product->colour->name."</td>
                            <td>".$product->logo->name."</td>
                            <td>".$product->factories->name."</td>
                            <td>".$value->qty."</td>
                            <td>".$value->total_refund."</td>";
                if($key==0){
                    $data.="<td rowspan=".$return->count()." class='cashback'>".$refund->total_cashback."</td>";
                    $data.="<td rowspan=".$return->count().">".$refund->note."</td>
                            <td  rowspan=".$return->count()."><a href='javascript:void(0)' onClick=editRefund(".$refund->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-warning btn-sm'>Edit</a></td>";
                }
                $data.="</tr>";
            }
            $returndata['data']=$data;

            return $returndata;
        }
    }

    public function returnStore(Request $request)
    {
        $transactionreturn = TransactionReturn::create([
            'id_transaction_refund' => $request->id_transaction_refund,
            'id_transaction_details' => $request->id_transaction_details,
            'qty' => $request->qty,
            'total_refund' => $request->total_refund
        ]); 
        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 8,
        //    'message' => 'Admin added a job category named '.$request->name
        // ]);
                         
        return Response()->json($transactionreturn);
    }

    public function edit(Request $request)
    {
        if($request->note==null){
            $request->note="";
        }
        $transactionrefund=TransactionRefund::where('id',$request->id)->first();

        $paid=TransactionPayment::where('id',$transactionrefund->id_transaction_payment)->first()->paid;

        $diff=$paid-$request->total_cashback;

        $paid=Transaction::where('id',$request->id_transaction)->first()->paid;
        $newpaid=intval($paid)-intval($diff);
        Transaction::where('id',$request->id_transaction)->update(['paid'=>$newpaid]);

        $transactionpayment=TransactionPayment::where('id',$transactionrefund->id_transaction_payment)->update([
            'id_payment_account' => $request->id_payment_account,
            'date' => date("Y-m-d",strtotime($request->date)),
            'paid' =>  $request->total_cashback
        ]);
        $transactionrefund = TransactionRefund::where('id',$request->id)->update([
            'cashback' => $request->cashback,
            'total_cashback' => $request->total_cashback,
            'note' => $request->note,
            'date' => date("Y-m-d",strtotime($request->date))
        ]); 

        TransactionReturn::where('id_transaction_refund',$request->id)->delete();
        $transactionrefund=TransactionRefund::where('id',$request->id)->first();
        
        return Response()->json($transactionrefund);
    }

    public function refundStore(Request $request)
    {
        if($request->note==null){
            $request->note="";
        }
        $transactionpayment= TransactionPayment::create([
            'id_transaction' => $request->id_transaction,
            'id_payment_account' => $request->id_payment_account,
            'date' => date("Y-m-d",strtotime($request->date)),
            'paid' => $request->total_cashback,
            'method' => 'refund'
        ]);
        $transactionrefund = TransactionRefund::create([
            'id_transaction_payment' => $transactionpayment->id,
            'id_transaction' => $request->id_transaction,
            'cashback' => $request->cashback,
            'total_cashback' => $request->total_cashback,
            'note' => $request->note,
            'date' => date("Y-m-d",strtotime($request->date))
        ]); 

        $paid=Transaction::where('id',$request->id_transaction)->first()->paid;
        $newpaid=intval($paid)+intval($request->total_cashback);
        Transaction::where('id',$request->id_transaction)->update(['paid'=>$newpaid]);
  
        return Response()->json($transactionrefund);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(Request $request)
    {
        $transactionreturn=TransactionReturn::where('id_transaction_refund',$request->id)->delete();
        $transactionrefund=TransactionRefund::where('id',$request->id)->delete();
        return $transactionrefund;
    }
}
