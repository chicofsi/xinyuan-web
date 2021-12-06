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
    <link rel="stylesheet" type="text/css" href="{{asset('js/jquery-multi-select/css/multi-select.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datepicker/css/datepicker-custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-timepicker/css/timepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-colorpicker/css/colorpicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datetimepicker/css/datetimepicker-custom.css')}}" />
    @endsection

    <!--body wrapper start-->
    <div class="wrapper">

        <form method="post" id="formInvoice">
            <div class="panel">
                <div class="panel-body invoice">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h2 class="invoice-title" id="title">Bank Deposit</h2>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-top: 15px">
                            <h1 class="t-due">Total Amount </h1>
                            <h2 class="amnt-value" id="total_amount">0</h2>
                        </div>
                    </div>
                    <div class="invoice-address">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Deposit To</h4>
                                <h2 class="corporate-id" >
                                    <select class="selectpicker  form-control" data-live-search="true" id="depositTo" style="color: black;" name="from" >
                                        @foreach ($cash->accounts  as $val)
                                            <option value="{{$val->id}}" @if (isset($_GET['from']))
                                                @if ($_GET['from']==$val->id)
                                                    selected 
                                                @endif
                                            @endif>{{$val->number." ".$val->name}}</option>
                                        @endforeach
                                        @foreach ($credit->accounts  as $val)
                                            <option value="{{$val->id}}" @if (isset($_GET['from']))
                                                @if ($_GET['from']==$val->id)
                                                    selected 
                                                @endif
                                            @endif>{{$val->number." ".$val->name}}</option>
                                        @endforeach
                                    </select>
                                </h2>
                                <h4 class="inv-to">Payer</h4>

                                <select class="desk form-control" id="payer" style="color: black;" name="payer" >
                                    @foreach ($contacts->person_data as $val)
                                        <option value="{{$val->person_id}}">{{$val->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Transaction Date</h4>
                                <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="transaction_date" id="transaction_date" type="text" value="{{date('m/d/Y')}}" />
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to">Tags</h4>
                                <input type="text" class="form-control" id="tags" placeholder="Enter Tags">
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-invoice">
                    <thead>
                    <tr>
                        <th>Receive From</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="list_table">
                                       

                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: left !important" colspan="6">
                                <a class="btn btn-info " onclick="addData();"><i class="fa fa-plus"></i> Add Data </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left !important">
                                <h4 class="inv-to">Memo</h4>
                                <textarea rows="3" id="memo" class="form-control"></textarea>

                            </td>
                            <td class="text-right">
                                <p>Sub Total</p>
                                <p>Discount</p>
                                <p><strong>Total Amount</strong></p>
                            </td>
                            <td class="text-center">
                                <p id="subtotal">0</p>
                                <p id="discount_all">0</p>
                                <p><strong id="total_all">0</strong></p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-right " style="padding-right: 50px">
                                            
                <button type="submit"  type='button' class='btn btn-success'>
                    Create 
                </button>
            </div>
        </form>
    </div>
    @section('script')
        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-multi-select/js/jquery.quicksearch.js')}}"></script>
        <script src="{{asset('js/multi-select-init.js')}}"></script>
        <script src="{{asset('js/pickers-init.js')}}"></script>
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
            Date.prototype.addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }
            function checkTotal() {
                subtotalall=0;
                totalall=0;
                $.each($('#list_table tr'), function(i, v){     
                    total=$(this).find('#total').val() * 1;
                    subtotalall+=total;
                    totalall+=total;
                });
                $('#subtotal').html(subtotalall);
                $('#total_all , #total_amount').html(totalall);
            }
            $('#formInvoice').submit(function(e) {
                e.preventDefault();
                var form=new FormData();

                form.append('person_name', $('#person_name').val());
                form.append('email', $('#email').val());
                form.append('address', $('#address').val());
                form.append('transaction_date', $('#transaction_date').val());
                form.append('due_date', $('#due_date').val());
                form.append('terms', $('#terms').val());
                form.append('warehouse', $('#warehouse').val());
                form.append('reference_no', $('#reference_no').val());
                form.append('tags', $('#tags').val());
                form.append('memo', $('#memo').val());
                form.append('message', $('#message').val());
                $.each($('#list_table tr'), function(i, v){     
                    console.log('blabla');
                    form.append('detail['+i+'][product]',$(this).find('#product').val());
                    form.append('detail['+i+'][quantity]',$(this).find('#qty').val());
                    form.append('detail['+i+'][units]',$(this).find('#units').val());
                    form.append('detail['+i+'][price]',$(this).find('#unit_price').val());
                    form.append('detail['+i+'][discount]',$(this).find('#discount').val());
                    form.append('detail['+i+'][total]',$(this).find('#total').val());
                });

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/finance/sales/invoice/new')}}",
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        window.location.href = "{{ url('dashboard/finance/sales') }}";
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            })

            function addData() {
                $('#list_table').append('<tr><td><select class="desk form-control accountlist" id="account" style="color: black;" name="account" ></select></td><td><input type="text" rows="1" id="description" class="form-control"></td><td><input type="number" class="form-control" id="total" value="0" min="0"></td><td><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="detail" class="btn btn-danger btn-delete btn-sm"><i class="fas fa-trash"></i></a></td></tr>');
                getAccountList();
                $(".btn-delete").click(function() {
                    var elm=this;
                    var a=$(elm).parent().parent().remove();
                });
                $("select, input[type='number']").change(function () {
                    checkTotal();
                })
            }
            
            function getAccountList() {
                var url="{{ url('/dashboard/finance/chart/list') }}";
                
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        elm=$('#list_table tr:last-child .accountlist');
                        $.each(res.accounts, function(i, v){
                            elm.append('<option value='+v.id+'>'+v.number+" "+v.name+'</option>');
                        });
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            }
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




