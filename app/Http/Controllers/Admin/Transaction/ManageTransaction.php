<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

use App\Models\Sales;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\TransactionReturn;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Giro;
use App\Models\TransactionDetails;
use App\Models\TransactionRefund;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\Company;
use App\Helper\JurnalHelper;

class ManageTransaction extends Controller
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
    public function index(Request $request)
    {
        $product = Product::all();
        $sales = Sales::all();
        $accounts = PaymentAccount::with('bank')->get();
        $company = Company::get();
        $level = CustomerLevel::get();

        if(Auth::guard('web')->check()){
            $customer = Customer::all();
        }else{ 
            $customer = Customer::where('invited_by',$request->user()->id)->get();
        }
        $warehouses = Warehouse::all();

        return view('admin.transaction.index',compact('product','sales','customer','accounts','warehouses','company','level'));
    }
    
    public function full(Request $request)
    {
        $product = Product::all();
        $sales = Sales::all();

        if(Auth::guard('web')->check()){
            $customers = Customer::all();
        }else{ 
            $customers = Customer::where('invited_by',$request->user()->id)->get();
        }

        $invoices = Transaction::all();
        $products = Product::with('type','size','colour','logo')->all();




        return view('admin.transaction.fullscreen',compact('product','sales','customers','invoices','products'));
        
    }

    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $nice=$request->nice;
        $company=$request->company;
        
        if(Auth::guard('web')->check()){
            $transaction=Transaction::with('customer','transactiondetails','sales','company')->whereBetween('date', [$from, $to]);
        }else{
            $transaction=Transaction::with('customer','transactiondetails','sales','company')->whereBetween('date', [$from, $to])->where('id_sales',$request->user()->id);
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
                $data.= "<tr>
                            <td>".$value->invoice_number."</td>
                            <td>".$customer->company_name."</td>
                            <td>".$customer->customerlevel->level."</td>
                            <td>".$value->sales->name."</td>
                            <td>".$value->date."</td>
                            <td>".number_format(intval($value->total_payment), 0, ',', ',')."</td>
                            <td>".number_format(intval($value->paid), 0, ',', ',')."</td>
                            <td>".$value->transactiondetails->count()."</td>
                            <td>".$value->company->display_name."</td>
                            <td><a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";
            }

            $returndata['data']=$data;

            return $returndata;
        }
    }

    public function fulllist(Request $request)
    {
        if(Auth::guard('web')->check()){
            $transaction=Transaction::with('customer','transactiondetails','sales')->get();
        }else{
            $transaction=Transaction::with('customer','transactiondetails','sales')->where('id_sales',$request->user()->id)->get();
        }
        if($transaction->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='10'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($transaction as $key => $value) {
                $data.= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->invoice_number."</td>
                            <td>".$value->customer->company_name."</td>
                            <td>".$value->sales->name."</td>
                            <td>".$value->date."</td>";

                $data.="<td>";   
                foreach ($value->transactiondetails as $key => $prod) {
                    $product=Product::where('id',$prod->id_product)->with('type','size','colour','logo')->first();
                    $data.="<div class='row'>
                                <div class='col-sm-12'>
                                ".$product->type->name." ".$product->size->width."X".$product->size->height." ".$product->colour->name."
                                </div>
                            </div>";
                }
                $data.="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    
                    $data.="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->quantity."
                                </div>
                            </div>";
                            
                }
                $data.="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    $data.="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->price."
                                </div>
                            </div>";
                }
                $data.="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    $data.="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->total."
                                </div>
                            </div>";
                }
                $data.="</td>";

                $data.= "<td>".$value->total_payment."</td></tr>";
            }

            $returndata['data']=$data;
            // $returndata['area']=$area;
            // $returndata['level']=$level;
            // $returndata['tempo']=$tempo;

            return $returndata;
        }

    }

    public function store(Request $request)
    {
        $paid=0;
        $request->date=str_replace('-','/',$request->date);
        error_log($request->date);
        if(Auth::guard('web')->check()){
            $sales=Customer::where('id',$request->id_customer)->with('sales')->first()->sales->id;
        }else{
            $sales=$request->user()->id;
        }
        if($request->payment == "cash"){
            $tempo=0;
        }else{
            $tempo=$request->tempo;
        }
        $transaction   =   Transaction::create([
            'invoice_number' => $request->invoice_number,
            'id_sales' => $sales,
            'id_customer' => $request->id_customer,
            'id_warehouse' => $request->id_warehouse,
            'date' => date("Y-m-d",strtotime($request->date)),
            'payment' => $request->payment,
            'payment_deadline' => Date('Y-m-d', strtotime($request->date.' +'.$tempo.' days')),
            'paid' => $paid,
            'total_payment' => $request->total_payment,
            'id_company' => $request->company,
        ]);    
        if($request->payment == "cash"){
            $transactionpayment = TransactionPayment::create([
                'id_payment_account' => $request->id_payment_account,
                'id_transaction' => $transaction->id,
                'date' => date("Y-m-d",strtotime($request->date)),
                'paid' => $request->total_payment
            ]);
            Transaction::where('id',$transaction->id)->update(['paid'=>$request->total_payment]);
        }

                         
        return Response()->json($transaction);
    }

    public function edit(Request $request)
    {
        $request=json_decode($request->getContent());

        $transaction   =   Transaction::where('id',$request->id)->update([
            'invoice_number' => $request->invoice_number,
            'id_customer' => $request->id_customer,
            'id_warehouse' => $request->id_warehouse,
            'date' => date("Y-m-d",strtotime($request->date)),
            'payment' => $request->payment,
            'payment_deadline' => Date('Y-m-d', strtotime($request->date.' +'.$request->tempo.' days')),
            'id_company' => $request->company,
            'total_payment' => $request->total_payment
        ]);    

        foreach ($request->details as $key => $value) {
            if(isset($value->id_transaction_details)){
                $transactiondetails = TransactionDetails::where('id',$value->id_transaction_details)->first();

                $warehouseproduct=WarehouseProduct::where('id_product',$transactiondetails->id_product)->where('id_warehouse',$request->id_warehouse)->first();
                if($warehouseproduct){
                    $qty=$warehouseproduct->quantity;
                    $qty+=$transactiondetails->quantity;
                    $qty-=$value->quantity;
                }else{
                    $qty=0;
                    $qty+=$transactiondetails->quantity;
                    $qty-=$value->quantity;
                }

                $warehouseproduct=WarehouseProduct::updateOrCreate(
                [
                    "id_warehouse" => $request->id_warehouse,
                    "id_product" => $value->id_product
                ],
                [
                    "quantity" => $qty
                ]);

                $transactiondetails = TransactionDetails::where('id',$value->id_transaction_details)->update(
                [
                    'id_transaction' => $value->id_transaction,
                    'quantity' => $value->quantity,
                    'price' => $value->price,
                    'total' => $value->total
                ]); 
            }else{
                $transactiondetails = TransactionDetails::create(
                [
                    'id_transaction' => $value->id_transaction,
                    'id_product' => $value->id_product,
                    'quantity' => $value->quantity,
                    'price' => $value->price,
                    'total' => $value->total
                ]); 
                $warehouseproduct=WarehouseProduct::where('id_product',$transactiondetails->id_product)->where('id_warehouse',$request->id_warehouse)->first();
                if($warehouseproduct){
                    $qty=$warehouseproduct->quantity;
                    $qty-=$value->quantity;
                }else{
                    $qty=0;
                    $qty-=$value->quantity;
                }

                $warehouseproduct=WarehouseProduct::updateOrCreate(
                [
                    "id_warehouse" => $request->id_warehouse,
                    "id_product" => $value->id_product
                ],
                [
                    "quantity" => $qty
                ]);
            }
        }

        return Response()->json($transaction);
    }

    public function storeProduct(Request $request)
    {
        $transaction=Transaction::where('id',$request->id_transaction)->first();
        $transactiondetails = TransactionDetails::create([
            'id_transaction' => $request->id_transaction,
            'id_product' => $request->id_product,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->total
        ]); 


        $warehouseproduct=WarehouseProduct::where('id_product',$request->id_product)->where('id_warehouse',$transaction->id_warehouse)->first();
        if($warehouseproduct){
            $qty=$warehouseproduct->quantity;
            $qty-=$request->quantity;
        }else{
            $qty=0;
            $qty-=$request->quantity;
        }

        $warehouseproduct=WarehouseProduct::updateOrCreate(
        [
            "id_warehouse" => $transaction->id_warehouse,
            "id_product" => $request->id_product
        ],
        [
            "quantity" => $qty
        ]);
                         
        return Response()->json($transactiondetails);
    }

    public function deleteJurnalTransaction(Request $request)
    {

        $salesinvoices = json_decode($this->client->request(
            'GET',
            'sales_invoices',
            [
                'form_params' => 
                [
                    'page' => 1,
                    'page_size' => 1000,
                    'sort_key' => 'transaction_date',
                    'sort_order' => 'asc'
                ]
            ]
        )->getBody()->getContents());
        foreach ($salesinvoices->sales_invoices as $key => $value) {
            $id=$value->id;
            $response = json_decode($this->client->request(
                'DELETE',
                'sales_invoices/'.$id
            )->getBody()->getContents());
        }
    }

    public function uploadTransactionToJurnal(Request $request)
    {

        $transactionall = Transaction::where('jurnal_id',null)->get()->take(150);
        foreach ($transactionall as $key => $value) {
            if($value->jurnal_id==null){
                $transaction=Transaction::where('id',$value->id)->with('customer','transactiondetails')->first();
                $warehouse=Warehouse::where('id',$transaction->id_warehouse)->first();
                $data=[];
                $data['transaction_date'] = date("d/m/Y", strtotime($transaction->date));  
                $data['due_date'] = date("d/m/Y", strtotime($transaction->payment_deadline));  
                
                $transaction_line=[];
                foreach ($transaction->transactiondetails as $key => $value) {
                    $product=Product::where('id',$value->id_product)->first();
                    $product = json_decode($this->client->request(
                        'GET',
                        'products/'.$product->jurnal_id
                    )->getBody()->getContents());

                    $transaction_line[$key]["quantity"]=$value->quantity;
                    $transaction_line[$key]["product_name"]=$product->product->name;
                    $transaction_line[$key]["rate"]=$value->price;
                }

                $datedeadline=strtotime($transaction->payment_deadline);
                $date=strtotime($transaction->date);
                $transaction->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));
                if($transaction->tempo==0){
                    $term="Cash on Delivery";
                }else{
                    $term="Net ".$transaction->tempo;
                }

                $person = json_decode($this->client->request(
                        'GET',
                        'contacts/'.$transaction->customer->jurnal_id
                    )->getBody()->getContents());

                $response = json_decode($this->client->request(
                    'POST',
                    'sales_invoices',
                    [
                        'json' => 
                        [
                            "sales_invoice" => [
                                "transaction_date" => $data['transaction_date'],
                                "transaction_lines_attributes" => $transaction_line,
                                "term_name"=> $term,
                                "due_date"=> $data['due_date'],
                                "warehouse_id"=> $warehouse->jurnal_id,
                                "person_name"=> $person->person->display_name,
                            ]
                        ]
                    ]
                )->getBody()->getContents());
                $data=Transaction::where('id',$transaction->id)->update(['jurnal_id'=>$response->sales_invoice->id]);
            }
        }
    }

    public function storeJurnal(Request $request)
    {
        $transaction=Transaction::where('id',$request->id_transaction)->with('customer','transactiondetails')->first();
        $warehouse=Warehouse::where('id',$transaction->id_warehouse)->first();
        $data=[];
        $data['transaction_date'] = date("d/m/Y", strtotime($transaction->date));  
        $data['due_date'] = date("d/m/Y", strtotime($transaction->payment_deadline));  
        
        $transaction_line=[];
        foreach ($transaction->transactiondetails as $key => $value) {
            $product=Product::where('id',$value->id_product)->first();
            $product = json_decode($this->client->request(
                'GET',
                'products/'.$product->jurnal_id
            )->getBody()->getContents());

            $transaction_line[$key]["quantity"]=$value->quantity;
            $transaction_line[$key]["product_name"]=$product->product->name;
            $transaction_line[$key]["rate"]=$value->price;
        }

        $datedeadline=strtotime($transaction->payment_deadline);
        $date=strtotime($transaction->date);
        $transaction->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));
        if($transaction->tempo==0){
            $term="Cash on Delivery";
        }else{
            $term="Net ".$transaction->tempo;
        }

        $person = json_decode($this->client->request(
                'GET',
                'contacts/'.$transaction->customer->jurnal_id
            )->getBody()->getContents());

        $response = json_decode($this->client->request(
            'POST',
            'sales_invoices',
            [
                'json' => 
                [
                    "sales_invoice" => [
                        "transaction_date" => $data['transaction_date'],
                        "transaction_lines_attributes" => $transaction_line,
                        "term_name"=> $term,
                        "due_date"=> $data['due_date'],
                        "warehouse_id"=> $warehouse->jurnal_id,
                        "person_name"=> $person->person->display_name,
                    ]
                ]
            ]
        )->getBody()->getContents());
        $data=Transaction::where('id',$request->id_transaction)->update(['jurnal_id'=>$response->sales_invoice->id]);

        if($transaction->payment=="cash"){
            $transaction=Transaction::where('id',$request->id_transaction)->with('transactionpayment')->first();

            $invoice = json_decode($this->client->request(
                'GET',
                'sales_invoices/'.$transaction->jurnal_id
            )->getBody()->getContents());

            $transaction_line=[];
            $transaction_line[0]["transaction_no"]= $invoice->sales_invoice->transaction_no;
            $transaction_line[0]["amount"]=$transaction->total_payment;

            $paymentaccount=PaymentAccount::where('id',$transaction->transactionpayment[0]->id_payment_account)->first();

            $account = json_decode($this->client->request(
                'GET',
                'accounts/'.$paymentaccount->jurnal_id
            )->getBody()->getContents());
            
            $date = date("d/m/Y", strtotime($transaction->transactionpayment[0]->date));  

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

            $transactionpayment=TransactionPayment::where('id',$transaction->transactionpayment[0]->id)->update(['jurnal_id'=>$response->receive_payment->id]);

        }
        return $transaction;
    }
    public function editProduct(Request $request)
    {
        

        return Response()->json($transactiondetails);
    }    
    public function deleteProduct(Request $request)
    {
        $transactiondetails = TransactionDetails::where('id',$request->id)->with('transaction')->first();
        $warehouseproduct=WarehouseProduct::where('id_product',$transactiondetails->id_product)->where('id_warehouse',$transactiondetails->transaction->id_warehouse)->first();
        $qty=$warehouseproduct->quantity+$transactiondetails->quantity;

        $warehouseproduct=WarehouseProduct::where('id_product',$transactiondetails->id_product)->where('id_warehouse',$transactiondetails->transaction->id_warehouse)->update(["quantity"=>$qty]);

        $transactiondetails = TransactionDetails::where('id',$request->id)->delete();
   
        return Response()->json($transactiondetails);
    }    

    public function show(Request $request)
    {
        $transaction  = Transaction::where('id',$request->id)->with('customer','transactiondetails','transactionpayment','sales','transactionrefund','company')->first();
        $datedeadline=strtotime($transaction->payment_deadline);
        $date=strtotime($transaction->date);

        $transaction->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));

        foreach ($transaction->transactiondetails as $key => $value) {
            $transaction->transactiondetails[$key]['totalprod']=$value->quantity;
            foreach ($transaction->transactionrefund as $k => $v) {
                $transactionreturn=TransactionReturn::where('id_transaction_refund',$v->id)->get();

                foreach ($transactionreturn as $o => $w) {
                    if($value->id_product == $w->id_product){
                        $transaction->transactiondetails[$key]['totalprod']-=$w->qty;
                    }
                }
                
            }
        }
        
        
        return Response()->json($transaction);
    }

    public function destroy(Request $request)
    {
        $transactionrefund=TransactionRefund::where('id_transaction',$request->id)->get();
        foreach ($transactionrefund as $key => $value) {
            TransactionReturn::where('id_transaction_refund',$value->id)->delete();
        }
        TransactionRefund::where('id_transaction',$request->id)->delete();
        TransactionPayment::where('id_transaction',$request->id)->delete();
        Giro::where('id_transaction',$request->id)->delete();
        TransactionPayment::where('id_transaction',$request->id)->delete();
        $transactiondetails=TransactionDetails::where('id_transaction',$request->id)->with('transaction')->get();
        foreach ($transactiondetails as $key => $value) {
            $warehouseproduct=WarehouseProduct::where('id_product',$value->id_product)->where('id_warehouse',$value->transaction->id_warehouse)->first();
            $qty=$warehouseproduct->quantity+$value->quantity;

            $warehouseproduct=WarehouseProduct::where('id_product',$value->id_product)->where('id_warehouse',$value->transaction->id_warehouse)->update(["quantity"=>$qty]);

            TransactionDetails::where('id',$value->id)->delete();
        }
        $transaction=Transaction::where('id',$request->id)->first();
        $response = json_decode($this->client->request(
            'DELETE',
            'sales_invoices/'.$transaction->jurnal_id
        )->getBody()->getContents());

        $transaction=Transaction::where('id',$request->id)->delete();


        return $response;
    }
}
