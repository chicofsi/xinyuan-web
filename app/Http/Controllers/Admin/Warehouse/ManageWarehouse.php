<?php

namespace App\Http\Controllers\Admin\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\Area;
use App\Models\Product;

use App\Helper\JurnalHelper;

class ManageWarehouse extends Controller
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
    public function index(Request $request)
    {
        $areas = Area::all();


        return view('admin.warehouse.index',compact('areas'));
    }

    public function list(Request $request)
    {
        $warehouse=Warehouse::with('area','warehouseproduct')->get();
        
        if($warehouse->isEmpty()){
            $returndata['data']="<tr>
                                    <td colspan='5'>Not Available</td>
                                </tr>";
            return $returndata;
        }else{
            $data="";
            foreach ($warehouse as $key => $value) {
                $data.= "<tr>
                            <td>".$value->area->name."</td>
                            <td>".$value->name."</td>
                            <td>".$value->address."</td>
                            <td>".$value->capacity."</td>
                            <td><a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";
            }

            $returndata['data']=$data;

            return $returndata;
        }

    }

    public function store(Request $request)
    {
        $warehouse   =   Warehouse::create([
            'id_area' => $request->id_area,
            'name' => $request->name,
            'address' => $request->address,
            'capacity' => $request->capacity,
        ]);    

        $response = json_decode($this->client->request(
            'POST',
            'warehouses',
            [
                'json' => 
                [
                    "warehouse" => [
                        "name"=> $request->name,
                        "address"=> $request->address,
                    ]
                ]
            ]
        )->getBody()->getContents());

       $warehouse   =   Warehouse::where('id',$warehouse->id)->update([
            'jurnal_id' => $response->warehouse->id,
        ]);

        return Response()->json($warehouse);
    }

    public function show(Request $request)
    {
        $warehouse  = Warehouse::where('id',$request->id)->with('warehouseproduct','transaction','area','purchase')->first();

        foreach ($warehouse->warehouseproduct as $key => $value) {
            $product=Product::where('id',$value->id_product)->first();
            $warehouse->warehouseproduct[$key]['product']=$product;
        }

        return Response()->json($warehouse);
    }

    public function destroy(Request $request)
    {
        PurchasePayment::where('id_purchase',$request->id)->delete();
        PurchaseDetails::where('id_purchase',$request->id)->delete();
        $purchase=Purchase::where('id',$request->id)->delete();
        return $purchase;
    }

}
