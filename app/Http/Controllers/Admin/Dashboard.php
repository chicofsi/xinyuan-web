<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\Customer;
use App\Models\Area;
use App\Models\Product;
use App\Models\Sales;
use App\Models\ProductPhoto;
use App\Models\Factories;
use App\Models\Announcement;

class Dashboard extends Controller
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
        $datacount=[];
        $datacount['salescount'] = Sales::get()->count();
        $datacount['transactionmonthly'] = Transaction::whereMonth('date','=',date('m'))->get()->count();
        $datacount['customermonthly'] = Customer::whereMonth('created_at','=',date('m'))->get()->count();

        $transaction=Transaction::whereMonth('date','=',date('m'))->with('transactiondetails','transactionpayment','transactionrefund')->get();
        $income=0;
        $accountsreceivable=0;
        foreach ($transaction as $key => $value) {
            $income+=intval($value->total_payment);
            $refund=0;
            foreach ($value->transactionrefund as $key => $ref) {
                $refund+=$ref->total_cashback;
            }
            $accountsreceivable+=intval($value->total_payment)-intval($value->paid)-$refund;
            
        }
        $datacount['incomemonthly'] = $income;
        $datacount['accountsreceivablemonthly'] = $accountsreceivable;


        $transaction=Transaction::with('transactiondetails','transactionpayment','transactionrefund')->get();
        $accountsreceivable=0;
        foreach ($transaction as $key => $value) {
            $refund=0;
            foreach ($value->transactionrefund as $key => $ref) {
                $refund+=$ref->total_cashback;
            }
            $accountsreceivable+=intval($value->total_payment)-intval($value->paid)-$refund;
        }
        $datacount['accountsreceivable'] = $accountsreceivable;

        $areas = Area::all();
        $announcement = Announcement::first();
        
        

        

        return view('admin.dashboard',compact('datacount','areas','announcement'));
        
    }

    public function showAnnouncement(Request $request)
    {
        $announcement=Announcement::where('id',$request->id)->first();

        return $announcement;
    }
    public function storeAnnouncement(Request $request)
    {
        $announcementId = $request->id;
 
        $announcement   =   Announcement::updateOrCreate(
                    [
                     'id' => $announcementId
                    ],
                    [
                    'message' => $request->message, 
                    ]);    
                         
        return Response()->json($announcement);
        
    }

    public function getTables(Request $request)
    {
        $receivableall=0;
        $maturedall=0;
        $todaybillall=0;
        $todaysellingall=0;
        $billall=0;
        $sellall=0;

        $area=Area::where('dashboard',1)->get();
        $table="";
        foreach ($area as $key => $value) {
            $receivablesub=0;
            $maturedsub=0;
            $todaybillsub=0;
            $todaysellingsub=0;
            $billsub=0;
            $sellsub=0;
            $factory=Factories::all();
            $table.="<tr><td rowspan='".($factory->count()+1)."'>".$value->name."</td>";
            foreach ($factory as $k => $v) {
                $table.="<td>".$v->name."</td>";
                if($request->nice!=2){
                    $one=DB::select( DB::raw("select transaction.total_payment as total_payment, transaction.paid as paid, transaction.total_payment-transaction.paid as receivable from transaction  join transaction_details on transaction.id=transaction_details.id_transaction join product  on transaction_details.id_product=product.id where product.id_factories=:idfactories AND transaction.id in (select transaction.id from transaction join customer on transaction.id_customer=customer.id join customer_level on customer.id_level=customer_level.id where customer.id_area=:idarea and customer_level.nice=:nice ) GROUP by transaction.id"), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                       'nice' => $request->nice,
                     ));
                    
                    $two=DB::select( DB::raw("select t.total_payment as total_payment, t.paid, t.total_payment-t.paid as debt from transaction t join transaction_details td on t.id=td.id_transaction join product p on td.id_product=p.id where p.id_factories=:idfactories and t.payment_deadline<curdate() and (t.total_payment-t.paid)>0 AND t.id in (select t.id from transaction t join customer c on t.id_customer=c.id join customer_level cl on c.id_level=cl.id where c.id_area=:idarea and cl.nice=:nice) GROUP by t.id"), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                       'nice' => $request->nice,
                     ));

                    $three=DB::select( DB::raw("select t.total_payment as total_payment from transaction t join transaction_details td on t.id=td.id_transaction join product p on td.id_product=p.id where p.id_factories=:idfactories and date(t.date)=curdate() and t.id in (select t.id from transaction t join customer c on t.id_customer=c.id join customer_level cl on c.id_level=cl.id where c.id_area=:idarea and cl.nice=:nice) GROUP by t.id"), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                       'nice' => $request->nice,
                     ));

                    $four=DB::select( DB::raw("select tp.paid as paid from transaction_payment tp join transaction t on tp.id_transaction=t.id where date(tp.date)=curdate() and t.id in (select td.id_transaction from transaction_details td join product p on td.id_product=p.id where p.id_factories=:idfactories) and t.id in (select t.id from transaction t join customer c on t.id_customer=c.id join customer_level cl on c.id_level=cl.id where c.id_area=:idarea and cl.nice=:nice) "), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                       'nice' => $request->nice,
                     ));
                }else{
                    $one=DB::select( DB::raw("select transaction.total_payment as total_payment, transaction.paid as paid, transaction.total_payment-transaction.paid as receivable from transaction  join transaction_details on transaction.id=transaction_details.id_transaction join product  on transaction_details.id_product=product.id where product.id_factories=:idfactories AND transaction.id in (select transaction.id from transaction join customer on transaction.id_customer=customer.id where customer.id_area=:idarea) GROUP by transaction.id"), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                     ));
                    
                    $two=DB::select( DB::raw("select t.total_payment as total_payment, t.paid, t.total_payment-t.paid as debt from transaction t join transaction_details td on t.id=td.id_transaction join product p on td.id_product=p.id where p.id_factories=:idfactories and t.payment_deadline<curdate() and (t.total_payment-t.paid)>0 AND t.id in (select t.id from transaction t join customer c on t.id_customer=c.id where c.id_area=:idarea) GROUP by t.id"), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                     ));

                    $three=DB::select( DB::raw("select t.total_payment as total_payment from transaction t join transaction_details td on t.id=td.id_transaction join product p on td.id_product=p.id where p.id_factories=:idfactories and date(t.date)=curdate() and t.id in (select t.id from transaction t join customer c on t.id_customer=c.id where c.id_area=:idarea) GROUP by t.id"), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                     ));

                    $four=DB::select( DB::raw("select tp.paid as paid from transaction_payment tp join transaction t on tp.id_transaction=t.id where date(tp.date)=curdate() and t.id in (select td.id_transaction from transaction_details td join product p on td.id_product=p.id where p.id_factories=:idfactories) and t.id in (select t.id from transaction t join customer c on t.id_customer=c.id where c.id_area=:idarea) "), array(
                       'idfactories' => $v->id,
                       'idarea' => $value->id,
                     ));
                }
                


                $receivable=0;
                $selling=0;
                $bills=0;
                foreach ($one as $ke => $va) {
                    $receivable+=$va->receivable;
                    $selling+=$va->total_payment;
                    $bills+=$va->paid;
                }
                $matured=0;
                foreach ($two as $ke => $va) {
                    $matured+=$va->debt;
                }
                $todayselling=0;
                foreach ($three as $ke => $va) {
                    $todayselling+=$va->total_payment;
                }
                $todaybilling=0;
                foreach ($four as $ke => $va) {
                    $todaybilling+=$va->paid;
                }


                $receivableall+=$receivable;
                $maturedall+=$matured;
                $todaysellingall+=$todayselling;
                $todaybillall+=$todaybilling;
                $billall+=$bills;
                $sellall+=$selling;

                $receivablesub+=$receivable;
                $maturedsub+=$matured;
                $todaysellingsub+=$todayselling;
                $todaybillsub+=$todaybilling;
                $billsub+=$bills;
                $sellsub+=$selling;
                $receivable=number_format(intval($receivable), 0, ',', ',');
                $matured=number_format(intval($matured), 0, ',', ',');
                $todaybilling=number_format(intval($todaybilling), 0, ',', ',');
                $todayselling=number_format(intval($todayselling), 0, ',', ',');
                $bills=number_format(intval($bills), 0, ',', ',');
                $selling=number_format(intval($selling), 0, ',', ',');

                $table.="<td class='text-right'>".$receivable."</td>";
                $table.="<td class='text-right'>".$matured."</td>";
                $table.="<td class='text-right'>".$todaybilling."</td>";
                $table.="<td class='text-right'>".$todayselling."</td>";
                $table.="<td class='text-right'>".$bills."</td>";
                $table.="<td class='text-right'>".$selling."</td>";

                $table.="</tr>";

                
            }

            $receivablesub=number_format(intval($receivablesub), 0, ',', ',');
            $maturedsub=number_format(intval($maturedsub), 0, ',', ',');
            $todaybillsub=number_format(intval($todaybillsub), 0, ',', ',');
            $todaysellingsub=number_format(intval($todaysellingsub), 0, ',', ',');
            $billsub=number_format(intval($billsub), 0, ',', ',');
            $sellsub=number_format(intval($sellsub), 0, ',', ',');

            $table.="<td style='background: #5ab6df;color: #ffffff'>Total</td>";
            $table.="<td style='background: #5ab6df;color: #ffffff' class='text-right'>".$receivablesub."</td>";
            $table.="<td style='background: #5ab6df;color: #ffffff' class='text-right'>".$maturedsub."</td>";
            $table.="<td style='background: #5ab6df;color: #ffffff' class='text-right'>".$todaybillsub."</td>";
            $table.="<td style='background: #5ab6df;color: #ffffff' class='text-right'>".$todaysellingsub."</td>";
            $table.="<td style='background: #5ab6df;color: #ffffff' class='text-right'>".$billsub."</td>";
            $table.="<td style='background: #5ab6df;color: #ffffff' class='text-right'>".$sellsub."</td>";

            $table.="</tr>";
        }

        $sales=Sales::where('active','active')->get()->take(5);
        if(!Auth::guard('web')->check()){
            $sales=Sales::where('id',Auth::id())->get();
        }
        $datasales="";
        foreach ($sales as $key => $value) {
            if($value->photo_url==null){
                $photo="sales/default.png";
            }else{
                $photo=$value->photo_url;
            }
            
            $photo_url= URL::to('storage/'.$photo);

            $transaction=Transaction::where('id_sales',$value->id)->whereMonth('date','=',(date('m',strtotime(date('Y-m')))))->with('transactionpayment')->get();

            $sell=0;
            $bill=0;
            if(!$transaction->isEmpty()){
                foreach ($transaction as $key => $val) {
                    $sell+=$val->total_payment;
                    foreach ($val->transactionpayment as $key => $v) {
                        $bill+=$v->paid;
                    }
                }
            }
            $widthsales=(($sell/$value->target->sales_target)*100);
            if($widthsales>100){
                $widthsales=100;
            }
            $widthbill=(($bill/$value->target->billing_target)*100);
            if($widthbill>100){
                $widthbill=100;
            }

            $statsales="progress-bar-danger";
            if($widthsales==0){
                $statsales="progress-bar-danger";
            }else if($widthsales<=50){
                $statsales="progress-bar-warning";
            }else if($widthsales<100){
                $statsales="progress-bar-info";
            }else if($widthsales>=100){
                $statsales="progress-bar-success";
            }
            $statbill="progress-bar-danger";
            if($widthbill==0){
                $statbill="progress-bar-danger";
            }else if($widthbill<=50){
                $statbill="progress-bar-warning";
            }else if($widthbill<100){
                $statbill="progress-bar-info";
            }else if($widthbill>=100){
                $statbill="progress-bar-success";
            }
            $widthsales=round($widthsales);
            $widthbill=round($widthbill);

            $datasales.="<li>
                            <div class='prog-avatar'>
                                <img src='".$photo_url."' style='object-fit:cover;height:100%'>
                            </div>
                            <div class='details'>
                                <div class='title'><strong>".$value->name."</strong><br>selling target: ".$value->target->sales_target." - billing target: ".$value->target->billing_target." </div>
                                <div class='progress progress-striped' style='width:100%;margin:1px'>
                                    <div class='progress-bar ".$statsales."' role='progressbar' aria-valuenow='".$sell."' aria-valuemin='0' aria-valuemax=".$value->target->sales_target." style='width: ".$widthsales."%'>
                                        <span>".$widthsales."%</span>
                                    </div>
                                </div>
                                <div class='progress progress-striped' style='width:100%;margin:1px'>
                                    <div class='progress-bar ".$statbill."' role='progressbar' aria-valuenow='".$bill."' aria-valuemin='0' aria-valuemax=".$value->target->billing_target." style='width: ".$widthbill."%'>
                                        <span>".$widthbill."%</span>
                                    </div>
                                </div>
                            </div>
                        </li>";
        }
        $returndata['goal']=$datasales;


        for ($i=0; $i < 12; $i++) { 
            $transaction=Transaction::whereYear('date','=',(date('Y',strtotime(date('Y-m').' -'.$i.' month'))))->whereMonth('date','=',(date('m',strtotime(date('Y-m').' - '.$i.' month'))))->get();
            $data[$i]["year"]=(date('Y',strtotime(date('Y-m').' -'.$i.' month')));
            $data[$i]["month"]=(date('m',strtotime(date('Y-m').' -'.$i.' month')));

            $data[$i]["selling"]=0;
            if(!$transaction->isEmpty()){
                foreach ($transaction as $key => $value) {
                    $data[$i]["selling"]+=$value->total_payment;
                }
            }
        }
        $returndata['chart']=$data;
        $returndata['table']=$table;
        $returndata['receivableall']=number_format(intval($receivableall), 0, ',', ',');
        $returndata['maturedall']=number_format(intval($maturedall), 0, ',', ',');
        $returndata['todaybillall']=number_format(intval($todaybillall), 0, ',', ',');
        $returndata['todaysellingall']=number_format(intval($todaysellingall), 0, ',', ',');
        $returndata['billall']=number_format(intval($billall), 0, ',', ',');
        $returndata['sellall']=number_format(intval($sellall), 0, ',', ',');

        return $returndata;
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
        $colour=null;
        $logo=null;
        $cost=null;

        if($request->has('weight')){
            $weight=$request->weight;
        }

        if($request->has('gross_weight')){
            $grossweight=$request->gross_weight;
        }

        if($request->has('colour')){
            $colour=$request->colour;
        }

        if($request->has('logo')){
            $logo=$request->logo;
        }

        if($request->has('cost')){
            $cost=$request->cost;
        }


        $product   =   Product::create([
            'id_factories' => $request->id_factories, 
            'type' => $request->type, 
            'size' => $request->size, 
            'weight' => $weight,
            'gross_weight'=> $grossweight,
            'colour' => $colour,
            'logo' => $logo,
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
       
        return Response()->json($product);
        
    }
    
}
