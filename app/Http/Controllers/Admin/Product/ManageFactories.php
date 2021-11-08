<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Factories;
use App\Helper\JurnalHelper;

class ManageFactories extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->client = JurnalHelper::index();
    }

    public function registerJurnal()
    {
        $factories=Factories::get();

        foreach ($factories as $key => $value) {
            if($value->jurnal_id==null){
                $person=[];

                $person["display_name"]=$value->name;
                $person["is_customer"]=false;
                $person["is_vendor"]=true;
                $person["is_employee"]=false;
                $person["is_others"]=false;

                $contact = json_decode($this->client->request(
                    'POST',
                    'contacts',
                    [
                        'json' => [
                            'person'=>$person
                        ]
                    ]
                )->getBody()->getContents());

                $factory   =   Factories::where('id',$value->id)->update([
                    'jurnal_id'=>$contact->person->id
                ]);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request()->ajax()) {
            return datatables()->of(Factories::select('*')->with('product'))
            ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" onClick="editFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" onClick="deleteFunc('.$data->id.')" data-toggle="tooltip" data-original-title="Delete" class="btn btn-danger btn-sm">Delete</a>';

                    return $btn;
                })
            ->addColumn('product_count', function($data){
                    $productcount=Product::where('id_factories',$data->id)->where('still_available',1)->get()->count();

                    return $productcount;
                })
            
            
            ->rawColumns(['action'])
            ->make(true);
        }



        return view('admin.product.factories');
        
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
        $factoriesId = $request->id;
 
        $factories   =   Factories::updateOrCreate(
                    [
                     'id' => $factoriesId
                    ],
                    [
                    'name' => $request->name, 
                    ]);    
                         
        $person=[];

        $person["display_name"]=$request->name;
        $person["is_customer"]=false;
        $person["is_vendor"]=true;
        $person["is_employee"]=false;
        $person["is_others"]=false;

        $contact = json_decode($this->client->request(
            'POST',
            'contacts',
            [
                'json' => [
                    'person'=>$person
                ]
            ]
        )->getBody()->getContents());

        $factories   =   Factories::where('id',$factories->id)->update([
            'jurnal_id'=>$contact->person->id
        ]);

        return Response()->json($factories);
        
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
        $factories  = Factories::where($where)->first();
      
        return Response()->json($factories);
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

        // AdminLogs::create([
        //    'id_admin' => Auth::id(),
        //    'id_admin_activity' => 10,
        //    'message' => 'Admin deleted a job category named '.$jobCategory->name
        // ]);

        $factories=Factories::where('id',$request->id)->delete();

        return Response()->json($factories);
    }
}
