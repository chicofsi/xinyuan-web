<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

use App\Models\Sales;
use App\Models\Area;
use App\Models\Customer;
use App\Models\CustomerPhoto;
use App\Models\CustomerLevel;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\Product;
use App\Helper\JurnalHelper;

class ManageCustomer extends Controller
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
    public function index($id_area=null)
    {
        $arealist = Area::all();
        $sales = Sales::all();
        $levels = CustomerLevel::all();
        if($id_area != null){
            $area = Area::where('id',$id_area)->first();

            return view('admin.customer.index',compact('arealist','area','sales','levels'));
        }

        return view('admin.customer.index',compact('arealist','sales','levels'));
        
    }
    public function summary()
    {
        $arealist=Area::all();
        return view('admin.customer.summary',compact('arealist'));
    }

    public function summarylist(Request $request)
    {
        $customer=Customer::with('area','sales','transaction','customerlevel');
        if($request->area!=0){
            $customer=$customer->where('id_area',$request->area);
        }

        $customer=$customer->get();
        if($customer->isEmpty()){
            $returndata['data']="";
            return $returndata;
        }else{
            $data="";
            foreach ($customer as $key => $value) {
                if(!Auth::guard('web')->check()){
                    if($value->sales->id != Auth::id()){
                        continue;
                    }
                }
                if($request->nice!=2){
                    if($value->customerlevel->nice != $request->nice){
                        continue;
                    }
                }
                
                $transaction=Transaction::where('id_customer',$value->id)->first();
                if($transaction){
                    $transactionduedate=$transaction->payment_deadline;
                }else{
                    $transactionduedate="No Transaction Yet";
                }

                $one=DB::select( DB::raw("select sum(t.total_payment) as total from transaction t join customer c on t.id_customer=c.id where MONTH(t.date)=MONTH(curdate()) and c.id = :idCustomer GROUP BY t.id_customer"), array(
                   'idCustomer' => $value->id,
                 ));
                $selling=0;
                foreach ($one as $ke => $va) {
                    $selling+=$va->total;
                }

                $two=DB::select( DB::raw("select sum(t.total_payment) as total,sum(t.paid) as paid,sum(t.total_payment)-sum(t.paid) as debt from transaction t join customer c on t.id_customer=c.id where  c.id = :idCustomer GROUP BY t.id_customer"), array(
                   'idCustomer' => $value->id,
                 ));
                $debt=0;
                foreach ($two as $ke => $va) {
                    $debt+=$va->debt;
                }

                $three=DB::select( DB::raw("select c.company_name, sum(t.total_payment)-sum(t.paid) as debt from transaction t join customer c on t.id_customer=c.id where t.payment_deadline<curdate() and c.id = :idCustomer GROUP BY t.id_customer"), array(
                   'idCustomer' => $value->id,
                 ));
                $late=0;
                foreach ($three as $ke => $va) {
                    $late+=$va->debt;
                }

                $four=DB::select( DB::raw("select tp.paid as paid from transaction t join customer c on t.id_customer=c.id join transaction_payment tp on t.id=tp.id_transaction where date(tp.date) = curdate() and c.id=:idCustomer"), array(
                   'idCustomer' => $value->id,
                 ));
                $billtoday=0;
                foreach ($four as $ke => $va) {
                    $billtoday+=$va->paid;
                }

                $five=DB::select( DB::raw("select tp.paid as paid from transaction t join customer c on t.id_customer=c.id join transaction_payment tp on t.id=tp.id_transaction where MONTH(tp.date) = MONTH(curdate()) and c.id=:idCustomer"), array(
                   'idCustomer' => $value->id,
                 ));
                $billmonth=0;
                foreach ($five as $ke => $va) {
                    $billmonth+=$va->paid;
                }
                $six=DB::select( DB::raw("select max(datediff(date(tp.date),date(t.payment_deadline))) as latest from transaction t join transaction_payment tp on t.id=tp.id_transaction join customer c on t.id_customer=c.id where c.id=:idCustomer"), array(
                   'idCustomer' => $value->id,
                 ));
                $latest=0;
                foreach ($six as $ke => $va) {
                    if($latest<$va->latest){
                        $latest=$va->latest;
                    }
                }
                
                
                $data.= "<tr>
                            <td>".$value->company_name."</td>
                            <td>".$value->sales->name."</td>
                            <td>".$transactionduedate."</td>
                            <td>".$latest." Days Late</td>
                            <td>".$selling."</td>
                            <td>".$debt."</td>
                            <td>".$late."</td>
                            <td>".$billtoday."</td>
                            <td>".$billmonth."</td>
                            
                        </tr>";
            }


            $returndata['data']=$data;

            return $returndata;
        }

    }

    public function addPhoto(Request $request)
    {
        $photo=null;
        if($request->has('photo')&& $request->has('id_customer') && $request->has('id_photo_category')){
            $fileName= str_replace(' ','-', $request->id_customer.'_'.$request->id_photo_category.'_'.date('d-m-Y_H-i-s'));

            $guessExtension = $request->file('photo')->guessExtension();

            $file = $request->photo->storeAs('public/customer/photo',$fileName.'.'.$guessExtension);
            $photo=substr($file, 7);
            $customerphoto=CustomerPhoto::create(['id_customer'=>$request->id_customer,'id_customer_photo_category'=>$request->id_photo_category,'photo_url'=>$photo]);
            return $customerphoto;
        }
    }
    public function getPhotoDetail(Request $request)
    {
        $photo=CustomerPhoto::where('id',$request->id)->first();

        $photo->photo_url= URL::to('storage/'.$photo->photo_url);
        return $photo;
    }

    public function deletePhoto(Request $request)
    {
        $photo=CustomerPhoto::where('id',$request->id_customer_photo)->first();
        Storage::disk('public')->delete($photo->photo_url);
        $photo->delete();
        return $photo;
    }

    public function list($id_area=null)
    {
        $customer=Customer::with('area','sales','customerlevel');
        if(!Auth::guard('web')->check()){
            $customer=$customer->where('invited_by',Auth::id());
        }
        if($id_area!=null){
            $customer=$customer->where('id_area',$id_area);
        }
        $customer=$customer->get();
        if($customer->isEmpty()){
            return "blabla";
        }else{
            $data="";
            foreach ($customer as $key => $value) {
                $data.= "<tr>
                            <td>".$value->company_name."</td>
                            <td>".$value->administrator_name."</td>
                            <td>".$value->area->name."</td>
                            <td>".$value->customerlevel->level."</td>
                            <td>".$value->customerlevel->tempo_limit."</td>
                            <td>".number_format(intval($value->customerlevel->loan_limit), 0, ',', ',')."</td>
                            <td><a href='javascript:void(0)' onClick=detail(".$value->id.") data-toggle='tooltip' data-original-title='detail' class='btn btn-default btn-sm'>Detail</a></td>
                        </tr>";
            }

            $filterarea=Area::select('name')->get();

            foreach ($filterarea as $key => $value) {
                $area[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='area' value='".$value->name."' checked><label>".$value->name."</label></div></div>";
            }

            $filterlevel=CustomerLevel::select('level')->get();

            foreach ($filterlevel as $key => $value) {
                $level[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='level' value='".$value->level."' checked><label>".$value->level."</label></div></div>";
            }

            $filtertempo=['0','30','45','60','75','90'];

            foreach ($filtertempo as $key => $value) {
                $tempo[$key]="<div class='minimal single-row'><div class='checkbox '><input type='checkbox' name='tempo' value='".$value."' checked><label>".$value."</label></div></div>";
            }

            $returndata['data']=$data;
            $returndata['area']=$area;
            $returndata['level']=$level;
            $returndata['tempo']=$tempo;

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

    public function changeLevel(Request $request)
    {
        $customer=Customer::where('id',$request->id_customer)->update(['id_level'=>$request->id_level]);
        $customer=Customer::where('id',$request->id_customer)->with('customerlevel')->first();
        return Response()->json($customer);
    }

    public function uploadCustomerToJurnal(Request $request)
    {
        $customer = Customer::all();
        foreach($customer as $key => $value){
            if($value->jurnal_id == null){
                $person=[];

                $person["display_name"]=$value->administrator_name;
                $person["is_customer"]=true;
                $person["is_vendor"]=false;
                $person["is_employee"]=false;
                $person["is_others"]=false;
                $person["first_name"]=$value->administrator_name;
                $person["phone"]=$value->company_phone;
                $person["associate_company"]=$value->company_name;
                $person["mobile"]=$value->administrator_phone;
                $person["tax_no"]=$value->companynpwp;
                $person["address"]=$value->company_address;

                $contact = json_decode($this->client->request(
                    'POST',
                    'contacts',
                    [
                        'json' => [
                            'person'=>$person
                        ]
                    ]
                )->getBody()->getContents());
                Customer::where('id',$value->id)->update([
                    'jurnal_id'=>$contact->person->id
                ]);
            }
        }
        return "complete";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guard('sales')->check()){
            $sales=Auth::id();
        }else{
            $sales=$request->id_sales;
        }

        $companyphone=null;
        $companynpwp=null;
        $administratorbirthdate=null;
        $administratornpwp=null;
        $administratoraddress=null;

        if($request->has('company_phone')){
            $companyphone=$request->companyphone;
        }

        if($request->has('company_npwp')){
            $companynpwp=$request->company_npwp;
        }

        if($request->has('administrator_address')){
            $administratoraddress=$request->administrator_address;
        }

        if($request->has('administrator_birthdate')){
            $administratorbirthdate=$request->administrator_birthdate;
        }

        if($request->has('administrator_npwp')){
            $administratornpwp=$request->administrator_npwp;
        }
        
        
        $customer   =   Customer::create([
            'id_area' => $request->id_area,
            'invited_by' => $sales, 
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $companyphone,
            'company_npwp' => $companynpwp,
            'administrator_name' => $request->administrator_name,
            'administrator_id' => $request->administrator_id,
            'administrator_birthdate' => $administratorbirthdate,
            'administrator_npwp' => $administratornpwp,
            'administrator_phone' => $request->administrator_phone,
            'administrator_address' => $administratoraddress,
            'id_level' => $request->id_level, 
        ]);    

        $person=[];

        $person["display_name"]=$request->administrator_name;
        $person["is_customer"]=true;
        $person["is_vendor"]=false;
        $person["is_employee"]=false;
        $person["is_others"]=false;
        $person["first_name"]=$request->administrator_name;
        $person["phone"]=$request->company_phone;
        $person["associate_company"]=$request->company_name;
        $person["mobile"]=$request->administrator_phone;
        $person["tax_no"]=$companynpwp;
        $person["address"]=$request->company_address;

        $contact = json_decode($this->client->request(
            'POST',
            'contacts',
            [
                'json' => [
                    'person'=>$person
                ]
            ]
        )->getBody()->getContents());
        $customer   =   Customer::where('id',$customer->id)->update([
            'jurnal_id'=>$contact->person->id
        ]);

        return Response()->json($customer);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $customer  = Customer::where('id',$request->id)->with('area','transaction','sales','customerphoto','customerlevel')->first();


        $gallery="";
        if(! $customer->customerphoto->isEmpty()){
            foreach ($customer->customerphoto as $key => $value) {
                $gallery=$gallery."<div class='images item '' onClick='imgdetail(".$value->id.")' ><img style='object-fit:contain;' src='".URL::to('storage/'.$value->photo_url)."' alt='' /></div>";
            }
        }

        
        

        if($customer->transaction->isEmpty()){
            $customer['transactioncount']=0;
        }else{
            $customer['transactioncount']=$customer->transaction->count();
            $unpaid=0;
            foreach ($customer->transaction as $key => $value) {
                $unpaid+=$value->total_payment - $value->paid;
            }
            $customer['unpaid']=$unpaid;
        }

        $customer['joined']=date("d F Y", strtotime($customer->created_at));

        for ($i=0; $i < 12; $i++) { 
            $transaction=Transaction::where('id_customer',$request->id)->whereYear('date','=',(date('Y',strtotime(date('Y-m').' -'.$i.' month'))))->whereMonth('date','=',(date('m',strtotime(date('Y-m').' - '.$i.' month'))))->get();
            $data[$i]["year"]=(date('Y',strtotime(date('Y-m').' -'.$i.' month')));
            $data[$i]["month"]=(date('m',strtotime(date('Y-m').' -'.$i.' month')));
            $data[$i]["transaction"]=0;
            if($transaction->isEmpty()){
                $data[$i]["transaction"]=0;
            }else{
                $data[$i]["transaction"]=$transaction->count();
            }
        }
        $customer->chart=$data;
        $customer->gallery=$gallery;

        $transaction=Transaction::where('id_customer',$request->id)->with('customer','transactiondetails','sales')->get();
        if($transaction->isEmpty()){
            $customer['transactionlist']="EMPTY";
        }else{
            $customer['transactionlist']="";
            foreach ($transaction as $key => $value) {
                $customer['transactionlist'].= "<tr>
                            <td>".$value->id."</td>
                            <td>".$value->invoice_number."</td>
                            <td>".$value->date."</td>";
                            // <td>".$value->total_payment."</td>
                            // <td>".$value->paid."</td>
                            // <td>".$value->transactiondetails->count()."</td>

                $customer['transactionlist'].="<td>";
                foreach ($value->transactiondetails as $key => $prod){
                    $product=Product::where('id', $prod->id_product)->with('type','size','colour','logo')->first();
                    $customer['transactionlist'].="<div class='row'>
                                    <div class='col-sm-12'>
                                    ".$product->type->name." ".$product->size->width."X".$product->size->height." ".$product->colour->name."
                                    </div>
                                </div>";
                }
                $customer['transactionlist'].="</td><td>";
                foreach ($value->transactiondetails as $key => $prod){
                    $customer['transactionlist'].="<div class='row'>
                                    <div class='col-sm-12'>
                                    ".$prod->quantity."
                                    </div>
                                </div>";
                }
                $customer['transactionlist'].="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    $customer['transactionlist'].="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->price."
                                </div>
                            </div>";
                }
                $customer['transactionlist'].="</td><td>";
                foreach ($value->transactiondetails as $key => $prod) {
                    $customer['transactionlist'].="<div class='row'>
                                <div class='col-sm-12'>
                                ".$prod->total."
                                </div>
                            </div>";
                }
                $customer['transactionlist'].="</td>";

                $customer['transactionlist'].= "<td>".$value->total_payment."</td></tr>";
            }
        }
        return $customer;
        
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

        if(Auth::guard('sales')->check()){
            $sales=Auth::id();
        }else{
            $sales=$request->id_sales;
        }

        $companyphone=null;
        $companynpwp=null;
        $administratorbirthdate=null;
        $administratornpwp=null;
        $administratoraddress=null;

        if($request->has('company_phone')){
            $companyphone=$request->companyphone;
        }

        if($request->has('company_npwp')){
            $companynpwp=$request->company_npwp;
        }

        if($request->has('administrator_address')){
            $administratoraddress=$request->administrator_address;
        }

        if($request->has('administrator_birthdate')){
            $administratorbirthdate=$request->administrator_birthdate;
        }

        if($request->has('administrator_npwp')){
            $administratornpwp=$request->administrator_npwp;
        }
        
        
        $customer   =   Customer::where($where)->update([
            'id_area' => $request->id_area,
            'invited_by' => $sales, 
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $companyphone,
            'company_npwp' => $companynpwp,
            'administrator_name' => $request->administrator_name,
            'administrator_id' => $request->administrator_id,
            'administrator_birthdate' => $administratorbirthdate,
            'administrator_npwp' => $administratornpwp,
            'administrator_phone' => $request->administrator_phone,
            'administrator_address' => $administratoraddress,
            'id_level' => $request->id_level, 
        ]);    
        return Response()->json($customer);
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
        $customer = Customer::where('id',$request->id)->delete();
      
        return Response()->json($customer);
    }
}
