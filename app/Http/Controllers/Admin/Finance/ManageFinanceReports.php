<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;

use App\Models\Sales;
use App\Models\Transaction;
use App\Models\Giro;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Bank;
use App\Models\TransactionDetails;
use App\Models\TransactionPayment;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;

use App\Helper\JurnalHelper;

class ManageFinanceReports extends Controller
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
        return view('admin.finance.reports.index');
    }
    
    public function balancesheet()
    {
        
        return view('admin.finance.reports.balancesheet');
        
    }
    public function quote($id)
    {
        
        return view('admin.finance.sales.quote',compact('id'));
        
    }
    public function order($id)
    {
        return view('admin.finance.sales.order',compact('id'));
        
    }
    public function newInvoice()
    {

        $customers = json_decode($this->client->request(
            'GET',
            'customers',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $products = json_decode($this->client->request(
            'GET',
            'products',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $warehouses = json_decode($this->client->request(
            'GET',
            'warehouses',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $terms = json_decode($this->client->request(
            'GET',
            'terms',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        
        return view('admin.finance.sales.addinvoice',compact('customers','products','warehouses','terms'));
    }

    public function newQuote()
    {

        $customers = json_decode($this->client->request(
            'GET',
            'customers',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $products = json_decode($this->client->request(
            'GET',
            'products',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $warehouses = json_decode($this->client->request(
            'GET',
            'warehouses',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $terms = json_decode($this->client->request(
            'GET',
            'terms',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        
        return view('admin.finance.sales.addquote',compact('customers','products','warehouses','terms'));
        
    }
    public function newOrder()
    {

        $customers = json_decode($this->client->request(
            'GET',
            'customers',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $products = json_decode($this->client->request(
            'GET',
            'products',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $warehouses = json_decode($this->client->request(
            'GET',
            'warehouses',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $terms = json_decode($this->client->request(
            'GET',
            'terms',
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        
        return view('admin.finance.sales.addorder',compact('customers','products','warehouses','terms'));
        
    }

    public function addNewInvoice(Request $request)
    {
        $request->transaction_date = date("d/m/Y", strtotime($request->transaction_date));  
        $request->due_date = date("d/m/Y", strtotime($request->due_date));  
        
        $transaction_line=[];
        foreach ($request->detail as $key => $value) {
            $product = json_decode($this->client->request(
                'GET',
                'products/'.$value['product']
            )->getBody()->getContents());

            $transaction_line[$key]["quantity"]=$value['quantity'];
            $transaction_line[$key]["product_name"]=$product->product->name;
            $transaction_line[$key]["rate"]=$value['price'];
            $transaction_line[$key]["discount"]=$value['discount'];

        }
        $terms = json_decode($this->client->request(
            'GET',
            'terms/'.$request->terms,
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $response = json_decode($this->client->request(
            'POST',
            'sales_invoices',
            [
                'json' => 
                [
                    "sales_invoice" => [
                        "transaction_date" => $request->transaction_date,
                        "transaction_lines_attributes" => $transaction_line,
                        "reference_no"=> $request->reference_no,
                        "address"=> $request->address,
                        "term_name"=> $terms->term->name,
                        "due_date"=> $request->due_date,
                        "person_name"=> $request->person_name,
                        "warehouse_name"=> $request->warehouse,
                        "tags"=> [
                            $request->tags
                        ],
                        "email"=> $request->email,
                        "message"=> $request->message,
                        "memo"=> $request->memo
                    ]
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
    }


    public function addNewQuote(Request $request)
    {
        $request->transaction_date = date("d/m/Y", strtotime($request->transaction_date));  
        $request->due_date = date("d/m/Y", strtotime($request->due_date));  
        
        $transaction_line=[];
        foreach ($request->detail as $key => $value) {
            $product = json_decode($this->client->request(
                'GET',
                'products/'.$value['product']
            )->getBody()->getContents());

            $transaction_line[$key]["quantity"]=$value['quantity'];
            $transaction_line[$key]["product_name"]=$product->product->name;
            $transaction_line[$key]["rate"]=$value['price'];
            $transaction_line[$key]["discount"]=$value['discount'];

        }
        $terms = json_decode($this->client->request(
            'GET',
            'terms/'.$request->terms,
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $response = json_decode($this->client->request(
            'POST',
            'sales_quotes',
            [
                'json' => 
                [
                    "sales_quote" => [
                        "transaction_date" => $request->transaction_date,
                        "transaction_lines_attributes" => $transaction_line,
                        "address"=> $request->address,
                        "term_name"=> $terms->term->name,
                        "due_date"=> $request->due_date,
                        "person_name"=> $request->person_name,
                        "tags"=> [
                            $request->tags
                        ],
                        "email"=> $request->email,
                        "message"=> $request->message,
                        "memo"=> $request->memo
                    ]
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
    }

    public function addNewOrder(Request $request)
    {
        $request->transaction_date = date("d/m/Y", strtotime($request->transaction_date));  
        $request->due_date = date("d/m/Y", strtotime($request->due_date));  
        
        $transaction_line=[];
        foreach ($request->detail as $key => $value) {
            $product = json_decode($this->client->request(
                'GET',
                'products/'.$value['product']
            )->getBody()->getContents());

            $transaction_line[$key]["quantity"]=$value['quantity'];
            $transaction_line[$key]["product_name"]=$product->product->name;
            $transaction_line[$key]["rate"]=$value['price'];
            $transaction_line[$key]["discount"]=$value['discount'];

        }
        $terms = json_decode($this->client->request(
            'GET',
            'terms/'.$request->terms,
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents());
        $response = json_decode($this->client->request(
            'POST',
            'sales_orders',
            [
                'json' => 
                [
                    "sales_order" => [
                        "transaction_date" => $request->transaction_date,
                        "transaction_lines_attributes" => $transaction_line,
                        "address"=> $request->address,
                        "term_name"=> $terms->term->name,
                        "due_date"=> $request->due_date,
                        "person_name"=> $request->person_name,
                        "tags"=> [
                            $request->tags
                        ],
                        "email"=> $request->email,
                        "message"=> $request->message,
                        "memo"=> $request->memo
                    ]
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
    }

    public function getInvoiceDetail($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'sales_invoices/'.$id,
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
    }
    public function getQuoteDetail($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'sales_quotes/'.$id,
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
    }
    public function getOrderDetail($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'sales_orders/'.$id,
            [
                'headers' => 
                [
                    'Authorization' => "Bearer 2525eecbdff140ce99295a30a5fc2714",
                    'apikey' => "3bc2c31b18450ab99112641d257086d2"
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
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
