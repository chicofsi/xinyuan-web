<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\PurchasePayment;
use App\Models\Factories;
use App\Models\Product;
use App\Models\PaymentAccount;
use App\Models\Currency;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;

use App\Helper\JurnalHelper;

use App\Exports\PurchaseExport;
use Maatwebsite\Excel\Facades\Excel;

class ManagePurchase extends Controller
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
        $factories = Factories::all();
        $accounts = PaymentAccount::with('bank')->get();
        $currency = Currency::all();
        $warehouses = Warehouse::all();


        return view('admin.purchase.index',compact('product','factories','accounts','currency','warehouses'));
    }

    public function export(Request $request)
    {
        $from = date("Y-m-d",strtotime($request->input('from')));
        $to = date("Y-m-d",strtotime($request->input('to')));

        $purchase = new PurchaseExport($from,$to);
        
        return Excel::download($purchase, 'purchase_'.$from."_".$to.'.xlsx');
    }

    public function list(Request $request)
    {
        $from=date("Y-m-d",strtotime($request->from));
        $to=date("Y-m-d",strtotime($request->to));
        $nice=$request->nice;
        
        $purchase=Purchase::with('purchasedetails','factories','currency')->whereBetween('date', [$from, $to])->get();
        
        if($purchase->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='7'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($purchase as $key => $value) {
                $data.= "<tr>
                            <td>".$value->invoice_number."</td>
                            <td>".$value->factories->name."</td>
                            <td>".$value->date."</td>
                            <td>".$value->currency->symbol.number_format(intval($value->total_payment), 0, ',', ',')."</td>
                            <td>Rp. ".number_format(intval($value->purchasedetails[0]->rates), 0, ',', ',')."</td>
                            <td>Rp. ".number_format(intval($value->total_payment_idr), 0, ',', ',')."</td>
                            <td>Rp. ".number_format(intval($value->paid_idr), 0, ',', ',')."</td>
                            <td>".$value->purchasedetails->count()."</td>
                            <td><a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";
            }


            $returndata['data']=$data;

            return $returndata;
        }

    }


    public function store(Request $request)
    {
        $paid=0;
        $request->date=str_replace('-','/',$request->date);
        
        if($request->payment == "cash"){
            $tempo=0;
        }else{
            $tempo=$request->tempo;
        }

        if($request->id_currency==1){
            $rates=1;
            $total_payment=$request->total_payment_idr;
        }else{
            $rates=$request->rates;
            $total_payment=$request->total_payment_idr/$request->rates;
        }

        $purchase   =   Purchase::create([
            'invoice_number' => $request->invoice_number,
            'id_factories' => $request->id_factories,
            'id_warehouse' => $request->id_warehouse,
            'id_currency' => $request->id_currency,
            'date' => date("Y-m-d",strtotime($request->date)),
            'payment' => $request->payment,
            'payment_deadline' => Date('Y-m-d', strtotime($request->date.' +'.$tempo.' days')),
            'paid_idr' => $paid,
            'total_payment' => $total_payment,
            'total_payment_idr' => $request->total_payment_idr
        ]);    
        if($request->payment == "cash"){
            $purchase=Purchase::where('id',$purchase->id)->with('currency')->first();
            if($purchase->currency->name=="IDR"){
                $rates=1;
                $paid_idr=$request->total_payment_idr;
            }else{
                $rates=$request->rates;
                $paid_idr=$request->PayBalance*$rates;
            }
            $purchasepayment = PurchasePayment::create([
                'id_payment_account' => $request->id_payment_account,
                'id_purchase' => $purchase->id,
                'date' => date("Y-m-d",strtotime($request->date)),
                'paid' => $total_payment,
                'rates' => $rates,
                'paid_idr' => $paid_idr,
            ]);
            Purchase::where('id',$purchase->id)->update(['paid_idr'=>$request->total_payment_idr]);
        }



                         
        return Response()->json($purchase);
    }

    public function edit(Request $request)
    {

        $request=json_decode($request->getContent());



        if($request->id_currency==1){
            $rates=1;
            $total_payment=$request->total_payment_idr;
        }else{
            $rates=$request->rates;
            $total_payment=$request->total_payment_idr/$request->rates;
        }
        $purchase   =   Purchase::where('id',$request->id)->update([
            'invoice_number' => $request->invoice_number,
            'id_factories' => $request->id_factories,
            'id_warehouse' => $request->id_warehouse,
            'id_currency' => $request->id_currency,
            'date' => date("Y-m-d",strtotime($request->date)),
            'payment' => $request->payment,
            'payment_deadline' => Date('Y-m-d', strtotime($request->date.' +'.$request->tempo.' days')),
            'total_payment' => $total_payment,
            'total_payment_idr' => $request->total_payment_idr
        ]);    

        foreach ($request->details as $key => $value) {
            if($request->id_currency==1){
                $rates=1;
            }else{
                $rates=$value->rates;
            }
            $price_idr=$value->price*$rates;
            $total=$value->quantity*$value->price;            
            if(isset($value->id_purchase_details)){
                $purchasedetails = PurchaseDetails::where('id',$value->id_purchase_details)->first();

                $warehouseproduct=WarehouseProduct::where('id_product',$purchasedetails->id_product)->where('id_warehouse',$request->id_warehouse)->first();
                if($warehouseproduct){
                    $qty=$warehouseproduct->quantity;
                    $qty-=$purchasedetails->quantity;
                    $qty+=$value->quantity;
                }else{
                    $qty=0;
                    $qty-=$purchasedetails->quantity;
                    $qty+=$value->quantity;
                }

                $warehouseproduct=WarehouseProduct::updateOrCreate(
                [
                    "id_warehouse" => $request->id_warehouse,
                    "id_product" => $value->id_product
                ],
                [
                    "quantity" => $qty
                ]);

                $purchasedetails = PurchaseDetails::where('id',$value->id_purchase_details)->update(
                [
                    'id_purchase' => $value->id_purchase,
                    'quantity' => $value->quantity,
                    'price' => $value->price,
                    'total' => $total,
                    'price_idr' => $price_idr,
                    'total_idr' => $value->total,
                    'rates' => $rates
                ]); 
            }else{
                $purchasedetails = PurchaseDetails::create(
                [
                    'id_purchase' => $value->id_purchase,
                    'id_product' => $value->id_product,
                    'quantity' => $value->quantity,
                    'price' => $value->price,
                    'total' => $total,
                    'price_idr' => $price_idr,
                    'total_idr' => $value->total,
                    'rates' => $rates
                ]); 
                $warehouseproduct=WarehouseProduct::where('id_product',$purchasedetails->id_product)->where('id_warehouse',$request->id_warehouse)->first();
                if($warehouseproduct){
                    $qty=$warehouseproduct->quantity;
                    $qty+=$value->quantity;
                }else{
                    $qty=0;
                    $qty+=$value->quantity;
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

        return Response()->json($purchase);
    }

    public function storeProduct(Request $request)
    {
        $purchase=Purchase::where('id',$request->id_purchase)->first();
        if($purchase->id_currency==1){
            $rates=1;
        }else{
            $rates=$request->rates;
        }
        $price_idr=$request->price*$rates;
        $total=$request->quantity*$request->price;   
        $purchasedetails = PurchaseDetails::create([
            'id_purchase' => $request->id_purchase,
            'id_product' => $request->id_product,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $total,
            'price_idr' => $price_idr,
            'total_idr' => $request->total,
            'rates' => $rates
        ]); 

        $warehouseproduct=WarehouseProduct::where('id_product',$request->id_product)->where('id_warehouse',$purchase->id_warehouse)->first();
        if($warehouseproduct){
            $qty=$warehouseproduct->quantity;
            $qty+=$request->quantity;
        }else{
            $qty=0;
            $qty+=$request->quantity;
        }

        $warehouseproduct=WarehouseProduct::updateOrCreate(
        [
            "id_warehouse" => $purchase->id_warehouse,
            "id_product" => $request->id_product
        ],
        [
            "quantity" => $qty
        ]);

        return Response()->json($purchasedetails);
    }

    public function storeJurnal(Request $request)
    {
        $purchase=Purchase::where('id',$request->id_purchase)->with('factories','purchasedetails','currency')->first();
        $warehouse=Warehouse::where('id',$purchase->id_warehouse)->first();
        $data=[];
        $data['transaction_date'] = date("d/m/Y", strtotime($purchase->date));  
        $data['due_date'] = date("d/m/Y", strtotime($purchase->payment_deadline));  
        
        $transaction_line=[];
        foreach ($purchase->purchasedetails as $key => $value) {
            $product=Product::where('id',$value->id_product)->first();
            $product = json_decode($this->client->request(
                'GET',
                'products/'.$product->jurnal_id
            )->getBody()->getContents());

            $transaction_line[$key]["quantity"]=$value->quantity;
            $transaction_line[$key]["product_name"]=$product->product->name;
            $transaction_line[$key]["rate"]=$value->price_idr;
        }

        $datedeadline=strtotime($purchase->payment_deadline);
        $date=strtotime($purchase->date);
        $purchase->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));

        if($purchase->tempo==0){
            $term="Cash on Delivery";
        }else{
            $term="Net ".$purchase->tempo;
        }

        $person = json_decode($this->client->request(
                'GET',
                'contacts/'.$purchase->factories->jurnal_id
            )->getBody()->getContents());

        $response = json_decode($this->client->request(
            'POST',
            'purchase_invoices',
            [
                'json' => 
                [
                    "purchase_invoice" => [
                        "transaction_date" => $data['transaction_date'],
                        "transaction_lines_attributes" => $transaction_line,
                        "term_name"=> $term,
                        "due_date"=> $data['due_date'],
                        "person_name"=> $person->person->display_name,
                        "warehouse_id"=> $warehouse->jurnal_id,
                    ]
                ]
            ]
        )->getBody()->getContents());
        $data=Purchase::where('id',$request->id_purchase)->update(['jurnal_id'=>$response->purchase_invoice->id]);

        if($purchase->payment=="cash"){
            $purchase=Purchase::where('id',$request->id_purchase)->with('purchasepayment')->first();

            $invoice = json_decode($this->client->request(
                'GET',
                'purchase_invoices/'.$purchase->jurnal_id
            )->getBody()->getContents());

            $transaction_line=[];
            $transaction_line[0]["transaction_no"]= $invoice->purchase_invoice->transaction_no;
            $transaction_line[0]["amount"]=$purchase->total_payment_idr;

            $paymentaccount=PaymentAccount::where('id',$purchase->purchasepayment[0]->id_payment_account)->first();

            $account = json_decode($this->client->request(
                'GET',
                'accounts/'.$paymentaccount->jurnal_id
            )->getBody()->getContents());
            
            $date = date("d/m/Y", strtotime($purchase->purchasepayment[0]->date));  

            $response = json_decode($this->client->request(
                'POST',
                'purchase_payments',
                [
                    'json' => 
                    [
                        "purchase_payment" => [
                            "transaction_date" => $date,
                            "records_attributes"=> $transaction_line,
                            "payment_method_name"=> "Cash",
                            "is_draft"=> false,
                            "refund_from_name"=> $account->account->name
                        ]
                    ]
                ]
            )->getBody()->getContents());

            $purchasepayment=PurchasePayment::where('id',$purchase->purchasepayment[0]->id)->update(['jurnal_id'=>$response->purchase_payment->id]);

        }
        return $data;
    }
    public function editProduct(Request $request)
    {
        return Response()->json($purchasedetails);
    }    
    public function deleteProduct(Request $request)
    {
        $purchasedetails = PurchaseDetails::where('id',$request->id)->with('purchase')->first();
        $warehouseproduct=WarehouseProduct::where('id_product',$purchasedetails->id_product)->where('id_warehouse',$purchasedetails->purchase->id_warehouse)->first();
        $qty=$warehouseproduct->quantity-$purchasedetails->quantity;

        $warehouseproduct=WarehouseProduct::where('id_product',$purchasedetails->id_product)->where('id_warehouse',$purchasedetails->purchase->id_warehouse)->update(["quantity"=>$qty]);

        $purchasedetails = PurchaseDetails::where('id',$request->id)->delete();

        return Response()->json($purchasedetails);
    }

    public function show(Request $request)
    {
        $purchase  = Purchase::where('id',$request->id)->with('factories','purchasedetails','purchasepayment')->first();
        $datedeadline=strtotime($purchase->payment_deadline);
        $date=strtotime($purchase->date);

        $purchase->tempo =  round(($datedeadline - $date) / (60 * 60 * 24));

        foreach ($purchase->purchasedetails as $key => $value) {
            $purchase->purchasedetails[$key]['totalprod']=$value->quantity;
        }
        
        
        return Response()->json($purchase);
    }

    public function destroy(Request $request)
    {

        $purchasedetails=PurchaseDetails::where('id_purchase',$request->id)->with('purchase')->get();
        foreach ($purchasedetails as $key => $value) {
            $warehouseproduct=WarehouseProduct::where('id_product',$value->id_product)->where('id_warehouse',$value->purchase->id_warehouse)->first();
            $qty=$warehouseproduct->quantity-$value->quantity;

            $warehouseproduct=WarehouseProduct::where('id_product',$value->id_product)->where('id_warehouse',$value->purchase->id_warehouse)->update(["quantity"=>$qty]);

            PurchaseDetails::where('id',$value->id)->delete();
        }
        PurchasePayment::where('id_purchase',$request->id)->delete();
        $purchase=Purchase::where('id',$request->id)->first();
        $response = json_decode($this->client->request(
            'DELETE',
            'purchase_invoices/'.$purchase->jurnal_id
        )->getBody()->getContents());
        $purchase=Purchase::where('id',$request->id)->delete();
        return $purchase;

    }

    public function getCurrency()
    {
        $response = json_decode($this->client->request(
            'GET',
            'currency_rates'
        )->getBody()->getContents());
        return $response;
    }
}
