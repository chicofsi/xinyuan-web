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
        <div class="panel">
            <div class="panel-body invoice">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h1 class="invoice-title" >{{$response->transaction_type->name}} #{{$response->transaction_no}}</h1>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h2 style="margin-top: 30px">{{$response->transaction_status->name}}</h2>
                    </div>
                </div>
                <div class="invoice-address">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <h4 class="inv-to">Pay From</h4>
                            <a href="{{ url('dashboard/finance/account/')."/".$response->pay_from->id }}">
                                <h2 class="corporate-id"> {{$response->pay_from->name}}</h2>
                            </a>
                            <h4 class="inv-to">Beneficiary</h4>
                            <a href="{{ url('dashboard/finance/contact/')."/".$response->person->id }}">
                                <h2 class="corporate-id"> {{$response->person->display_name}}</h2>
                            </a>
                            <h4 class="inv-to" >Billing Address</h4>
                            <p id="address">
                                {{$response->address}}
                            </p>

                        </div>
                        <div class="col-md-4  col-sm-4">
                            <div class="inv-col"><span>Transaction Date :</span> <div id="transaction_date"> {{$response->transaction_date}}</div></div>
                        </div>
                        <div class="col-md-4  col-sm-4">
                            <div class="inv-col"><span>Transaction No </span> <div id="transaction_no">{{$response->transaction_no}}</div> </div>
                            <div class="inv-col"><span>Payment Method </span> <div id="ref_no">{{$response->payment_method->name}}</div></div>
                            <div class="inv-col"><span>Tags </span><div id="tags">{{$response->tags}}</div></div>
                            <h1 class="t-due">Total Amount </h1>
                            <h2 class="amnt-value" id="Total_amount">{{$response->balance_due_currency_format}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-invoice">
                <thead>
                <tr>
                    <th>Expense Account</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Tax</th>
                    <th class="text-right">Amount (in IDR)</th>
                </tr>
                </thead>
                <tbody >
                    @foreach ($response->transaction_account_lines_attributes as $val)
                        <tr>
                            <td>
                                <a href="{{ url('dashboard/finance/account')."/".$val->account->id }}">{{$val->account->name}}</a>
                            </td>
                            <td>{{$val->description}}</td>
                            <td>{{$val->line_tax->name}}</td>
                            <td class="text-right">{{$val->debit_currency_format}}</td>
                        </tr>
                    @endforeach
                

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="payment-method">
                        </td>
                        <td class="text-right">
                            <p>Sub Total</p>
                            @foreach ($response->tax_details as $val)
                                <p>{{$val->name}}</p>
                            @endforeach
                            <p>Payment Paid</p>
                            <p><strong>Balance Due</strong></p>
                        </td>
                        <td class="text-right">
                            <p id="subtotal">{{$response->subtotal_currency_format}}</p>
                            @foreach ($response->tax_details as $val)
                                <p>{{$val->tax_amount_currency_format}}</p>
                            @endforeach
                            <p id="payment_paid">{{$response->amount_receive_currency_format}}</p>
                            <p><strong id="balance_due">{{$response->balance_due_currency_format}}</strong></p>
                        </td>
                    </tr>
                </tfoot>
            </table>
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




