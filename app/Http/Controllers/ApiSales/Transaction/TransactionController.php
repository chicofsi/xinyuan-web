<?php

namespace App\Http\Controllers\ApiSales\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ValueMessage;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\Area as AreaResource;
use App\Http\Resources\Transaction as TransactionResource;
use App\Http\Resources\TransactionPayment as TransactionPaymentResource;
use App\Http\Resources\PaymentAccount as PaymentAccountResource;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionPayment;
use App\Models\Product;
use App\Models\Giro;
use App\Models\Bank;
use App\Models\Warehouse;
use App\Models\PaymentAccount;

use App\Helper\JurnalHelper;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->client = JurnalHelper::index();
    }
    public function addTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'id_customer' => 'required',
            'id_warehouse' => 'required',
            'payment' => 'required',
            'payment_period' => 'required',
            'date' => 'required',
            'total_payment' => 'required',
            'id_company' => 'required',
            'product' => 'required'
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            if($request->payment == "cash"){
                $tempo=0;
            }else{
                $tempo=$request->payment_period;
            }
            $transaction = Transaction::create([
                'invoice_number' => $request->invoice_number,
                'id_sales' => $request->user()->id,
                'id_customer' => $request->id_customer,
                'id_warehouse' => $request->id_warehouse,
                'date' => date("Y-m-d",strtotime($request->date)),
                'payment' => $request->payment,
                'payment_deadline' => Date('Y-m-d', strtotime($request->date.' +'.$tempo.' days')),
                'paid' => 0,
                'total_payment' => $request->total_payment,
                'id_company' => $request->id_company,
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

            foreach ($request->product as $key => $value) {
                $transactiondetails = TransactionDetails::create([
                    'id_transaction' => $transaction->id,
                    'id_product' => $value['id_product'],
                    'quantity' => $value['quantity'],
                    'price' => $value['price'],
                    'total' => $value['total']
                ]);
            }

            $transaction = Transaction::where('id',$transaction->id)->with('transactiondetails','transactionpayment','giro','sales','customer','warehouse','company')->first();
            $this->storeTransactionJurnal($transaction->id);
            $data=new TransactionResource($transaction);

            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Add Transaction Success!','data'=>  $data]), 200);;
        }
    }

    public function storeTransactionJurnal($id_transaction)
    {
        $transaction=Transaction::where('id',$id_transaction)->with('customer','transactiondetails')->first();
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
        $data=Transaction::where('id',$id_transaction)->update(['jurnal_id'=>$response->sales_invoice->id]);

        if($transaction->payment=="cash"){
            $transaction=Transaction::where('id',$id_transaction)->with('transactionpayment')->first();

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
    }
    
    public function addTransactionPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_transaction' => 'required',
            'paid' => 'required',
            'date' => 'required'
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            
            
            
            $transactionpayment = TransactionPayment::create([
                'id_payment_account' => $request->id_payment_account,
                'id_transaction' => $request->id_transaction,
                'date' => date("Y-m-d",strtotime($request->date)),
                'paid' => $request->paid
            ]);
            $paid=Transaction::where('id',$request->id_transaction)->first()->paid;
            $newpaid=intval($paid)+intval($request->paid);
            Transaction::where('id',$request->id_transaction)->update(['paid'=>$newpaid]);
            $this->storePaymentJurnal($transactionpayment->id);
            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Payment Success!','data'=>  $transactionpayment]), 200);
        }
    }
    public function storePaymentJurnal($id_payment)
    {
        $transactionpayment=TransactionPayment::where('id',$id_payment)->first();
        $transaction=Transaction::where('id',$transactionpayment->id_transaction)->first();

        $invoice = json_decode($this->client->request(
            'GET',
            'sales_invoices/'.$transaction->jurnal_id
        )->getBody()->getContents());

        $transaction_line=[];
        $transaction_line[0]["transaction_no"]= $invoice->sales_invoice->transaction_no;
        $transaction_line[0]["amount"]=$transactionpayment->paid;

        $paymentaccount=PaymentAccount::where('id',$transactionpayment->id_payment_account)->first();

        $account = json_decode($this->client->request(
            'GET',
            'accounts/'.$paymentaccount->jurnal_id
        )->getBody()->getContents());
        
        $date = date("d/m/Y", strtotime($transactionpayment->date));  


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

        $transactionpayment=TransactionPayment::where('id',$id_payment)->update(['jurnal_id'=>$response->receive_payment->id]);
    }

    public function addTransactionGiro(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_transaction' => 'required',
            'id_bank' => 'required',
            'giro_number' => 'required',
            'balance' => 'required',
            'date_received' => 'required',
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            
            
            $transaction=Transaction::where('id',$request->id_transaction)->first();

            $giro = Giro::create([
                'id_bank' => $request->id_bank,
                'id_transaction' => $request->id_transaction,
                'id_customer' => $transaction->id_customer,
                'giro_number' => $request->giro_number,
                'balance' => $request->balance,
                'date_received' => date("Y-m-d",strtotime($request->date_received)),
                'id_payment_account' => null,
                'cashed' => 0,
                'date_cashed' => null
            ]);
            
            $giro=Giro::where('id',$giro->id)->first();

            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Add Giro Success!','data'=>  $giro]), 200);
        }

    }

    public function getAllGiro(Request $request)
    {
        $giro=Giro::with('transaction','customer','bank')->get();

        if($giro->isEmpty()){
            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Giro Not Found!','data'=>  ""]), 404);

        }else{
            $data='';
            foreach ($giro as $key => $value) {
                if($value->customer->invited_by!=Auth::id()){
                    continue;
                }
                $data[$key]=$value;
            }
            if($data==''){
                return  response()->json(new ValueMessage(['value'=>1,'message'=>'Giro Not Found!','data'=>  ""]), 404);
            }
            else{
                return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Giro Success!','data'=>  $data]), 200);

            }
        }
    }



    public function getTransactionDetails(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_transaction' => 'required'
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            
            $data=new TransactionResource(Transaction::where('id',$request->id_transaction)->with('transactiondetails','transactionpayment','giro','sales','customer','warehouse','company')->first());

            


            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Transaction Details Success!','data'=>  $data]), 200);
        }

    }

    public function getCustomerTransaction(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_customer' => 'required'
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            
            
            $data=Transaction::where('id_customer',$request->id_customer)->with('transactiondetails','transactionpayment')->get();

            


            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Transaction List Success!','data'=>  $data]), 200);
        }

    }

    public function getSalesTransaction(Request $request)
    {
        $data=Transaction::where('id_sales',$request->user()->id)->with('transactiondetails','transactionpayment','giro','company','warehouse')->orderBy('id','desc')->get();

        if($data->isEmpty()){
            $returndata=[];
        }else{
            foreach ($data as $key => $value) {
                $returndata[$key] = new TransactionResource($value);
            }
        }

        return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Transaction List Success!','data'=>  $returndata]), 200);
    }
    public function getTransactionPayment(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_transaction' => 'required'
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            $history=TransactionPayment::where('id_transaction',$request->id_transaction)->with('paymentaccount')->get();
            if($history->isEmpty()){
                return  response()->json(new ValueMessage(['value'=>0,'message'=>'Transaction Payment Not Found!','data'=>  ""]), 404);
            }else{
                foreach ($history as $key => $value) {
                    $data[$key]=new TransactionPaymentResource($value);
                }
                return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Transaction Payment History Success!','data'=>  $data]), 200);
            }
            

            


        }

    }

    public function getPaymentAccount(Request $request)
    {

        $accounts=PaymentAccount::with('bank')->get();
        if($accounts->isEmpty()){
            return  response()->json(new ValueMessage(['value'=>0,'message'=>'Payment Accounts Not Found!','data'=>  ""]), 404);
        }else{
            foreach ($accounts as $key => $value) {
                $data[$key] = new PaymentAccountResource($value);
            }
            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Payment Accounts Success!','data'=>  $data]), 200);
        }

    }
    public function getBank(Request $request)
    {

        $bank=Bank::all();
        if($bank->isEmpty()){
            return  response()->json(new ValueMessage(['value'=>0,'message'=>'Bank Not Found!','data'=>  ""]), 404);
        }else{
            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Get Bank Success!','data'=>  $bank]), 200);
        }

    }

    
}
