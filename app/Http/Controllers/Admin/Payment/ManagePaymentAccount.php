<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Auth;

use App\Models\PaymentAccount;
use App\Models\Bank;

use App\Helper\JurnalHelper;

class ManagePaymentAccount extends Controller
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

        if(request()->ajax()) {
            return datatables()->of(PaymentAccount::select('*')->with('bank'))
            ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" onClick="editFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" onClick="deleteFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-danger btn-sm">Delete</a>';

                    return $btn;
                })
            ->rawColumns(['action'])
            ->make(true);
        }
        $banks=Bank::all();

        return view('admin.payment.account',compact('banks'));
        
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accountId = $request->id;
 
        $account   =   PaymentAccount::updateOrCreate(
                    [
                     'id' => $accountId
                    ],
                    [
                    'account_name' => $request->account_name, 
                    'account_number' => $request->account_number, 
                    'id_bank' => $request->id_bank, 
                    ]);    

        if(!$account->wasRecentlyCreated && $account->wasChanged()){
            $cash = $this->client->request(
                'PATCH',
                'accounts/'.$account->jurnal_id,
                [
                    'json' => 
                    [
                        'account' => 
                        [
                            'name' => $request->account_name." ".$request->account_number
                        ]
                    ]
                ]
            )->getBody()->getContents();
        }

        if($account->wasRecentlyCreated){
            $cash = json_decode($this->client->request(
                'POST',
                'accounts',
                [
                    'json' => 
                    [
                        'account' => 
                        [
                            'name' => $request->account_name." ".$request->account_number,
                            'number' => '1-10002'.$account->id,
                            'parent_category_name'=> 'Rekening Bank',
                            'as_a_child'=> true,
                            'category_name' => "Cash & Bank"
                        ]
                    ]
                ]
            )->getBody()->getContents());
            $account   =   PaymentAccount::where('id',$account->id)->update([
                        'jurnal_id' => $cash->account->id, 
                    ]);    
        }

       

        return Response()->json($account);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $account  = PaymentAccount::where($where)->first();

        
        return Response()->json($account);
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
        $account = PaymentAccount::where('id',$request->id)->first();

        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 10,
        //    'message' => 'Admin deleted a job category named '.$jobCategory->name
        // ]);

        PaymentAccount::where('id',$request->id)->delete();

        return Response()->json($account);
    }
}
