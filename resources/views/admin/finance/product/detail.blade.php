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
                        <h1 class="title" > Product Information </h1>
                    </div>
                </div>
                <div class="panel" >
                    <div class="panel-heading">
                        {{$response->name}}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="well">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>General Information</h4>
                                        </div>
                                        <div class="col-md-6 table-invoice" style="padding-top: 30px">
                                            <h4 class="inv_to">Average Price</h4>
                                            <p id="average_price">
                                                {{$response->average_price_currency_format}}
                                            </p>
                                            <h4 class="inv_to">Current Stock</h4>
                                            <p id="current_stock">
                                                - Buah
                                            </p>
                                            <h4 class="inv_to">Minimum Stock Limit</h4>
                                            <p id="minimum_stock">
                                                - Buah
                                            </p>
                                        </div>
                                        <div class="col-md-6 table-invoice" style="padding-top: 30px">
                                            <h4 class="inv_to">Product Category</h4>
                                            <p id="category">
                                                {{$response->product_categories?$response->product_categories:"-"}}
                                            </p>
                                            <h4 class="inv_to">Description</h4>
                                            <p id="description">
                                                {{$response->description?$response->description:"-"}}
                                            </p>
                                            <h4 class="inv_to">Product Type</h4>
                                            <p id="product_type">
                                                Single
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-12">
                                        <h4>Product Transaction</h4>
                                    </div>
                                    <div class="col-md-12">
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
                                                            Type
                                                        </th>
                                                        <th>
                                                            Qty
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
    
                                                    @if (empty($transaction->transactions))
                                                        <tr>
                                                            <td colspan="3">
                                                                No Items
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @foreach ($transaction->transactions as $val)
                                                        <tr>
                                                            <td>
                                                                {{$val->transaction_date}}
                                                            </td>
                                                            <td>
                                                                <a
                                                                @if (strpos($val->type, 'Sales Invoice') !== false)
                                                                    href="{{ url('dashboard/finance/sales/invoice/') }}/{{$val->id}}"
                                                                @elseif (strpos($val->type, 'Sales Order') !== false)
                                                                    href="{{ url('dashboard/finance/sales/order/') }}/{{$val->id}}"
                                                                @elseif (strpos($val->type, 'Sales Quote') !== false)
                                                                    href="{{ url('dashboard/finance/sales/quote/') }}/{{$val->id}}"
                                                                @elseif (strpos($val->type, 'Purchase Invoice') !== false)
                                                                    href="{{ url('dashboard/finance/purchase/invoice/') }}/{{$val->id}}"
                                                                @elseif (strpos($val->type, 'Purchase Order') !== false)
                                                                    href="{{ url('dashboard/finance/purchase/order/') }}/{{$val->id}}"
                                                                @elseif (strpos($val->type, 'Purchase Quote') !== false)
                                                                    href="{{ url('dashboard/finance/purchase/quote/') }}/{{$val->id}}"
                                                                @elseif (strpos($val->type, 'Expense') !== false)
                                                                    href="{{ url('dashboard/finance/expenses/') }}/{{$val->id}}"
                                                                @endif
                                                                > 
                                                                    {{$val->type." #".$val->transaction_no}}
                                                                </a>
                                                            </td>           
                                                            <td >
                                                                {{$val->quantity}} 
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

            function add(){
                $('#AddAccountForm').trigger("reset");
                $('#AddAccountModalTitle').html("Add Account");
                $('#id').val('');
            };

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

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            

            



            

            $('#AddAccountForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/finance/account')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#AddAccountModal").modal('hide');
                        getTables();
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });

        
            

        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>




