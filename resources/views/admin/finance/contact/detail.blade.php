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
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datepicker/css/datepicker-custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-timepicker/css/timepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-colorpicker/css/colorpicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datetimepicker/css/datetimepicker-custom.css')}}" />
    @endsection

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="panel" style="background: #eff0f4">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h1 class="title" > Contact Information </h1>
                    </div>
                </div>
                <div class="panel" >
                    <div class="panel-heading">
                        {{$response->display_name}}
                    </div>
                    <div class="panel-body">
                        type: @if ($response->is_customer)
                            <span class='label label-warning'>Customer</span>
                        @endif
                        @if ($response->is_vendor)
                            <span class='label label-info'>Vendor</span>
                        @endif
                        @if ($response->is_employee)
                            <span class='label label-success'>Employee</span>
                        @endif
                        @if ($response->is_others)
                            <span class='label label-danger'>Other</span>
                        @endif
                        <header class="panel-heading custom-tab dark-tab " style="margin-top: 20px">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#profile" data-toggle="tab">Profile</a>
                                </li>
                                <li class="">
                                    <a href="#transaction" data-toggle="tab">Transaction</a>
                                </li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    
                                    <div class="well invoice-address">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>General Information</h4>
                                            </div>
                                            <div class="col-md-4 table-invoice" style="padding-top: 30px">
                                                <h4 class="inv_to">Contact Name</h4>
                                                <p id="contact_name">
                                                    {{$response->fullname_with_title?$response->fullname_with_title:"-"}}
                                                </p>
                                                <h4 class="inv_to">Company Name</h4>
                                                <p id="company_name">
                                                    {{$response->associate_company?$response->associate_company:"-"}}
                                                </p>
                                                <h4 class="inv_to">email</h4>
                                                <p id="email">
                                                    {{$response->email?$response->email:"-"}}
                                                </p>
                                                <h4 class="inv_to">Handphone</h4>
                                                <p id="handphone">
                                                    {{$response->mobile?$response->mobile:"-"}}
                                                </p>
                                            </div>
                                            <div class="col-md-4 table-invoice" style="padding-top: 30px">
                                                <h4 class="inv_to">Telephone</h4>
                                                <p id="telephone">
                                                    {{$response->phone?$response->phone:"-"}}
                                                </p>
                                                <h4 class="inv_to">Fax</h4>
                                                <p id="fax">
                                                    {{$response->fax?$response->fax:"-"}}
                                                </p>
                                                <h4 class="inv_to">Billing Address</h4>
                                                <p id="billing_address">
                                                    {{$response->billing_address?$response->billing_address:"-"}}
                                                </p>
                                                <h4 class="inv_to">Shipping Address</h4>
                                                <p id="shipping_address">
                                                    {{$response->address?$response->address:"-"}}
                                                </p>
                                            </div>
                                            <div class="col-md-4 table-invoice" style="padding-top: 30px">
                                                <h4 class="inv_to">NPWP</h4>
                                                <p id="npwp">
                                                    {{$response->tax_no?$response->tax_no:"-"}}
                                                </p>
                                                <h4 class="inv_to">Identity</h4>
                                                <p id="identity_type">
                                                    {{$response->identity_type?$response->identity_type:"-"}}
                                                </p>
                                                <h4 class="inv_to">Identity Number</h4>
                                                <p id="identity_number">
                                                    {{$response->identity_number?$response->identity_number:"-"}}
                                                </p>
                                                <h4 class="inv_to">Another Info</h4>
                                                <p id="another_info">
                                                    {{$response->other_detail?$response->other_detail:"-"}}
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="well invoice-address">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Account Mapping</h4>
                                            </div>
                                            <div class="col-md-6 table-invoice" style="padding-top: 30px">
                                                <h4 class="inv_to">Account Payable</h4>
                                                <p id="account_payable">
                                                    {{"(".$response->default_ap_account->number.") ".$response->default_ap_account->name}}
                                                </p>
                                                <h4 class="inv_to">Account Receivable</h4>
                                                <p id="account_receivable">
                                                    {{"(".$response->default_ar_account->number.") ".$response->default_ar_account->name}}
                                                </p>
                                            </div>
                                            <div class="col-md-6 table-invoice" style="padding-top: 30px">
                                                <h4 class="inv_to">Default Payment Terms</h4>
                                                <p id="contact_name">
                                                    {{$response->term_name?$response->term_name:"-"}}
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="tab-pane " id="transaction">
                                    <div class="adv-table">
                                        <div class="row">
                                            <div class="col-md-8" style="padding: 10px">
                                            </div>
                                            <div class="col-md-4" style="padding: 10px">
                                                {{-- <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label> --}}
                                            </div>
                                        </div>
                                        <table  class="display table table-hover " id="transaction_list">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Date
                                                    </th>
                                                    <th>
                                                        Number
                                                    </th>
                                                    <th>
                                                        Due Date
                                                    </th>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <th style="text-align: right;">
                                                        Amount
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if (empty($transaction->transaction_list))
                                                    <tr>
                                                        <td colspan="5">
                                                            No Items
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($transaction->transaction_list as $val)
                                                    <tr>
                                                        <td>
                                                            {{$val->transaction_date}}
                                                        </td>
                                                        <td>
                                                            <a 
                                                            @if (strpos($val->transaction_no, 'Sales Invoice') !== false)
                                                                href="{{ url('dashboard/finance/sales/invoice/') }}/{{$val->transaction_id}}"
                                                            @elseif (strpos($val->transaction_no, 'Sales Order') !== false)
                                                                href="{{ url('dashboard/finance/sales/order/') }}/{{$val->transaction_id}}"
                                                            @elseif (strpos($val->transaction_no, 'Sales Quote') !== false)
                                                                href="{{ url('dashboard/finance/sales/quote/') }}/{{$val->transaction_id}}"
                                                            @elseif (strpos($val->transaction_no, 'Purchase Invoice') !== false)
                                                                href="{{ url('dashboard/finance/purchase/invoice/') }}/{{$val->transaction_id}}"
                                                            @elseif (strpos($val->transaction_no, 'Purchase Order') !== false)
                                                                href="{{ url('dashboard/finance/purchase/order/') }}/{{$val->transaction_id}}"
                                                            @elseif (strpos($val->transaction_no, 'Purchase Quote') !== false)
                                                                href="{{ url('dashboard/finance/purchase/quote/') }}/{{$val->transaction_id}}"
                                                            @elseif (strpos($val->transaction_no, 'Expense') !== false)
                                                                href="{{ url('dashboard/finance/expenses/') }}/{{$val->transaction_id}}"
                                                            
                                                            @endif
                                                            > 
                                                                {{$val->transaction_no}}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{$val->transaction_due_date}} 
                                                        </td>
                                                        <td>
                                                            {{$val->transaction_status}} 
                                                        </td>                    
                                                        <td style="text-align: right;">
                                                            {{$val->total}} 
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        {{-- <div class="text-center ">
            <a class="btn btn-success btn-lg"><i class="fa fa-check"></i> Submit Invoice </a>
            <a class="btn btn-primary btn-lg" target="_blank" href="invoice_print.html"><i class="fa fa-print"></i> Print </a>
        </div> --}}

    </div>
    @section('script')

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
        <script type="text/javascript" src="{{asset('js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
        <script>
            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('body').append('<div class="loading"></div>');

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


            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#AccountDetailModalTitle').html("Account Details");
                        $('#AccountDetailModal').modal('show');
                        $('#idAccount').val(res.id);
                        $('#id_level_change').val(res.customerlevel.id);

                        $('#AccountCompanyName').html(res.company_name);
                        $('#AccountAdministratorName').html(res.administrator_name);
                        $('#AccountArea').html(res.area.name);
                        $('#AccountTempo').html(res.customerlevel.tempo_limit);
                        $('#AccountLoanLimit').html(res.customerlevel.loan_limit);
                        $('#AccountInvitedBy').html(res.sales.name);
                        $('#AccountLevel').html(res.customerlevel.level);
                        var join=new Date(res.created_at);
                        $('#AccountJoined').html("Joined Since "+(join.getDate())+"/"+join.getMonth()+1+"/"+join.getFullYear());
                        $('#AccountTotalTransaction').html(res.transactioncount+' Transaction');
                        if(res.unpaid){
                            $('#AccountTotalUnpaid').html(res.unpaid);
                        }else{
                            $('#AccountTotalUnpaid').html(0);
                        }

                        $('#AccountCompanyAddress').html(res.company_address);
                        $('#AccountCompanyPhone').html(res.company_phone);
                        $('#AccountCompanyNPWP').html(res.company_npwp);
                        $('#AccountAdministratorID').html(res.administrator_id);
                        $('#AccountAdministratorBirthdate').html(res.administrator_birthdate);
                        $('#AccountAdministratorNPWP').html(res.administrator_npwp);
                        $('#AccountAdministratorPhone').html(res.administrator_phone);
                        $('#AccountAdministratorAddress').html(res.administrator_address);

                        var data=[];
                        $.each(res.chart, function(){     
                            data.push([gd(this.year,this.month),this.transaction]);
                        });
                        transactionChart(data);

                        $('#AccountPhoto').html(res.gallery);


                        $('#TransactionList').html(res.transactionlist);
                        $('.loading').css("display",'none');

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            
        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>




