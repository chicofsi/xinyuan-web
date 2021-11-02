<x-app-layout>
    @section('style')
    <style type="text/css">
        .img-row{
            max-height: 60px; 
        }
        .well{
            margin-bottom: 0px !important;
        }
        ul.activity-list li{
            margin-bottom: 20px !important;
        }
        .profile-pic img{
            object-fit: contain !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-fileupload.min.css')}}" />
    <link href="{{asset('css/jquery.stepy.css')}}" rel="stylesheet">
    @endsection
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Contacts
        </h3>
        <div class="state-info">

            <a href="#AddContactModal" data-toggle="modal" onclick="add()" class=" btn btn-primary "> New Contact <i class="fa fa-plus"></i></a>
        </div>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading custom-tab dark-tab ">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#customer" data-toggle="tab">Customer</a>
                            </li>
                            <li class="">
                                <a href="#vendor" data-toggle="tab">Vendor</a>
                            </li>
                            <li class="">
                                <a href="#employee" data-toggle="tab">Employee</a>
                            </li>
                            <li class="">
                                <a href="#other" data-toggle="tab">Other</a>
                            </li>
                            <li class="">
                                <a href="#all" data-toggle="tab">All</a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="customer">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="customer_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Display Name
                                                </th>
                                                <th></th>
                                                <th>
                                                    Company Name
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Mobile Phone
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (empty($customers->person_data))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($customers->person_data as $val)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url('dashboard/finance/contact')."/".$val->person_id }}">{{$val->display_name}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach ($val->color_coding as $value)
                                                            @if ($value==1)
                                                                <span class='label label-warning'>Customer</span>
                                                            @elseif($value==2)
                                                                <span class='label label-info'>Vendor</span>
                                                            @elseif($value==3)
                                                                <span class='label label-success'>Employee</span>
                                                            @elseif($value==4)
                                                                <span class='label label-danger'>Other</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$val->associate_company}}
                                                    </td>
                                                    <td>
                                                        {{$val->address}} 
                                                    </td>
                                                    <td>
                                                        {{$val->email}} 
                                                    </td>
                                                    <td>
                                                        {{$val->mobile}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>                                        
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            
                            <div class="tab-pane " id="vendor">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="vendor_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Display Name
                                                </th>
                                                <th></th>
                                                <th>
                                                    Company Name
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Mobile Phone
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (empty($vendors->person_data))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($vendors->person_data as $val)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url('dashboard/finance/contact')."/".$val->person_id }}">{{$val->display_name}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach ($val->color_coding as $value)
                                                            @if ($value==1)
                                                                <span class='label label-warning'>Customer</span>
                                                            @elseif($value==2)
                                                                <span class='label label-info'>Vendor</span>
                                                            @elseif($value==3)
                                                                <span class='label label-success'>Employee</span>
                                                            @elseif($value==4)
                                                                <span class='label label-danger'>Other</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$val->associate_company}}
                                                    </td>
                                                    <td>
                                                        {{$val->address}} 
                                                    </td>
                                                    <td>
                                                        {{$val->email}} 
                                                    </td>
                                                    <td>
                                                        {{$val->mobile}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            <div class="tab-pane " id="employee">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="employee_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Display Name
                                                </th>
                                                <th></th>
                                                <th>
                                                    Company Name
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Mobile Phone
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (empty($employees->person_data))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($employees->person_data as $val)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url('dashboard/finance/contact')."/".$val->person_id }}">{{$val->display_name}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach ($val->color_coding as $value)
                                                            @if ($value==1)
                                                                <span class='label label-warning'>Customer</span>
                                                            @elseif($value==2)
                                                                <span class='label label-info'>Vendor</span>
                                                            @elseif($value==3)
                                                                <span class='label label-success'>Employee</span>
                                                            @elseif($value==4)
                                                                <span class='label label-danger'>Other</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$val->associate_company}}
                                                    </td>
                                                    <td>
                                                        {{$val->address}} 
                                                    </td>
                                                    <td>
                                                        {{$val->email}} 
                                                    </td>
                                                    <td>
                                                        {{$val->mobile}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            <div class="tab-pane " id="other">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="other_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Display Name
                                                </th>
                                                <th></th>
                                                <th>
                                                    Company Name
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Mobile Phone
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (empty($others->person_data))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($others->person_data as $val)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url('dashboard/finance/contact')."/".$val->person_id }}">{{$val->display_name}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach ($val->color_coding as $value)
                                                            @if ($value==1)
                                                                <span class='label label-warning'>Customer</span>
                                                            @elseif($value==2)
                                                                <span class='label label-info'>Vendor</span>
                                                            @elseif($value==3)
                                                                <span class='label label-success'>Employee</span>
                                                            @elseif($value==4)
                                                                <span class='label label-danger'>Other</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$val->associate_company}}
                                                    </td>
                                                    <td>
                                                        {{$val->address}} 
                                                    </td>
                                                    <td>
                                                        {{$val->email}} 
                                                    </td>
                                                    <td>
                                                        {{$val->mobile}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            <div class="tab-pane " id="all">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="all_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Display Name
                                                </th>
                                                <th></th>
                                                <th>
                                                    Company Name
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Mobile Phone
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance 
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (empty($all->person_data))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($all->person_data as $val)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url('dashboard/finance/contact')."/".$val->person_id }}">{{$val->display_name}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach ($val->color_coding as $value)
                                                            @if ($value==1)
                                                                <span class='label label-warning'>Customer</span>
                                                            @elseif($value==2)
                                                                <span class='label label-info'>Vendor</span>
                                                            @elseif($value==3)
                                                                <span class='label label-success'>Employee</span>
                                                            @elseif($value==4)
                                                                <span class='label label-danger'>Other</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$val->associate_company}}
                                                    </td>
                                                    <td>
                                                        {{$val->address}} 
                                                    </td>
                                                    <td>
                                                        {{$val->email}} 
                                                    </td>
                                                    <td>
                                                        {{$val->mobile}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div aria-hidden="true" role="dialog"  id="AddContactModal" class="modal fade">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form role="form" id="AddContactForm" name="AddContactForm">

                                    <input type="hidden" name="id" id="id">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="AddContactModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">Contact Info</div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="p-info">
                                                            <li>
                                                                <div class="title">Display Name*</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="display_name" name="display_name" placeholder="Display Name">
                                                            </li>
                                                            <li>
                                                                <div class="title">Contact Type*</div>

                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="isCustomer" > Customer
                                                                </label>
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="isVendor"> Vendor
                                                                </label>
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="isEmployee" > Employee
                                                                </label>
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="isOther" > Other
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <div class="title">Contact Group</div>
                                                                
                                                                <select class="desk form-control" id="contact_group" style="color: black;" name="contact_group" @if (empty($contact_groups->contact_group)) disabled @endif >
                                                                    @foreach ($contact_groups->contact_group as $val)
                                                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">General Information</div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="p-info">
                                                            <li>
                                                                <div class="title">Contact Name</div>
                                                                <div class=" desk">
                                                                    <div class="col-lg-3" style="padding: 0px">
                                                                        <select class=" form-control" id="title" style="color: black;" name="title" >
                                                                            <option value="">(Empty)</option>
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Ms.">Ms.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3" style="padding: 0px">
                                                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                                                    </div>
                                                                    <div class="col-lg-3" style="padding: 0px">
                                                                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                                                                    </div>
                                                                    <div class="col-lg-3" style="padding: 0px">
                                                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                                                    </div>
                                                                </div>
                                                                
                                                            </li>
                                                            <li>
                                                                <div class="title">Handphone</div>
                                                                <input type="phone" class="form-control desk" style="color: black;" id="handphone" name="handphone" placeholder="Handphone">
                                                                
                                                            </li>
                                                            <li>
                                                                <div class="title">Identity</div>
                                                                <div class=" desk">
                                                                    <div class="col-lg-4" style="padding: 0px">
                                                                        <select class=" form-control" id="identity_type" style="color: black;" name="identity_type" >
                                                                            <option value="KTP">KTP</option>
                                                                            <option value="Passport">Passport</option>
                                                                            <option value="SIM">SIM</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-8" style="padding: 0px">
                                                                        <input type="text" id="identity" name="identity" class="form-control" placeholder="Identity Number">
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="title">Email</div>
                                                                <input type="email" class="form-control desk" style="color: black;" id="email" name="email" placeholder="Email">
                                                            </li>

                                                            <li>
                                                                <div class="title">Another Info</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="another_info" name="another_info" placeholder="Another Info">
                                                            </li>

                                                            <li>
                                                                <div class="title">Company Name</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="company_name" name="company_name" placeholder="Company Name">
                                                            </li>

                                                            <li>
                                                                <div class="title">Telephone</div>
                                                                <input type="phone" class="form-control desk" style="color: black;" id="telephone" name="telephone" placeholder="Telephone">
                                                            </li>

                                                            <li>
                                                                <div class="title">Fax</div>
                                                                <input type="fax" class="form-control desk" style="color: black;" id="fax" name="fax" placeholder="Fax">
                                                            </li>

                                                            <li>
                                                                <div class="title">NPWP</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="npwp" name="npwp" placeholder="NPWP">
                                                            </li>
                                                            <li>
                                                                <div class="title">Billing Address</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="billing_address" name="billing_address" placeholder="Billing Address">
                                                            </li>
                                                            <li>
                                                                <div class="title">Shipping Address</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="shipping_address" name="shipping_address" placeholder="Shipping Address">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-submit" class="btn btn-success " style="display: inline !important;">Add</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @section('script')

        <script>
            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('body').append('<div class="loading"></div>');
                $('.loading').css("display",'none');

            });
            $('#AddContactForm').submit(function(e) {
                $('.loading').css("display",'block');

                e.preventDefault();
                isCustomer=$('#isCustomer').is(":checked");
                isVendor=$('#isVendor').is(":checked");
                isEmployee=$('#isEmployee').is(":checked");
                isOther=$('#isOther').is(":checked");

                if(!$('#display_name').val()){
                    alert("Insert Display Name!");
                }else if(isCustomer!=1 && isVendor!=1 && isEmployee!=1 && isOther!=1 ){
                    alert('Select Contact Type!');
                }else{
                    person={};

                    person["display_name"]=$("#display_name").val();
                    person["is_customer"]=isCustomer;
                    person["is_vendor"]=isVendor;
                    person["is_employee"]=isEmployee;
                    person["is_others"]=isOther;
                    if( !$("#title").val() ){
                        person["title"]=null;
                    }else{
                        person["title"]=$("#title").val();
                    }
                    if( $("#first_name").val()){
                        person["first_name"]=$("#first_name").val();
                    }
                    if( $("#middle_name").val()){
                        person["middle_name"]=$("#middle_name").val();
                    }
                    if( $("#last_name").val()){
                        person["last_name"]=$("#last_name").val();
                    }

                    if( $("#handphone").val()){
                        person["mobile"]=$("#handphone").val();
                    }
                    if( $("#identity").val()){
                        person["identity_type"]=$("#identity_type").val();
                        person["identity_number"]=$("#identity").val();
                    }


                    if( $("#another_info").val()){
                        person["other_detail"]=$("#another_info").val();
                    }
                    if( $("#email").val()){
                        person["email"]=$("#email").val();
                    }
                    if( $("#company_name").val()){
                        person["associate_company"]=$("#company_name").val();
                    }
                    if( $("#telephone").val()){
                        person["phone"]=$("#telephone").val();
                    }
                    if( $("#fax").val()){
                        person["fax"]=$("#fax").val();
                    }
                    if( $("#npwp").val()){
                        person["tax_no"]=$("#npwp").val();
                    }
                    if( $("#billing_address").val()){
                        person["billing_address"]=$("#billing_address").val();
                    }
                    if( $("#shipping_address").val()){
                        person["address"]=$("#shipping_address").val();
                    }
                    request={};
                    request["person"]=person;
                    console.log(request);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/finance/contact')}}",
                        data: JSON.stringify(request),
                        dataType: 'json',
                        cache:false,
                        processData: false,
                        success: (data) => {
                            location.reload();
                            $("#AddContactModal").modal('hide');
                            $('.loading').css("display",'none');

                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 
                }
            
               
            });
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split           = number_string.split(','),
                sisa            = split[0].length % 3,
                rupiah          = split[0].substr(0, sisa),
                ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
     
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
     
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '') +",00";
            }

            

        </script>

        <script src="{{asset('js/flot-chart/jquery.flot.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.tooltip.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.pie.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.selection.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.time.js')}}"></script>
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('js/jquery.stepy.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>
    @endsection
        <!--body wrapper end-->
</x-app-layout>



