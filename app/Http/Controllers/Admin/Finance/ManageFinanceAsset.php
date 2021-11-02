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

class ManageFinanceAsset extends Controller
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
        $assets = json_decode($this->client->request(
            'GET',
            'asset_managements',
            [
                'form_params' => [
                    'status' => "pending"
                ]
            ]
        )->getBody()->getContents(), true);

        
        $activeassets = json_decode($this->client->request(
            'GET',
            'asset_managements',
            [
                'form_params' => [
                    'status' => "active"
                ]
            ]
        )->getBody()->getContents(), true);
        
        $soldassets = json_decode($this->client->request(
            'GET',
            'asset_managements',
            [
                'form_params' => [
                    'status' => "disposed"
                ]
            ]
        )->getBody()->getContents(), true);
        

        $depreciationassets = json_decode($this->client->request(
            'GET',
            'asset_managements/depreciation_schedules'
        )->getBody()->getContents(), true);
        
        $assets = $assets['assets'];
        $activeassets = $activeassets['assets'];
        $soldassets = $soldassets['assets'];
        $depreciationassets = $depreciationassets['assets'];
        $accounts=PaymentAccount::all();
        
        return view('admin.finance.asset.index', compact('assets', 'activeassets', 'soldassets', 'depreciationassets','accounts'));
    }
    
    public function revert_depreciation($id)
    {
        //revert_depreciation/
        $response = $this->client->request(
            'POST',
            'asset_managements/revert_depreciation/'.$id
        );

        return redirect('/');
    }

    public function dispose(Request $request){
        $asset['disposal_date']=date("d/m/Y", strtotime($request->date));
        $asset['sale_price']=$request->sale_price;
        $asset['deposit_to_account_id']=$request->account;
        $response = $this->client->request(
            'POST',
            'asset_managements/create_dispose/'.$request->id,
            [
                'json' => 
                [
                    "asset"=>$asset
                ]
            ]
        );

        return redirect('/');
    }

    /*
    public function record_new(Request $request){
        $request->validate([
            'name' => 'required',
            'acquistion_date' => 'required',
            'acquisition_cost' => 'required'
        ]);

    }
    */

    public function record(Request $request){
        $data['date'] = date("d/m/Y", strtotime($request->acquisition_date));  
        $data['as_at_date'] = date("d/m/Y", strtotime($request->as_at_date));  
        //dd($request);
        if($request->depreciation=='true'){
            $depreciation=false;
        }else{
            $depreciation=true;
        }
        $asset=[
            "name" => $request->asset_name,
            "asset_number" => $request->asset_number,
            "description"=> $request->description,
            "acquisition_date"=> $data['date'],
            "acquisition_cost"=> $request->cost,
            "asset_account_name"=> $request->fixed_asset,
            "credited_account_id"=> $request->account_credited,
            "non_depreceable"=> $depreciation
        ];
        if(!$depreciation){
            $asset["depreciation_method"]=$request->method;
            $asset["useful_life"]= $request->years;
            $asset["rate"]= $request->rate;
            $asset["depreciation_account_id"]= $request->dep_account;
            $asset["depreciation_and_amortization_account_id"]= $request->acc_dep_account;
            $asset["initial_depreciation"]= $request->acc_dep;
            $asset["initial_depreciation_asset_date"]= $data['as_at_date'];
            // return $asset["acquisition_date"]." ".$asset["initial_depreciation_asset_date"];
        }


        $response = json_decode($this->client->request(
            'POST',
            'asset_managements',
            [
                'json' => 
                [
                    "asset"=>$asset
                ]
            ]
        )->getBody()->getContents(),true);


        return $response;
    }

    public function add_new(Request $request){
        $input = $request->all();



        $fixedaccounts = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => [
                    'category_id' => "5"
                ]
            ]
        )->getBody()->getContents());

        $accounts = json_decode($this->client->request(
            'GET',
            'accounts'
        )->getBody()->getContents());

        $accdep_accounts = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "7"
                ]
            ]
        )->getBody()->getContents());

        $expenses = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "16"
                ]
            ]
        )->getBody()->getContents());
        $otherexpenses = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "17"
                ]
            ]
        )->getBody()->getContents());
        $costofsales = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "15"
                ]
            ]
        )->getBody()->getContents());

        return view('admin.finance.asset.add', compact('fixedaccounts', 'accounts', 'accdep_accounts', 'expenses', 'otherexpenses', 'costofsales'));
    }
    public function edit($id){
        $asset = json_decode($this->client->request(
            'GET',
            'asset_managements/'.$id
        )->getBody()->getContents())->asset;

        $fixedaccounts = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' => [
                    'category_id' => "5"
                ]
            ]
        )->getBody()->getContents());

        $accounts = json_decode($this->client->request(
            'GET',
            'accounts'
        )->getBody()->getContents());

        $accdep_accounts = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "7"
                ]
            ]
        )->getBody()->getContents());

        $expenses = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "16"
                ]
            ]
        )->getBody()->getContents());
        $otherexpenses = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "17"
                ]
            ]
        )->getBody()->getContents());
        $costofsales = json_decode($this->client->request(
            'GET',
            'accounts',
            [
                'form_params' =>
                [
                    'category_id' => "15"
                ]
            ]
        )->getBody()->getContents());

        return view('admin.finance.asset.add', compact('asset','fixedaccounts', 'accounts', 'accdep_accounts', 'expenses', 'otherexpenses', 'costofsales'));
    }
    public function edit_data(Request $request){
        $data['date'] = date("d/m/Y", strtotime($request->acquisition_date));  
        $data['as_at_date'] = date("d/m/Y", strtotime($request->as_at_date));  
        //dd($request);
        if($request->depreciation=='true'){
            $depreciation=false;
        }else{
            $depreciation=true;
        }
        $asset=[
            "name" => $request->asset_name,
            "asset_number" => $request->asset_number,
            "description"=> $request->description,
            "acquisition_date"=> $data['date'],
            "acquisition_cost"=> $request->cost,
            "asset_account_name"=> $request->fixed_asset,
            "credited_account_id"=> $request->account_credited,
            "non_depreceable"=> $depreciation
        ];
        if(!$depreciation){
            $asset["depreciation_method"]=$request->method;
            $asset["useful_life"]= $request->years;
            $asset["rate"]= $request->rate;
            $asset["depreciation_account_id"]= $request->dep_account;
            $asset["depreciation_and_amortization_account_id"]= $request->acc_dep_account;
            $asset["initial_depreciation"]= $request->acc_dep;
            $asset["initial_depreciation_asset_date"]= $data['as_at_date'];
            // return $asset["acquisition_date"]." ".$asset["initial_depreciation_asset_date"];
        }


        $response = json_decode($this->client->request(
            'PATCH',
            'asset_managements/'.$request->id,
            [
                'json' => 
                [
                    "asset"=>$asset
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
    public function destroy($id)
    {
        $response = $this->client->request(
            'DELETE',
            'asset_managements/'.$id
        );

        return redirect('/');
    }
}
