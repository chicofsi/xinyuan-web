<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Sales;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use App\Models\TransactionDetails;
use App\Models\TransactionPayment;
use App\Models\PaymentAccount;
use App\Models\Company;

use App\Exports\PaymentHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class ManagePaymentHistory extends Controller
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


        $product = Product::all();
        $sales = Sales::all();
        $customer = Customer::all();
        $company = Company::all();
        $accounts = PaymentAccount::with('bank')->get();

        return view('admin.payment.history',compact('product','sales','customer','accounts','company'));
        
    }

    public function export(Request $request)
    {
        $from = date("Y-m-d",strtotime($request->input('from')));
        $to = date("Y-m-d",strtotime($request->input('to')));

        $history = new PaymentHistoryExport($request->input('id_payment_account'),$request->input('id_company'),$from,$to);
        if($request->input('id_company')!=0){
            $company = Company::where('id',$request->input('id_company'))->first()->name;
        }else{
            $company = "All-Company";
        }
        
        return Excel::download($history, 'payment_'.$from."_".$to."_".$company.'.xlsx');
    }

    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $account=$request->account;
        $company=$request->company;

        

        $payment=TransactionPayment::with('transaction','paymentaccount')->whereBetween('date', [$from, $to]);
        if($account!=0){
            $payment=$payment->where('id_payment_account',$account);
        }
        $payment=$payment->orderBy('date','asc')->get();
        if($payment->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='6'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            $total=0;
            foreach ($payment as $key => $value) {
                if(!Auth::guard('web')->check()){
                    if($value->transaction->id_sales != Auth::id()){
                        continue;
                    }
                }

                if($company!=0){
                    if($value->transaction->id_company!=$company){
                        continue;
                    }
                }
                $total+=$value->paid;
                $customer=Customer::where('id',$value->transaction->id_customer)->with('customerlevel')->first();
                $account=PaymentAccount::with('bank')->where('id',$value->paymentaccount->id)->first();
                $sales=Sales::where('id',$value->transaction->id_sales)->first();
                $data.= "<tr>
                            <td>".$value->transaction->invoice_number."</td>
                            <td>".$value->date."</td>
                            <td>".$sales->name."</td>
                            <td>".$customer->company_name."</td>
                            <td>".$customer->customerlevel->level."</td>
                            <td>".$account->bank->name." - ".$account->account_name." - ".$account->account_number."</td>
                            <td>".number_format(intval($value->paid), 0, ',', ',')."</td>
                        </tr>";
            }

            // $filterarea=Area::select('name')->get();

            // foreach ($filterarea as $key => $value) {
            //     $area[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='area' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            // }

            // $filterlevel=['A','B','C','D'];

            // foreach ($filterlevel as $key => $value) {
            //     $level[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='level' value='".$value."' checked><label>".$value."</label></div></div>";
            // }

            // $filtertempo=['0','30','45','60','75','90'];

            // foreach ($filtertempo as $key => $value) {
            //     $tempo[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='tempo' value='".$value."' checked><label>".$value."</label></div></div>";
            // }

            $returndata['data']=$data;
            $returndata['total']=number_format(intval($total), 0, ',', ',');
            // $returndata['area']=$area;
            // $returndata['level']=$level;
            // $returndata['tempo']=$tempo;

            return $returndata;
        }

    }

    public function pay(Request $request)
    {
        $transactionpayment = TransactionPayment::create([
            'id_transaction' => $request->id,
            'date' => Date('Y-m-d'),
            'paid' => $request->PayBalance
        ]);
        $paid=Transaction::where('id',$request->id)->first()->paid;
        $newpaid=intval($paid)+intval($request->PayBalance);
        Transaction::where('id',$request->id)->update(['paid'=>$newpaid]);
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
        
    }

    public function storeProduct(Request $request)
    {
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $transaction  = Transaction::where('id',$request->id)->with('customer','transactiondetails','transactionpayment','sales')->first();
        
        $datedeadline=strtotime($transaction->payment_deadline);
        $date=strtotime($transaction->date);

        $transaction->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));

        $history=TransactionPayment::where('id_transaction',$request->id)->get();
        if($history->isEmpty()){
            $transaction['paymenthistory']="EMPTY";
        }else{
            $transaction['paymenthistory']="";
            foreach ($history as $key => $value) {
                $transaction['paymenthistory'].= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->date."</td>
                            <td>".$value->paid."</td>
                        </tr>";
            }
        }

        return Response()->json($transaction);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(Request $request)
    {

    }
}
