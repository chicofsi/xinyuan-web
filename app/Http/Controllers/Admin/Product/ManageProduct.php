<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Area;
use App\Models\ProductPhoto;
use App\Models\Factories;
use App\Models\ProductType;
use App\Models\ProductSize;
use App\Models\ProductColour;
use App\Models\ProductLogo;
use App\Models\ProductGrossWeight;
use App\Models\ProductWeight;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\WarehouseProduct;
use App\Models\Warehouse;
use GuzzleHttp\Client;
use App\Helper\JurnalHelper;

class ManageProduct extends Controller
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
        $factories = Factories::all();
        $logos = ProductLogo::all();
        $types = ProductType::all();
        $sizes = ProductSize::all();
        $weights = ProductWeight::all();
        $grossweights = ProductGrossWeight::all();
        $colours = ProductColour::all();

        return view('admin.product.index',compact('factories','logos','types','sizes','colours','weights','grossweights'));
    }

    public function stock()
    {
        $factories = Factories::all();
        $logos = ProductLogo::all();
        $types = ProductType::all();
        $sizes = ProductSize::all();
        $weights = ProductWeight::all();
        $grossweights = ProductGrossWeight::all();
        $colours = ProductColour::all();
        $warehouses = Warehouse::all();
        $area = Area::where('dashboard',1)->get();

        return view('admin.product.stock',compact('factories','logos','types','sizes','colours','weights','grossweights','warehouses','area'));
    }

    public function listStock()
    {
        $product=Product::where('still_available',1)->with('productphoto','factories','size','type','colour','logo','grossweight','weight','warehouseproduct')->get();

        $response = json_decode($this->client->request(
            'GET',
            'products'
        )->getBody()->getContents(),true)['products'];
        if($product->isEmpty()){
            return;
        }else{
            $data="";
            foreach ($product as $key => $value) {
                if($value->productphoto->isEmpty()){
                    $photo= URL::to('storage/product/default.png');
                } else{
                    $value->photo_url=$value->productphoto[0]->photo_url;
                    $photo= URL::to('storage/'.$value->photo_url);
                }
                $qty=0;
                foreach ($value->warehouseproduct as $k => $v) {
                    $qty+=$v->quantity;
                }
                $key = array_search($value->jurnal_id, array_column($response, 'id'));
                $data.= "<tr>
                            <td><img class='img-row' src=".$photo."></span></td>
                            <td>".$value->type->name."</td>
                            <td>".$value->size->width."X".$value->size->height."</td>
                            <td>".$value->colour->name."</td>
                            <td>".$value->logo->name."</td>
                            <td>".$value->factories->name."</td>";
                $area=Area::where('dashboard',1)->with('warehouse')->get();
                foreach ($area as $ke => $val) {
                    $stock=0;
                    foreach ($val->warehouse as $k => $v) {
                        $quantity=WarehouseProduct::where('id_warehouse',$v->id)->where('id_product',$value->id)->first()->quantity;
                        $stock+=$quantity;
                    }
                    $data.="<td>".$stock."</td>";
                }
                $data.="<td>".$qty."</td>";

                
                $data.= "<td><a href='javascript:void(0)' onClick=stock(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";


            }


            $returndata['data']=$data;

            return $returndata;
        }

    }
    public function detailStock(Request $request)
    {
        
        $product  = Product::where('id',$request->id)->with('productphoto','factories','logo','type','size','colour','grossweight','weight','warehouseproduct')->first();
        $response = json_decode($this->client->request(
            'GET',
            'products/'.$product->jurnal_id
        )->getBody()->getContents(),true)['product'];
        $product['jurnal']=$response;

        return Response()->json($product);
    }

    public function storeStock(Request $request)
    {
        $request->date = date("d/m/Y", strtotime($request->date));  
        $product=Product::where('id',$request->id)->first();
        $warehouse=Warehouse::where('id',$request->id_warehouse)->first();
        $transaction_line=[];
        $transaction_line[0]["product_id"]=$product->jurnal_id;
        $transaction_line[0]["actual_quantity"]=$request->actual;
        $transaction_line[0]["difference"]=$request->difference;
        $response = json_decode($this->client->request(
            'POST',
            'stock_adjustments',
            [
                'json' => 
                [
                    "stock_adjustment" => [
                        "account_name"=> "Penyesuaian Persediaan",
                        "stock_adjustment_type"=>'general',
                        "warehouse_id"=> $warehouse->jurnal_id,
                        "date"=> $request->date,
                        "maintain_actual"=> true,
                        "lines_attributes"=> $transaction_line
                    ]
                ]
            ]
        )->getBody()->getContents(),true);

        $warehouseproduct=WarehouseProduct::updateOrCreate(
        [
            "id_warehouse" => $request->id_warehouse,
            "id_product" => $request->id
        ],
        [
            "quantity" => $request->actual
        ]);
        return $response;
    }

    public function list()
    {
        $product=Product::where('still_available',1)->with('productphoto','factories','size','type','colour','logo','grossweight','weight')->get();
        if($product->isEmpty()){
            return;
        }else{
            $data="";
            foreach ($product as $key => $value) {
                if($value->productphoto->isEmpty()){
                    $photo= URL::to('storage/product/default.png');
                } else{
                    $value->photo_url=$value->productphoto[0]->photo_url;
                    $photo= URL::to('storage/'.$value->photo_url);
                }

                $data.= "<tr>
                            <td><img class='img-row' src=".$photo."></span></td>
                            <td>".$value->type->name."</td>
                            <td>".$value->size->width."X".$value->size->height."</td>
                            <td>".$value->weight->weight."</td>
                            <td>".$value->grossweight->gross_weight."</td>
                            <td>".$value->colour->name."</td>
                            <td>".$value->logo->name."</td>
                            <td>".$value->factories->name."</td>
                            <td><a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";


            }

            $filtertype=ProductType::select('name')->get();

            foreach ($filtertype as $key => $value) {
                $type[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='type' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            }

            $filtersize=ProductSize::select('width','height')->get();

            foreach ($filtersize as $key => $value) {
                $size[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='size' value='".$value->width."X".$value->height."' checked><label>".$value->width."X".$value->height."</label></div></div>";
            }

            $filtercolour=ProductColour::select('name')->get();
            if($filtercolour->isEmpty()){
                $colour[0]="No Choice";
            }
            foreach ($filtercolour as $key => $value) {
                $colour[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='colour' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            }

            $filterlogo=ProductLogo::select('name')->get();
            if($filterlogo->isEmpty()){
                $logo[0]="No Choice";
            }
            foreach ($filterlogo as $key => $value) {
                $logo[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='logo' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            }

            $filterfactory=Factories::select('name')->get();

            foreach ($filterfactory as $key => $value) {
                $factory[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='factory' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            }

            $returndata['data']=$data;
            $returndata['types']=$type;
            $returndata['sizes']=$size;
            $returndata['colours']=$colour;
            $returndata['logos']=$logo;
            $returndata['factory']=$factory;

            return $returndata;
        }

    }

    public function addPhoto(Request $request)
    {
        $photo=null;
        if($request->has('photo')){
            $fileName= str_replace(' ','-', $request->id_product.'_'.date('d-m-Y_H-i-s'));

            $guessExtension = $request->file('photo')->guessExtension();

            $file = $request->photo->storeAs('public/product/photo',$fileName.'.'.$guessExtension);
            $photo=substr($file, 7);
            $productphoto=ProductPhoto::create(['id_product'=>$request->id_product,'photo_url'=>$photo]);
            return $productphoto;
        }
    }

    public function addtocart()
    {
        $product=Product::where('still_available',1)->with('productphoto','factories','size','type','colour','logo')->get();
        if($product->isEmpty()){
            return;
        }else{
            $data="";
            foreach ($product as $key => $value) {
                if($value->productphoto->isEmpty()){
                    $photo= URL::to('storage/product/default.png');
                } else{
                    $value->photo_url=$value->productphoto[0]->photo_url;
                    $photo= URL::to('storage/'.$value->photo_url);
                }

                $data.= "<tr>
                            <td>".$value->id."</td>
                            <td><img class='img-row' src=".$photo."></span></td>
                            <td>".$value->type->name."</td>
                            <td>".$value->size->width."X".$value->size->height."</td>
                            <td>".$value->weight->weight."</td>
                            <td>".$value->grossweight->gross_weight."</td>
                            <td>".$value->colour->name."</td>
                            <td>".$value->logo->name."</td>
                            <td>".$value->factories->name."</td>
                            <td><a href='javascript:void(0)' onClick=addproduct(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Add To Cart</a></td>
                        </tr>";


            }

            

            $returndata['data']=$data;

            return $returndata;
        }

    }
    public function getbyid(Request $request)
    {
        $product=Product::where('id',$request->id)->with('productphoto','factories','logo','size','colour','type','weight','grossweight')->first();
        if($product){
            if($product->productphoto->isEmpty()){
                $product->photo= URL::to('storage/product/default.png');
            } else{
                $product->photo_url=$product->productphoto[0]->photo_url;
                $product->photo= URL::to('storage/'.$product->photo_url);
            }
            // $data= "<tr>
            //             <td>".$product->id."</td>
            //             <td><img class='img-row' src=".$photo."></span></td>
            //             <td>".$product->type->name."</td>
            //             <td>".$product->size->width."X".$product->size->height."</td>
            //             <td>".$product->weight->weight."</td>
            //             <td>".$product->grossweight->gross_weight."</td>
            //             <td>".$product->colour->name."</td>
            //             <td>".$product->logo->name."</td>
            //             <td>".$product->factories->name."</td>
            //             <td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct(".$product->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td>
            //             <td id='subtotal'>0</td>
            //         </tr>";

            $returndata['data']=$product;

            return $returndata;
        }
    }


    public function getReturn(Request $request)
    {
        $product=Product::where('id',$request->id)->with('productphoto','factories','logo','size','colour','type')->first();
        if($product){
            if($product->productphoto->isEmpty()){
                $photo= URL::to('storage/product/default.png');
            } else{
                $product->photo_url=$product->productphoto[0]->photo_url;
                $photo= URL::to('storage/'.$product->photo_url);
            }
            $data= "<tr>
                        <td>".$product->id."</td>
                        <td><img class='img-row' src=".$photo."></span></td>
                        <td>".$product->type->name."</td>
                        <td>".$product->size->width."X".$product->size->height."</td>
                        <td>".$product->weight->weight."</td>
                        <td>".$product->grossweight->gross_weight."</td>
                        <td>".$product->colour->name."</td>
                        <td>".$product->logo->name."</td>
                        <td>".$product->factories->name."</td>
                        <td><div class='row'><div class='col-md-12' style='padding:2px'>Max Quantity :<strong id='max-qty'></strong></div></div><div class='row'><div class='col-md-12' style='padding:2px' >Price :<strong id='price'></strong></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' placeholder='Qty' min='0'></div></div></td>
                    </tr>";

            $returndata['data']=$data;

            return $returndata;
        }
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
        $weight=null;
        $grossweight=null;
        $cost=null;

        if($request->has('weight')){
            $weight=$request->weight;
        }

        if($request->has('gross_weight')){
            $grossweight=$request->gross_weight;
        }

        if($request->has('cost') ){
            if($request->cost==null){
                $cost=0;
            }else{
                $cost=$request->cost;
            }
        }


        $product   =   Product::create([
            'id_factories' => $request->id_factories, 
            'id_type' => $request->id_type, 
            'id_size' => $request->id_size, 
            'id_weight' => $request->id_weight,
            'id_gross_weight' => $request->id_gross_weight,
            'id_colour' => $request->id_colour,
            'id_logo' => $request->id_logo,
            'cost' => $cost,
            'still_available' => 1,
            ]);    

        if($request->has('photo')){
            $fileName= str_replace(' ','-', $request->type.'_'.$request->size.'_'.date('d-m-Y_H-i-s'));

            $guessExtension = $request->file('photo')->guessExtension();

            $file = $request->photo->storeAs('public/product/photo',$fileName.'.'.$guessExtension);

            $productphoto=ProductPhoto::create([
                'id_product' => $product->id,
                'photo_url' => substr($file, 7),    
            ]);
        }

        $name= ProductType::where('id',$request->id_type)->first()->name." ".ProductSize::where('id',$request->id_size)->first()->width."X".ProductSize::where('id',$request->id_size)->first()->height." ".Factories::where('id',$request->id_factories)->first()->name." ".ProductColour::where('id',$request->id_colour)->first()->name." ".ProductLogo::where('id',$request->id_logo)->first()->name;
        $is_bought=true;
        $is_sold=true;
        
        $response = json_decode($this->client->request(
            'POST',
            'products',
            [
                'json' => 
                [
                    "product" => [
                        "name"=>$name,
                        "is_bought"=>$is_bought,
                        "is_sold"=>$is_sold,
                        "track_inventory"=> "true",
                        "inventory_asset_account_number"=> "1-10200"
                    ]
                ]
            ]
        )->getBody()->getContents());

       $product   =   Product::where('id',$product->id)->update([
            'jurnal_id' => $response->product->id,
            ]);
        return Response()->json($product);
    
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $product  = Product::where('id',$request->id)->with('productphoto','factories','logo','type','size','colour','grossweight','weight')->first();


        $gallery="";
        // $userLogs = UserLogs::where('id_user',$request->id)->orderBy('created_at','desc')->get();
        if($product->productphoto->isEmpty()){
            $product->photo_url= URL::to('storage/product/default.png');
        } else{
            $product->photo_url=$product->productphoto[0]->photo_url;
            $product->photo_url= URL::to('storage/'.$product->photo_url);

            foreach ($product->productphoto as $key => $value) {
                $gallery=$gallery."<div class='images item ' onClick='imgdetail(".$value->id.")'><img src='".URL::to('storage/'.$value->photo_url)."' alt='' /></div>";
            }
        }

        for ($i=0; $i < 12; $i++) { 
            $sold=TransactionDetails::where('id_product',$request->id)->whereYear('created_at','=',(date('Y',strtotime(date('Y-m').' -'.$i.' month'))))->whereMonth('created_at','=',(date('m',strtotime(date('Y-m').' - '.$i.' month'))))->get();
            $data[$i]["year"]=(date('Y',strtotime(date('Y-m').' -'.$i.' month')));
            $data[$i]["month"]=(date('m',strtotime(date('Y-m').' -'.$i.' month')));
            $data[$i]["sold"]=0;
            if($sold->isEmpty()){
                $data[$i]["sold"]=0;
            }
            foreach ($sold as $key => $value) {
                $data[$i]["sold"]+=$value->quantity;
            }

        }
        $product->chart=$data;
        $product->gallery=$gallery;

        $details=TransactionDetails::select('id_transaction')->where('id_product',$request->id)->get();
        
        $transaction = Transaction::whereIn('id', $details)->with('customer','transactiondetails','sales')->get();

        if($transaction->isEmpty()){
            $product['transactionlist']="EMPTY";
        }else{
            $product['transactionlist']="";
            foreach ($transaction as $key => $value) {
                $product['transactionlist'].= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->invoice_number."</td>
                            <td>".$value->customer->company_name."</td>
                            <td>".$value->sales->name."</td>
                            <td>".$value->date."</td>
                            <td>".$value->total_payment."</td>
                        </tr>";
            }
        }
        

        
        // $user['activity']="";
        // foreach ($userLogs as $key => $value) {
        //     if($value->message==null){
        //         $value->message=UserActivity::where('id',$value->id_user_activity)->first()->default_message;
        //     }
        //     $user['activity']=$user['activity']."<li>
        //                         <div class='avatar'>
        //                             <img style='object-fit: contain;' src='".$user->photo_url."' alt=''/>
        //                         </div>
        //                         <div class='activity-desk'>
        //                             <h5><span>".$value->message."</span></h5>
        //                             <p class='text-muted' >".$value->created_at."</p>
                                    
        //                         </div>
        //                     </li>";
        // }

        // $user['resumecount']=UserDocs::where('id_user',$request->id)->where('id_docs_category',1)->count();
        // $user['portfoliocount']=UserDocs::where('id_user',$request->id)->where('id_docs_category',2)->count();
        // $user['certificatecount']=UserDocs::where('id_user',$request->id)->where('id_docs_category',3)->count();

        // foreach ($company['address'] as $key => $value) {
        //     $company['address'][$key]['city']=City::where('id',$value->id_city)->select('name')->first()->name;
        // }
        // foreach ($company['photo'] as $key => $value) {
        //     $company['photo'][$key]['photo_url']= URL::to('storage/'.$value->photo_url);
        // }
      
        return Response()->json($product);
    }
    public function getPhotoDetail(Request $request)
    {
        $photo=ProductPhoto::where('id',$request->id)->first();

        $photo->photo_url= URL::to('storage/'.$photo->photo_url);
        return $photo;
    }

    public function deletePhoto(Request $request)
    {
        $photo=ProductPhoto::where('id',$request->id_product_photo)->first();
        Storage::disk('public')->delete($photo->photo_url);
        $photo->delete();
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $product = Product::where('id',$request->id_product)->update([
            'id_factories' => $request->id_factories, 
            'id_type' => $request->id_type, 
            'id_size' => $request->id_size, 
            'id_weight' => $request->id_weight,
            'id_gross_weight' => $request->id_gross_weight,
            'id_colour' => $request->id_colour,
            'id_logo' => $request->id_logo,
            'cost' => $request->cost,
        ]);
        $product = Product::where('id',$request->id_product)->first();

        $name= ProductType::where('id',$request->id_type)->first()->name." ".ProductSize::where('id',$request->id_size)->first()->width."X".ProductSize::where('id',$request->id_size)->first()->height." ".Factories::where('id',$request->id_factories)->first()->name." ".ProductColour::where('id',$request->id_colour)->first()->name." ".ProductLogo::where('id',$request->id_logo)->first()->name;
        
        
        $response = json_decode($this->client->request(
            'PATCH',
            'products/'.$product->jurnal_id,
            [
                'json' => 
                [
                    "product" => [
                        "name"=>$name
                    ]
                ]
            ]
        )->getBody()->getContents(),true);

         
      
        return Response()->json($product);
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
        $product = Product::where('id',$request->id)->update([
            'still_available'=>0
        ]);
      
        return Response()->json($product);
    }
}
