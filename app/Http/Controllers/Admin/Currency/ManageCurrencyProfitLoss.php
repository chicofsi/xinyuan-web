<?php

namespace App\Http\Controllers\Admin\Currency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Factories;
use App\Models\Product;
use App\Models\Bank;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\PurchasePayment;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;
use App\Helper\JurnalHelper;

class ManageCurrencyProfitLoss extends Controller
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
        return view('admin.currency.index');
    }

    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $purchase=Purchase::with('purchasedetails','purchasepayment','factories','currency')->whereBetween('date', [$from, $to])->get();
        if($purchase->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='7'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($purchase as $key => $value) {
                
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
                    $stat="<span class='label label-danger'>Late</span>";
                }else {
                    $stat="<span class='label label-info'>".$difference." Day to due date</span>";
                }
                $debt=intval($value->total_payment)-intval($value->paid);
                if($debt==0){
                    $stat="<span class='label label-success'>Payment Done</span>";
                }
                $total_profit=0;
                $child="";
                foreach ($value->purchasepayment as $k => $val) {
                    $total_payment=$value->total_payment;
                    $rates=$value->purchasedetails[0]->rates;
                    $paid=$val->paid;
                    $rates_paid=$val->rates;

                    $real_price=$rates*$paid;
                    $paid_price=$rates_paid*$paid;

                    $profit=$real_price-$paid_price;
                    $total_profit+=$profit;
                    if($profit==0){
                        $stat="<span class='label label-info'>".$profit."</span>";
                    }else if($profit<0){
                        $stat="<span class='label label-danger'>".$profit."</span>";
                    }else {
                        $stat="<span class='label label-success'>".$profit."</span>";
                    }

                    $child.= "<tr>
                            <td>Payment Data</td>
                            <td>".$val->date."</td>
                            <td>".$value->currency->symbol.number_format(intval($val->paid), 0, ',', ',')."</td>
                            <td></td>
                            <td>Rp. ".number_format(intval($val->rates), 0, ',', ',')."</td>
                            <td>Rp. ".number_format(intval($real_price), 0, ',', ',')."</td>
                            <td>Rp. ".number_format(intval($paid_price), 0, ',', ',')."</td>
                            <td>".$stat."</td>
                        </tr>";
                }
                if($total_profit==0){
                    $stat="<span class='label label-info'>".$total_profit."</span>";
                }else if($total_profit<0){
                    $stat="<span class='label label-danger'>".$total_profit."</span>";
                }else {
                    $stat="<span class='label label-success'>".$total_profit."</span>";
                }

                $data.= "<tr>
                            <td rowspan=".($value->purchasepayment->count()+1).">".$value->invoice_number."</td>
                            <td>Purchase Data</td>
                            <td>".$value->date."</td>
                            <td>".$value->currency->symbol.number_format(intval($value->total_payment), 0, ',', ',')."</td>
                            <td>Rp. ".number_format(intval($value->purchasedetails[0]->rates), 0, ',', ',')."</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>";
                $data.=$child;
            }
            $returndata['data']=$data;

            return $returndata;
        }

    }

    public function pay(Request $request)
    {
        $request->date=str_replace('-','/',$request->date);
        $purchase=Purchase::where('id',$request->id)->with('currency')->first();
        if($purchase->currency->name=="IDR"){
            $rates=1;
            $paid_idr=$request->PayBalance;
        }else{
            $rates=$request->rates;
            $paid_idr=$request->PayBalance*$rates;
        }
        $purchasepayment = PurchasePayment::create([
            'id_payment_account' => $request->id_payment_account,
            'id_purchase' => $request->id,
            'date' => date("Y-m-d",strtotime($request->date)),
            'paid' => $request->PayBalance,
            'rates' => $rates,
            'paid_idr' => $paid_idr,
        ]);
        $paid=Purchase::where('id',$request->id)->first()->paid;
        $newpaid=intval($paid)+intval($request->PayBalance);

        $paid=Purchase::where('id',$request->id)->first()->paid_idr;
        $newpaid_idr=intval($paid)+intval($paid_idr);
        Purchase::where('id',$request->id)->update(['paid_idr'=>$newpaid_idr,'paid'=>$newpaid]);

        $purchase=Purchase::where('id',$request->id)->first();

        $invoice = json_decode($this->client->request(
            'GET',
            'purchase_invoices/'.$purchase->jurnal_id
        )->getBody()->getContents());

        $transaction_line=[];
        $transaction_line[0]["transaction_no"]= $invoice->purchase_invoice->transaction_no;
        $transaction_line[0]["amount"]=$request->PayBalance;

        $paymentaccount=PaymentAccount::where('id',$request->id_payment_account)->first();

        $account = json_decode($this->client->request(
            'GET',
            'accounts/'.$paymentaccount->jurnal_id
        )->getBody()->getContents());
        
        $request->date = date("d/m/Y", strtotime($request->date));  


        $response = json_decode($this->client->request(
            'POST',
            'purchase_payments',
            [
                'json' => 
                [
                    "purchase_payment" => [
                        "transaction_date" => $request->date,
                        "records_attributes"=> $transaction_line,
                        "payment_method_name"=> "Cash",
                        "is_draft"=> false,
                        "refund_from_name"=> $account->account->name
                    ]
                ]
            ]
        )->getBody()->getContents());

        $purchasepayment=PurchasePayment::where('id',$purchasepayment->id)->update(['jurnal_id'=>$response->purchase_payment->id]);
        return $purchasepayment;
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
        $purchase  = Purchase::where('id',$request->id)->with('currency','factories','purchasedetails','purchasepayment')->first();
        
        $datedeadline=strtotime($purchase->payment_deadline);
        $date=strtotime($purchase->date);

        $purchase->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));

        $debt=(intval($purchase->total_payment)-intval($purchase->paid));
        
        
        $purchase->debt =  $debt;

        $history=PurchasePayment::with('paymentaccount')->where('id_purchase',$request->id)->orderBy('date','asc')->get();
        if($history->isEmpty()){
            $purchase['paymenthistory']="EMPTY";
        }else{
            $purchase['paymenthistory']="";
            foreach ($history as $key => $value) {
                $status="";
                if($value->method=='cash'){
                    $status="<a href='javascript:void(0)' onClick=editPayment(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-info btn-sm'>Edit</a>";
                }
                $bank=Bank::where('id',$value->paymentaccount->id_bank)->first();
                $purchase['paymenthistory'].= "<tr>
                            <td>".$value->date."</td>
                            <td>".$bank->name." - ".$value->paymentaccount->account_name."</td>
                            <td>".$value->paid."</td>
                            <td>".$value->method."</td>
                            <td>".$status."</td>
                        </tr>";
            }
        }

        return Response()->json($purchase);

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
        $payment  = PurchasePayment::where($where)->with('purchase')->first();
      
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
        $payment=PurchasePayment::where('id',$paymentId)->with('purchase')->first();
        
        $diff=intval($payment->paid)-intval($request->PayBalance);

        $purchase=Purchase::where('id',$payment->purchase->id)->first();
        $paid=$purchase->paid_idr;

        $payment   =   PurchasePayment::updateOrCreate(
            [
                'id' => $paymentId
            ],
            [
                'id_payment_account' => $request->id_payment_account,
                'date' => date("Y-m-d",strtotime($request->date)),
                'paid' => $request->PayBalance
            ]);    

        $newpaid=intval($paid)-intval($diff);
        Purchase::where('id',$purchase->id)->update(['paid_idr'=>$newpaid]);
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
