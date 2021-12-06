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

class ManageFinance extends Controller
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
        return view('admin.finance.index');
    }
    public function detail($id)
    {
        $response = json_decode($this->client->request(
            'GET',
            'accounts/'.$id
        )->getBody()->getContents());
        $bs = json_decode($this->client->request(
            'GET',
            'accounts/'.$id.'/bank_statements',
            [
                'query' => [
                    'start_date' => '2021-01-01',
                    'end_date' => '2021-12-31'
                 ]
            ]
        )->getBody()->getContents());
        return view('admin.finance.detail',compact('response','bs'));
    }
    public function invoice($id)
    {
        return view('admin.finance.invoice');
        
    }
    public function terms($id)
    {
        $terms = json_decode($this->client->request(
            'GET',
            'terms/'.$id
        )->getBody()->getContents(),true);
        return $terms;
    }
    public function termsList()
    {
        $terms = $this->client->request(
            'GET',
            'terms'
        )->getBody()->getContents();
        return $terms;
    }

    public function unitsList()
    {
        $unit = $this->client->request(
            'GET',
            'product_units'
        )->getBody()->getContents();
        return $unit;
    }
    public function taxes($id)
    {
        $taxes = json_decode($this->client->request(
            'GET',
            'taxes/'.$id
        )->getBody()->getContents(),true);
        return $taxes;
    }
    public function taxesList()
    {
        $taxes = json_decode($this->client->request(
            'GET',
            'taxes'
        )->getBody()->getContents(),true);
        return $taxes;
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
    public function getExpenseAccount(Request $request)
    {
        $a = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 16
                ]
            ]
        )->getBody()->getContents(),true);
        $b = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 17
                ]
            ]
        )->getBody()->getContents(),true);

        $c = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 15
                ]
            ]
        )->getBody()->getContents(),true);

        $data['expense']=$a;
        $data['cost']=$c;
        $data['other']=$b;

        return $data;
    }
    
    public function addAccount(Request $request)
    {
        $cash = $this->client->request(
            'POST',
            'accounts',
            [
                'json' => 
                [
                    'account' => 
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'number' => $request->number,
                        'category_name' => $request->category_name
                    ]
                ]
            ]
        )->getBody()->getContents();

        
        return json_decode($cash,true);
    }

    public function bankTransfer(Request $request)
    {
        $cash = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 3
                ]
            ]
        )->getBody()->getContents());

        $credit = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 9
                ]
            ]
        )->getBody()->getContents());

        return view('admin.finance.banktransfer', compact('cash','credit'));
    }
    public function addBankTransfer(Request $request)
    {
        if($request->from == $request->to || $request->amount<=0){
            $error="Transfer amount Should not be empty or zero, Deposit to (Not allowed to transfer to the same account.)";
            return redirect()->back()->withErrors( $error);
        }else{
            $from=json_decode($this->client->request(
                'get',
                'accounts/'.$request->from
            )->getBody()->getContents());

            $to=json_decode($this->client->request(
                'get',
                'accounts/'.$request->to
            )->getBody()->getContents());
            $transaction_no=null;
            $memo=null;
            if ($request->has('transaction_no')) {
                $transaction_no=$request->transaction_no;
            }
            if ($request->has('memo')) {
                $memo=$request->memo;
            }

            $request->transaction_date = date("d/m/Y", strtotime($request->transaction_date));  
            $response= json_decode($this->client->request(
                'POST',
                'bank_transfers',
                [
                    'json' => 
                    [
                        'bank_transfer' => 
                        [
                            'refund_from_name' => $from->account->name,
                            'deposit_to_name'=> $to->account->name,
                            'transaction_date'=> $request->transaction_date,
                            'transaction_no'=> $transaction_no,
                            'memo'=> $memo,
                            'transfer_amount'=> $request->amount
                        ]
                    ]
                ]
            )->getBody()->getContents());

            return redirect('dashboard/finance');
        }

    }

    public function receiveMoney(Request $request)
    {
        $cash = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 3
                ]
            ]
        )->getBody()->getContents());

        $credit = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => 9
                ]
            ]
        )->getBody()->getContents());

        $contacts = json_decode($this->client->request(
            'GET',
            'contacts',
            [
                'query' => [
                    'contact_index' => '{"curr_page":1,"selected_tab":5,"sort_asc":true,"show_archive":false}'
                ]
            ]
        )->getBody()->getContents())->contact_list->contact_data;

        return view('admin.finance.receivemoney', compact('cash','credit','contacts'));

    }
    public function addReceiveMoney(Request $request)
    {
        if($request->from == $request->to || $request->amount<=0){
            $error="Transfer amount Should not be empty or zero, Deposit to (Not allowed to transfer to the same account.)";
            return redirect()->back()->withErrors( $error);
        }else{
            $from=json_decode($this->client->request(
                'get',
                'accounts/'.$request->from
            )->getBody()->getContents());

            $to=json_decode($this->client->request(
                'get',
                'accounts/'.$request->to
            )->getBody()->getContents());
            $transaction_no=null;
            $memo=null;
            if ($request->has('memo')) {
                $memo=$request->memo;
            }

            $request->transaction_date = date("d/m/Y", strtotime($request->transaction_date));  
            $response= json_decode($this->client->request(
                'POST',
                'bank_deposits',
                [
                    'json' => 
                    [
                        'bank_deposit' => 
                        [
                            'person_name' => $from->account->name,
                            'deposit_to_name'=> $to->account->name,
                            'transaction_date'=> $request->transaction_date,
                            'memo'=> $memo,
                            'transaction_account_lines_attributes'=> $data_lines
                        ]
                    ]
                ]
            )->getBody()->getContents());

            return redirect('dashboard/finance');
        }

    }
    public function chartAccount()
    {

        return view('admin.finance.chart');

    }

    public function chartAccountCategory($id)
    {

        return view('admin.finance.chart',compact('id'));

    }
    public function getAccountAll()
    {
        $accounts = json_decode($this->client->request(
            'GET',
            'accounts'
        )->getBody()->getContents(),true);
        return $accounts;
    }

    public function getAccountByCategory($id)
    {
        $accounts = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => 
                [
                    'category_id' => $id
                ]
            ]
        )->getBody()->getContents(),true);
        return $accounts;
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
