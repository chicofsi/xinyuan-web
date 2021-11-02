<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\Transaction;

class ManageCompany extends Controller
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
            return datatables()->of(Company::select('*')->with('transaction'))
            ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" onClick="editFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                    // $btn = $btn.' <a href="javascript:void(0)" onClick="deleteFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-danger btn-sm">Delete</a>';
                    if($data->active==1){
                        $btn = $btn.' <a href="javascript:void(0)" onClick="toggle('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-warning btn-sm">Active</a>';
                    }else{
                        $btn = $btn.' <a href="javascript:void(0)" onClick="toggle('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-info btn-sm">Deactive</a>';
                    }

                    return $btn;
                })
            ->addColumn('transaction_count', function($data){
                    $transaction=Transaction::where('id_company',$data->id)->get();

                    return $transaction->count();
                })
            ->rawColumns(['action'])
            ->make(true);
        }



        return view('admin.company.index');
        
    }

    public function toggle(Request $request)
    {
        $company=Company::where('id',$request->id)->first();

        if($company->active==1){
            Company::where('id',$request->id)->update(['active'=>0]);
        }else{
            Company::where('id',$request->id)->update(['active'=>1]);
        }
        return $company;
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
        $companyId = $request->id;
 
        $company   =   Company::updateOrCreate(
                    [
                     'id' => $companyId
                    ],
                    [
                    'name' => $request->name,
                    'display_name' => $request->display_name,
                    ]);    
                         
        return Response()->json($company);
        
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
        $company = Company::where($where)->first();
      
        return Response()->json($company);
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
        $company = Company::where('id',$request->id)->first();

        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 10,
        //    'message' => 'Admin deleted a job category named '.$jobCategory->name
        // ]);

        Company::where('id',$request->id)->delete();

        return Response()->json($company);
    }
}
