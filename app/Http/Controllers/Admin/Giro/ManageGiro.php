<?php

namespace App\Http\Controllers\Admin\Giro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Sales;
use App\Models\Transaction;
use App\Models\Giro;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Company;
use App\Models\Bank;
use App\Models\TransactionDetails;
use App\Models\TransactionPayment;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;
use App\Helper\JurnalHelper;

use App\Exports\GiroExport;
use Maatwebsite\Excel\Facades\Excel;

class ManageGiro extends Controller
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
        $customer = Customer::all();
        $company = Company::all();
        $banks = Bank::all();
        $transaction = Transaction::all();
        $accounts = PaymentAccount::with('bank')->get();

        return view('admin.giro.index',compact('customer','accounts','transaction','banks','company'));
        
    }

    public function export(Request $request)
    {
        $from = date("Y-m-d",strtotime($request->input('from')));
        $to = date("Y-m-d",strtotime($request->input('to')));

        $giro = new GiroExport($request->input('id_company'),$from,$to);
        if($request->input('id_company')!=0){
            $company = Company::where('id',$request->input('id_company'))->first()->name;
        }else{
            $company = "All-Company";
        }
        
        return Excel::download($giro, 'giro_'.$from."_".$to."_".$company.'.xlsx');
    }
    
    public function getTransaction()
    {
        if(Auth::guard('web')->check()){
            $transaction=Transaction::with('customer','transactiondetails','sales')->where('total_payment','>','paid')->get();
        }else{
            $transaction=Transaction::with('customer','transactiondetails','sales')->where('total_payment','>','paid')->where('id_sales',Auth::id())->get();
        }
        if($transaction->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='9'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($transaction as $key => $value) {

                if($value->total_payment == $value->paid){
                    continue;
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
                            <td>".$value->transactiondetails->count()."</td>
                            <td><a href='javascript:void(0)' onClick=addGiro(".$value->id.") data-toggle='tooltip' data-original-title='addGiro' class='btn btn-default btn-sm'>Add giro</a></td>
                        </tr>";
            }
            if($data==""){
                $data="<tr>
                            <td colspan='9'>Not Available</td>
                        </tr>";
            }

            $returndata['data']=$data;

            return $returndata;
        }
    }

    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $nice=$request->nice;
        $company=$request->company;
        $giro=Giro::with('customer','transaction','paymentaccount','bank')->whereBetween('date_received', [$from, $to])->get();

        if($giro->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='9'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($giro as $key => $value) {
                
                if(! Auth::guard('web')->check()){
                    if($value->customer->invited_by!=Auth::id()){
                        continue;
                    }
                }
                $customer=Customer::where('id',$value->customer->id)->with('customerlevel')->first();
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

                
                if($value->status=="pending"){
                    $stat="<span class='label label-warning'>Haven't cashed yet</span>";
                    $status= "<a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-info btn-sm'>Cash</a>";
                }else if($value->status=="cashed"){
                    $stat="<span class='label label-info'>Cashed on ".$value->date_cashed." To ".$value->paymentaccount->account_name."</span>";
                    $status= "<a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a>";
                }else if($value->status=="rejected"){
                    $stat="<span class='label label-danger'>Rejected</span>";
                    $status= "<a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a>";
                }
                
               

                $data.= "<tr>
                            <td>".$value->date_received."</td>
                            <td>".$value->bank->name."</td>
                            <td>".$value->giro_number."</td>
                            <td>".$value->balance."</td>
                            <td>".$value->customer->company_name."</td>
                            <td>".$value->transaction->invoice_number."</td>
                            <td>".$stat."</td>
                            <td>".$status."</td>
                        </tr>";
            }

            $returndata['data']=$data;

            return $returndata;
        }

    }

    public function pay(Request $request)
    {
        $transaction=Transaction::where('id',$request->id)->first();

        $giro = Giro::create([
            'id_bank' => $request->id_bank,
            'id_transaction' => $request->id,
            'id_customer' => $transaction->id_customer,
            'giro_number' => $request->giro_number,
            'balance' => $request->giro_balance,
            'date_received' => date("Y-m-d",strtotime($request->date)),
            'id_payment_account' => null,
            'cashed' => 0,
            'date_cashed' => null,
            'status' => "pending"
        ]);

        return $giro;
    }

    public function detail(Request $request)
    {
        $giro=Giro::where('id',$request->id)->with('bank','customer','transaction','paymentaccount')->first();

        return $giro;
    }

    public function reject(Request $request)
    {
        $giro=Giro::where('id',$request->id)->first();

        $giropay = Giro::where('id',$request->id)->update([
            'cashed' => 0,
            'status' => "rejected"
        ]);
        return $giro;
    }

    public function cash(Request $request)
    {
        $giro=Giro::where('id',$request->id)->first();

        $giropay = Giro::where('id',$request->id)->update([
            'id_payment_account' => $request->id_payment_account,
            'cashed' => 1,
            'date_cashed' => date("Y-m-d",strtotime($request->date)),
            'status' => "cashed"
        ]);


        $transactionpayment = TransactionPayment::create([
            'jurnal_id'=>$giro->jurnal_id,
            'id_payment_account' => $request->id_payment_account,
            'id_transaction' => $giro->id_transaction,
            'date' => date("Y-m-d",strtotime($request->date)),
            'paid' => $giro->balance,
            'method' => "giro"
        ]);

        $paid=Transaction::where('id',$giro->id_transaction)->first()->paid;
        $newpaid=intval($paid)+intval($giro->balance);
        Transaction::where('id',$giro->id_transaction)->update(['paid'=>$newpaid]);


        $transaction=Transaction::where('id',$giro->id_transaction)->first();

        $invoice = json_decode($this->client->request(
            'GET',
            'sales_invoices/'.$transaction->jurnal_id
        )->getBody()->getContents());

        $transaction_line=[];
        $transaction_line[0]["transaction_no"]= $invoice->sales_invoice->transaction_no;
        $transaction_line[0]["amount"]=$giro->balance;
        
        $request->date = date("d/m/Y", strtotime($request->date));  



        $paymentaccount=PaymentAccount::where('id',$request->id_payment_account)->first();

        $to=json_decode($this->client->request(
            'get',
            'accounts/'.$paymentaccount->jurnal_id
        )->getBody()->getContents());

        $response = json_decode($this->client->request(
            'POST',
            'receive_payments',
            [
                'json' => 
                [
                    "receive_payment" => [
                        "transaction_date" => $request->date,
                        "records_attributes"=> $transaction_line,
                        "payment_method_name"=> "Cek & Giro",
                        "is_draft"=> false,
                        'deposit_to_name'=> $to->account->name,
                    ]
                ]
            ]
        )->getBody()->getContents());



        return $giro;
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

        $history=TransactionPayment::with('paymentaccount')->where('id_transaction',$request->id)->orderBy('date','asc')->get();
        if($history->isEmpty()){
            $transaction['paymenthistory']="EMPTY";
        }else{
            $transaction['paymenthistory']="";
            foreach ($history as $key => $value) {
                $bank=Bank::where('id',$value->paymentaccount->id_bank)->first();
                $transaction['paymenthistory'].= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->date."</td>
                            <td>".$bank->name." - ".$value->paymentaccount->account_name."</td>
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
