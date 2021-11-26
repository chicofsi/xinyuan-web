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
use App\Models\Bank;
use App\Models\Company;
use App\Models\TransactionDetails;
use App\Models\TransactionPayment;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;
use App\Helper\JurnalHelper;

class ManagePayment extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->client = JurnalHelper::index();
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

        return view('admin.payment.index',compact('product','sales','customer','accounts','company'));
        
    }

    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $nice=$request->nice;
        $company=$request->company;

        if(Auth::guard('web')->check()){
            $transaction=Transaction::with('customer','transactiondetails','transactionpayment','sales','transactionrefund')->whereBetween('date', [$from, $to]);
        }else{
            $transaction=Transaction::with('customer','transactiondetails','transactionpayment','sales','transactionrefund')->whereBetween('date', [$from, $to])->where('id_sales',$request->user()->id);
        }
        if($company!=0){
            $transaction=$transaction->where('id_company',$company);
        }
        $transaction=$transaction->get();
        
        if($transaction->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='9'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($transaction as $key => $value) {
                
                $customer=Customer::where('id',$value->customer->id)->with('customerlevel')->first();
                if($nice!=2){
                    if($customer->customerlevel->nice!=$nice){
                        continue;
                    }
                }
                if((intval($value->total_payment)-intval($value->paid)) > 0){
                    $status= "<a href='javascript:void(0)' onClick=pay(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Pay</a>";
                }else{
                    $status= "<a href='javascript:void(0)' onClick=pay(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Pay</a>";
                }
                $current = strtotime(date("Y-m-d"));
                $date    = strtotime($value->payment_deadline);

                $datediff = $date - $current;
                $difference = floor($datediff/(60*60*24));
                if($difference==0){
                    $stat="<span class='label label-warning'>Due Date Today</span>";
                }else if($difference<0){
                    $stat="<span class='label label-danger'>".-$difference." Days Late</span>";
                }else {
                    $stat="<span class='label label-info'>".$difference." Day to due date</span>";
                }
                $debt=intval($value->total_payment)-intval($value->paid);
                if($debt==0){
                    $stat="<span class='label label-success'>Payment Done</span>";
                }
                

                $customer=Customer::where('id',$value->customer->id)->with('customerlevel')->first();
                $data.= "<tr>
                            <td>".$value->invoice_number."</td>
                            <td>".$customer->company_name."</td>
                            <td>".$customer->customerlevel->level."</td>
                            <td>".$value->sales->name."</td>
                            <td>".$value->date."</td>
                            <td>".number_format(intval($value->total_payment), 0, ',', ',')."</td>
                            <td>".number_format(intval($value->paid), 0, ',', ',')."</td>
                            <td>".number_format($debt, 0, ',', ',')."</td>
                            <td>".$value->payment_deadline."</td>
                            <td>".$stat."</td>
                            <td>".$status."</td>
                        </tr>";
            }

            $filtercustomer=Customer::select('company_name')->get();

            foreach ($filtercustomer as $key => $value) {
                $customer[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='customer' value='".$value->company_name."' checked><label>".$value->company_name."</label></div></div>";
            }

            $filterlevel=CustomerLevel::select('level')->get();

            foreach ($filterlevel as $key => $value) {
                $level[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='level' value='".$value->level."' checked><label>".$value->level."</label></div></div>";
            }


            $filtersales=Sales::select('name')->get();

            foreach ($filtersales as $key => $value) {
                $sales[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='sales' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            }

            $returndata['data']=$data;
            $returndata['customer']=$customer;
            $returndata['level']=$level;
            $returndata['sales']=$sales;

            return $returndata;
        }

    }

    public function pay(Request $request)
    {
        $request->date=str_replace('-','/',$request->date);
        $transactionpayment = TransactionPayment::create([
            'id_payment_account' => $request->id_payment_account,
            'id_transaction' => $request->id,
            'date' => date("Y-m-d",strtotime($request->date)),
            'paid' => $request->PayBalance
        ]);
        $paid=Transaction::where('id',$request->id)->first()->paid;
        $newpaid=intval($paid)+intval($request->PayBalance);
        Transaction::where('id',$request->id)->update(['paid'=>$newpaid]);

        $transaction=Transaction::where('id',$request->id)->first();

        $invoice = json_decode($this->client->request(
            'GET',
            'sales_invoices/'.$transaction->jurnal_id
        )->getBody()->getContents());

        $transaction_line=[];
        $transaction_line[0]["transaction_no"]= $invoice->sales_invoice->transaction_no;
        $transaction_line[0]["amount"]=$request->PayBalance;

        $paymentaccount=PaymentAccount::where('id',$request->id_payment_account)->first();

        $account = json_decode($this->client->request(
            'GET',
            'accounts/'.$paymentaccount->jurnal_id
        )->getBody()->getContents());
        
        $request->date = date("d/m/Y", strtotime($request->date));  


        $response = json_decode($this->client->request(
            'POST',
            'receive_payments',
            [
                'json' => 
                [
                    "receive_payment" => [
                        "transaction_date" => $request->date,
                        "records_attributes"=> $transaction_line,
                        "payment_method_name"=> "Cash",
                        "is_draft"=> false,
                        "deposit_to_name"=> $account->account->name
                    ]
                ]
            ]
        )->getBody()->getContents());

        $transactionpayment=TransactionPayment::where('id',$transactionpayment->id)->update(['jurnal_id'=>$response->receive_payment->id]);
        return $transactionpayment;
    }
    public function StorePaymentToJurnal(Request $request)
    {
        
        $paymentall = TransactionPayment::where('jurnal_id',null)->get()->take(100);

        foreach ($paymentall as $key => $value) {
            $transaction=Transaction::where('id',$value->id_transaction)->first();

            $invoice = json_decode($this->client->request(
                'GET',
                'sales_invoices/'.$transaction->jurnal_id
            )->getBody()->getContents());

            $transaction_line=[];
            $transaction_line[0]["transaction_no"]= $invoice->sales_invoice->transaction_no;
            $transaction_line[0]["amount"]=$value->paid;

            $paymentaccount=PaymentAccount::where('id',$value->id_payment_account)->first();

            $account = json_decode($this->client->request(
                'GET',
                'accounts/'.$paymentaccount->jurnal_id
            )->getBody()->getContents());
            
            $date= date("d/m/Y", strtotime($value->date));  


            $response = json_decode($this->client->request(
                'POST',
                'receive_payments',
                [
                    'json' => 
                    [
                        "receive_payment" => [
                            "transaction_date" => $date,
                            "records_attributes"=> $transaction_line,
                            "payment_method_name"=> "Cash",
                            "is_draft"=> false,
                            "deposit_to_name"=> $account->account->name
                        ]
                    ]
                ]
            )->getBody()->getContents());

            TransactionPayment::where('id',$value->id)->update(['jurnal_id'=>$response->receive_payment->id]);
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
        $transaction  = Transaction::where('id',$request->id)->with('customer','transactiondetails','transactionpayment','sales','transactionrefund')->first();
        
        $datedeadline=strtotime($transaction->payment_deadline);
        $date=strtotime($transaction->date);

        $transaction->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));



        $debt=(intval($transaction->total_payment)-intval($transaction->paid));
        
        
        $transaction->debt =  $debt;

        $history=TransactionPayment::with('paymentaccount')->where('id_transaction',$request->id)->orderBy('date','asc')->get();
        if($history->isEmpty()){
            $transaction['paymenthistory']="EMPTY";
        }else{
            $transaction['paymenthistory']="";
            foreach ($history as $key => $value) {
                $status="";
                if($value->method=='cash'){
                    $status="<a href='javascript:void(0)' onClick=editPayment(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-info btn-sm'>Edit</a>";
                }
                $bank=Bank::where('id',$value->paymentaccount->id_bank)->first();
                $transaction['paymenthistory'].= "<tr>
                            <td>".$value->date."</td>
                            <td>".$bank->name." - ".$value->paymentaccount->account_name."</td>
                            <td>".$value->paid."</td>
                            <td>".$value->method."</td>
                            <td>".$status."</td>
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
        $where = array('id' => $request->id);
        $payment  = TransactionPayment::where($where)->with('transaction')->first();
      
        return Response()->json($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $paymentId = $request->id;
        $payment=TransactionPayment::where('id',$paymentId)->with('transaction')->first();
        
        $diff=intval($payment->paid)-intval($request->PayBalance);

        $transaction=Transaction::where('id',$payment->transaction->id)->first();
        $paid=$transaction->paid;

        $payment   =   TransactionPayment::updateOrCreate(
            [
                'id' => $paymentId
            ],
            [
                'id_payment_account' => $request->id_payment_account,
                'date' => date("Y-m-d",strtotime($request->date)),
                'paid' => $request->PayBalance
            ]);    

        $newpaid=intval($paid)-intval($diff);
        Transaction::where('id',$transaction->id)->update(['paid'=>$newpaid]);
        return Response()->json($payment);
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
