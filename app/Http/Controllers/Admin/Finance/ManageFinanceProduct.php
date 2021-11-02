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

class ManageFinanceProduct extends Controller
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
        $products = json_decode($this->client->request(
            'GET',
            'products',
            [
                'form_params' => 
                [
                    'page' => 1,
                    'page_size' => 25
                ]
            ]
        )->getBody()->getContents());

        $stockadjustments = json_decode($this->client->request(
            'GET',
            'stock_adjustments',
            [
                'form_params' => 
                [
                    'page' => 1,
                    'page_size' => 25
                ]
            ]
        )->getBody()->getContents());
        
        $warehouses = json_decode($this->client->request(
            'GET',
            'warehouses',
            [
                'form_params' => 
                [
                    'page' => 1,
                    'page_size' => 25
                ]
            ]
        )->getBody()->getContents());
        
        $warehousetransfers = json_decode($this->client->request(
            'GET',
            'warehouse_transfers',
            [
                'form_params' => 
                [
                    'page' => 1,
                    'page_size' => 25
                ]
            ]
        )->getBody()->getContents());

        $units = json_decode($this->client->request(
            'GET',
            'product_units'
        )->getBody()->getContents());

        $buyaccountfix = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 5
                ]
            ]
        )->getBody()->getContents());
        $buyaccountcost = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 15
                ]
            ]
        )->getBody()->getContents());

        $sellaccountincome = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 13
                ]
            ]
        )->getBody()->getContents());

        $sellaccountother = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 14
                ]
            ]
        )->getBody()->getContents());


        $sellaccountar = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 1
                ]
            ]
        )->getBody()->getContents());


        $taxes = json_decode($this->client->request(
            'GET',
            'taxes'
        )->getBody()->getContents());

        return view('admin.finance.product.index', compact('products','warehouses','stockadjustments','warehousetransfers','units','buyaccountcost','buyaccountfix','taxes','sellaccountar','sellaccountother','sellaccountincome'));
    }
    public function addNewProduct(Request $request)
    {
        if($request->sell_tax_id==""){
            $taxable_sell=false;
        }else{
            $taxable_sell=true;
        }

        if($request->buy_tax_id==""){
            $taxable_buy=false;
        }else{
            $taxable_buy=true;
        }
        if($request->is_bought==true){
            $is_bought=true;
        }else{
            $is_bought=false;

        }
        if($request->is_sold==true){
            $is_sold=true;
        }else{
            $is_sold=false;

        }
        
        $response = json_decode($this->client->request(
            'POST',
            'products',
            [
                'json' => 
                [
                    "product" => [
                        "name"=>$request->name,
                        "description"=>$request->description,
                        "is_bought"=>$is_bought,
                        "is_sold"=>$is_sold,
                        "unit_name"=>$request->unit_name,
                        "product_code"=>$request->product_code,
                        "buy_account_number"=>$request->buy_account_number,
                        "taxable_buy"=>$taxable_buy,
                        "buy_tax_id"=>$request->buy_tax_id,
                        "buy_price_per_unit"=>$request->buy_price_per_unit,
                        "sell_account_number"=>$request->sell_account_number,
                        "taxable_sell"=>$taxable_sell,
                        "sell_tax_id"=>$request->sell_tax_id,
                        "sell_price_per_unit"=>$request->sell_price_per_unit
                    ]
                ]
            ]
        )->getBody()->getContents(),true);
        return $response;
    }
    public function getData($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'products/'.$id
        )->getBody()->getContents(),true);
        return $response;
    }
    public function getUnits($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'products/'.$id.'/unit_conversions'
        )->getBody()->getContents(),true);
        return $response;
    }
    public function list()
    {
        $response = json_decode($this->client->request(
            'GET',
            'products'
        )->getBody()->getContents(),true);
        return $response;
    }

    public function detail($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'products/'.$id
        )->getBody()->getContents())->product;
        $transaction = json_decode($this->client->request(
            'GET',
            'products/'.$id.'/transaction_info'
        )->getBody()->getContents())->product;
        return view('admin.finance.product.detail', compact('response','transaction'));
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
