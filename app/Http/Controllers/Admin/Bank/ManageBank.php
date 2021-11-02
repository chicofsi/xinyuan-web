<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Auth;

use App\Models\Bank;
use App\Models\PaymentAccount;
use App\Models\TransactionPayment;

class ManageBank extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request()->ajax()) {
            return datatables()->of(Bank::select('*')->with('paymentaccount'))
            ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" onClick="editFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" onClick="deleteFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-danger btn-sm">Delete</a>';

                    return $btn;
                })
            ->addColumn('payment_account_count', function($data){
                    $pa=PaymentAccount::where('id_bank',$data->id)->get();

                    return $pa->count();
                })
            
            ->rawColumns(['action'])
            ->make(true);
        }



        return view('admin.bank.index');
        
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
        $bankId = $request->id;
 
        $bank   =   Bank::updateOrCreate(
                    [
                     'id' => $bankId
                    ],
                    [
                    'name' => $request->name, 
                    ]);    
                         
        return Response()->json($bank);
        
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
        $bank  = Bank::where($where)->first();
      
        return Response()->json($bank);
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
        $bank = Bank::where('id',$request->id)->first();

        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 10,
        //    'message' => 'Admin deleted a job category named '.$jobCategory->name
        // ]);

        Bank::where('id',$request->id)->delete();

        return Response()->json($bank);
    }
}
