<?php

namespace App\Http\Controllers\ApiSales\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ValueMessage;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\Factories as FactoriesResource;

use App\Models\Product;
use App\Models\Factories;

class ProductController extends Controller
{
    public function getProduct(Request $request)
    {
    	$product=Product::where('still_available',1)->with('productphoto','factories','logo','colour','type','size','weight','grossweight');

    	if($request->has('id_product')){
    		$product=$product->where('id',$request->id_product);
    	}
    	if($request->has('id_factories')){
    		$product=$product->where('id_factories',$request->id_factories);
    	}

    	$product=$product->get();
    	if($product->isEmpty()){
    		return response()->json(new ValueMessage(['value'=>0,'message'=>'Product Doesn\'t Exist!','data'=> '']), 404);
    	}

    	foreach ($product as $key => $value) {
    		$dataProduct[$key]=new ProductResource($value);
    	}

    	return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Product List Success!','data'=> $dataProduct]), 200);

    }

    public function getFactories(Request $request)
    {
    	$factories=Factories::with('product')->get();

    	if($factories->isEmpty()){
    		return response()->json(new ValueMessage(['value'=>0,'message'=>'Factories Doesn\'t Exist!','data'=> '']), 404);
    	}

    	foreach ($factories as $key => $value) {
    		$dataFactories[$key]=new FactoriesResource($value);
    	}

    	return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Factories List Success!','data'=> $dataFactories]), 200);

    }

    
}
