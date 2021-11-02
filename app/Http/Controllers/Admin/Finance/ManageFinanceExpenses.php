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


class ManageFinanceExpenses extends Controller
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
        $expenses = json_decode($this->client->request(
            'GET',
            'expenses',
            [
                'form_params' => 
                [
                    'page' => 1,
                    'page_size' => 25,
                    'sort_key' => 'transaction_date',
                    'sort_order' => 'asc'
                ]
            ]
        )->getBody()->getContents());

        return view('admin.finance.expenses.index', compact('expenses'));
    }
    public function detail($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'expenses/'.$id
        )->getBody()->getContents())->expense;
        return view('admin.finance.expenses.detail',compact('response'));
    }

    public function add()
    {
        $accounts = json_decode($this->client->request(
            'GET',
            'accounts'
        )->getBody()->getContents());
        $contacts = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":5,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents());
        $payment_methods = json_decode($this->client->request(
            'GET',
            'payment_methods'
        )->getBody()->getContents());
        return view('admin.finance.expenses.add',compact('accounts','contacts','payment_methods'));
    }
    public function addNewExpense(Request $request)
    {
        $request->transaction_date = date("d/m/Y", strtotime($request->transaction_date));  
        
        foreach ($request->transaction_account_lines_attributes as $key => $value) {
            $transaction_line[$key]=$value;
        }
        
        $response = json_decode($this->client->request(
            'POST',
            'expenses',
            [
                'json' => 
                [
                    "expense" => [
                        "transaction_date" => $request->transaction_date,
                        "transaction_account_lines_attributes" => $transaction_line,
                        "transaction_no"=> $request->transaction_no,
                        "address"=> $request->address,
                        "payment_method_name"=> $request->payment_method_name,
                        "payment_method_id"=> $request->payment_method_id,
                        "person_name"=> $request->person_name,
                        "refund_from_name"=> $request->refund_from_name,
                        "memo"=> $request->memo
                    ]
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
