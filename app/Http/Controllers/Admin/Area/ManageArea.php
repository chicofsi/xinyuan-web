<?php

namespace App\Http\Controllers\Admin\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Auth;

use App\Models\Area;
use App\Models\Sales;
use App\Models\Customer;

class ManageArea extends Controller
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
            return datatables()->of(Area::select('*')->with('sales','customer'))
            ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" onClick="editFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" onClick="deleteFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-danger btn-sm">Delete</a>';
                    if($data->dashboard==1){
                        $btn = $btn.' <a href="javascript:void(0)" onClick="toggleDashboard('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-warning btn-sm">Hide on Dashboard</a>';
                    }else{
                        $btn = $btn.' <a href="javascript:void(0)" onClick="toggleDashboard('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-info btn-sm">Show on Dashboard</a>';
                    }

                    return $btn;
                })
            ->addColumn('area_sales_count', function($data){
                    $sales=Sales::where('id_area',$data->id)->where('active','active')->get();

                    return $sales->count();
                })
            ->addColumn('area_customer_count', function($data){

                    $customer=Customer::where('id_area',$data->id)->get();

                    return $customer->count();
                })
            
            ->rawColumns(['action'])
            ->make(true);
        }



        return view('admin.area.index');
        
    }

    public function toggleDashboard(Request $request)
    {
        $area=Area::where('id',$request->id)->first();

        if($area->dashboard==1){
            Area::where('id',$request->id)->update(['dashboard'=>0]);
        }else{
            Area::where('id',$request->id)->update(['dashboard'=>1]);
        }
        return $area;
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
        $areaId = $request->id;
 
        $area   =   Area::updateOrCreate(
                    [
                     'id' => $areaId
                    ],
                    [
                    'name' => $request->name, 
                    ]);    
                         
        return Response()->json($area);
        
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
        $area  = Area::where($where)->first();
      
        return Response()->json($area);
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
        $area = Area::where('id',$request->id)->first();

        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 10,
        //    'message' => 'Admin deleted a job category named '.$jobCategory->name
        // ]);

        Area::where('id',$request->id)->delete();

        return Response()->json($area);
    }
}
