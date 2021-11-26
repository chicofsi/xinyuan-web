<?php

namespace App\Http\Controllers\ApiSales\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ValueMessage;
use Illuminate\Support\Facades\Validator;

use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\Area;
use App\Models\Product;

use App\Helper\JurnalHelper;

use App\Http\Resources\Warehouse as WarehouseResource;

class WarehouseController extends Controller
{
    public function warehouseList(Request $request)
    {
        $warehouse=Warehouse::with('area')->get();

        foreach ($warehouse as $key => $value) {
            $dataWarehouses[$key]=new WarehouseResource($value);
        }

        return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Warehouse List Success!','data'=> $dataWarehouses]), 200);
    }

}
