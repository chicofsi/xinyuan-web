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
use App\Models\PaymentAccount;

class TransactionController extends Controller
{
    

    public function addTransaction(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'id_customer' => 'required',
            'payment' => 'required',
            'payment_period' => 'required',
            'date' => 'required',
            'paid' => 'required',
            'total_payment' => 'required',
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
                'date' => date("Y-m-d",strtotime($request->date)),
                'payment' => $request->payment,
                'payment_deadline' => Date('Y-m-d', strtotime($request->date.' +'.$tempo.' days')),
                'paid' => 0,
                'total_payment' => $request->total_payment
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

            

            $data=Transaction::where('id',$transaction->id)->first();

            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Customer Register Success!','data'=>  $transaction]), 200);;
            
        }

    }
    
    public function addTransactionDetails(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_transaction' => 'required',
            'id_product' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'total' => 'required'
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);                        
        }else{
            
            
            
            $transactiondetails = TransactionDetails::create([
                'id_transaction' => $request->id_transaction,
                'id_product' => $request->id_product,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $request->total
            ]);

            $transaction=Transaction::where('id',$request->id_transaction)->with('transactiondetails')->first();


            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Add Transaction Details Success!','data'=>  $transaction]), 200);
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

            


            return  response()->json(new ValueMessage(['value'=>1,'message'=>'Payment Success!','data'=>  $transactionpayment]), 200);
        }

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
            
            $data=new TransactionResource(Transaction::where('id',$request->id_transaction)->with('transactiondetails','transactionpayment','giro','sales','customer')->first());

            


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
        $data=Transaction::where('id_sales',$request->user()->id)->with('transactiondetails','transactionpayment','giro')->orderBy('id','desc')->get();

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
