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

class ManageFinanceContact extends Controller
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
        $customers = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":1,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents())->contact_list->contact_data;

        $vendors = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":2,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents())->contact_list->contact_data;
        $employees = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":3,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents())->contact_list->contact_data;
        $others = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":4,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents())->contact_list->contact_data;
        $all = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":5,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents())->contact_list->contact_data;

        $contact_groups = json_decode($this->client->request(
            'GET',
            'contact_groups'
        )->getBody()->getContents());

        return view('admin.finance.contact.index', compact('customers','vendors','employees','others','all','contact_groups'));

    }

    public function detail($id){
        $response = json_decode($this->client->request(
            'GET',
            'contacts/'.$id
        )->getBody()->getContents())->person;
        $transaction = json_decode($this->client->request(
            'GET',
            'contacts/'.$id.'/transaction_list'
        )->getBody()->getContents())->transaction_data;

        return view('admin.finance.contact.detail',compact('response','transaction'));
    }

    public function invoice($id)
    {
        return view('admin.finance.invoice');
        
    }

    public function getAccount(Request $request)
    {
        $cash = $this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 3
                ]
            ]
        )->getBody()->getContents();

        $credit = $this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 9
                ]
            ]
        )->getBody()->getContents();
        $data['cash']=json_decode($cash,true);
        $data['credit']=json_decode($credit,true);
        return $data;
    }

    
    public function addContact(Request $request)
    {
        $contact = $this->client->request(
            'POST',
            'contacts',
            [
                'json' => [
                    'person'=>json_decode($request->getContent())->person
                ]
            ]
        )->getBody()->getContents();


        
        return json_decode($contact,true);
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
