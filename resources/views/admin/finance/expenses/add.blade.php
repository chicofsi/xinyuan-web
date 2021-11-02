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

        <form method="post" id="formExpense">
            <div class="panel">
                <div class="panel-body invoice">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h2 class="invoice-title" id="title">Create Expenses</h2>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-top: 15px">
                            <h1 class="t-due">Total Amount </h1>
                            <h2 class="amnt-value" id="total_amount">0</h2>
                        </div>
                    </div>
                    <div class="invoice-address">

                        <div class="row" style="background-color: #424F63; padding-top: 20px;padding-bottom: 20px">
                            <div class="col-md-3 col-sm-4">
                                <h4 class="inv-to" id="receiver">Pay From *</h4>
                                <h2 class="corporate-id" >
                                    <select class="selectpicker  form-control" data-live-search="true" id="refund_from_name" style="color: black;" name="refund_from_name" >
                                        @foreach ($accounts->accounts  as $val)
                                            <option value="{{$val->name}}">{{"(".$val->number.") ".$val->name}}</option>
                                        @endforeach
                                    </select>
                                </h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to">Beneviciary</h4>
                                <select class="selectpicker  form-control" data-live-search="true" id="person_name" style="color: black;" name="person_name" >
                                    @foreach ($contacts->contact_list->contact_data->person_data  as $val)
                                        @if (! (count($val->color_coding)==1 && $val->color_coding[0]==1))
                                            <option value="{{$val->display_name}}">{{$val->display_name}} (@foreach ($val->color_coding as $element)
                                                @if ($element==1)
                                                    Customer
                                                @elseif ($element==2)
                                                    Vendor
                                                @elseif ($element==3)
                                                    Employee
                                                @elseif ($element==4)
                                                    Other
                                                @endif
                                                @if (! $loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                            )
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <h4 class="inv-to" >Billing Address</h4>
                                <textarea rows="3" id="address" class="form-control"></textarea>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Transaction Date</h4>
                                <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="transaction_date" id="transaction_date" type="text" value="{{date('m/d/Y')}}" />
                                <h4 class="inv-to" >Payment Method</h4>
                                <select class="desk form-control" id="payment_method" style="color: black;" name="payment_method" >
                                    @foreach ($payment_methods->payment_methods as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Expense No </h4>
                                <input type="text" class="form-control" id="transaction_no" placeholder="Enter Vendor Reference No">
                                <h4 class="inv-to">Tags</h4>
                                <input type="text" class="form-control" id="tags" placeholder="Enter Tags">
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
                        <th class="text-center">Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="expense_table">
                                       

                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: left !important" colspan="5">
                                <a class="btn btn-info " onclick="addData();"><i class="fa fa-plus"></i> Add Data </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left !important">
                                <h4 class="inv-to">Memo</h4>
                                <textarea rows="3" id="memo" class="form-control"></textarea>

                            </td>
                            <td class="text-right" colspan="2">
                                <p>Sub Total</p>
                                <p>Tax</p>
                                <p><strong>Total Amount</strong></p>
                            </td>
                            <td class="text-center" colspan="2">
                                <p id="subtotal">0</p>
                                <p id="taxall">0</p>
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
                $('body').append('<div class="loading"></div>');
                $('.loading').css("display",'none');

            });
            Date.prototype.addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }

            function getTerms() {
                $('.loading').css("display",'block');

                var url="{{ url('/dashboard/finance/terms/') }}/"+$('#terms').val();
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        $('#due_date').val(new Date($('#transaction_date').val()).addDays(res.term.longetivity).toLocaleDateString());
                        console.log($('#due_date').val());
                        $('.loading').css("display",'none');

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function checkTotal() {
                subtotalall=0;
                taxall=0;
                totalall=0;
                $.each($('#expense_table tr'), function(i, v){     
                    total=$(this).find('#amount').val();
                    taxpercentage=$(this).find('#tax option:selected').attr('rate');
                    tax=total*parseInt(taxpercentage)/100;
                    subtotalall+=parseInt(total);
                    taxall+=parseInt(tax);
                    totalall+=parseInt(total)+parseInt(tax);
                });
                $('#subtotal').html(subtotalall);
                $('#taxall').html(taxall);
                $('#total_all , #total_amount').html(totalall);
            }
            $('#formExpense').submit(function(e) {
                e.preventDefault();
                var form=new FormData();

                form.append('person_name', $('#person_name').val());
                form.append('refund_from_name', $('#refund_from_name').val());
                form.append('transaction_date', $('#transaction_date').val());
                form.append('payment_method_name', $('#payment_method option:selected').text());
                form.append('payment_method_id', $('#payment_method').val());
                form.append('transaction_no', $('#transaction_no').val());
                form.append('address', $('#address').val());
                form.append('memo', $('#memo').val());

                $.each($('#expense_table tr'), function(i, v){     
                    form.append('transaction_account_lines_attributes['+i+'][account_name]',$(this).find('#expense').val());
                    form.append('transaction_account_lines_attributes['+i+'][description]',$(this).find('#description').val());
                    form.append('transaction_account_lines_attributes['+i+'][debit]',$(this).find('#amount').val());
                    if($(this).find('#tax').val()!='0'){
                        form.append('transaction_account_lines_attributes['+i+'][line_tax_id]',$(this).find('#tax').val());
                        form.append('transaction_account_lines_attributes['+i+'][line_tax_name]',$(this).find('#tax option:selected').text());
                    }
                });

                $('.loading').css("display",'block');

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/finance/expenses/new')}}",
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        window.location.href = "{{ url('dashboard/finance/expenses') }}";
                        $('.loading').css("display",'none');

                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            })

            function addData() {
                $('#expense_table').append('<tr><td><select class="desk form-control expenselist" id="expense" style="color: black;" name="expense" ></select></td><td><textarea rows="1" id="description" class="form-control"></textarea></td><td><select class="desk form-control" id="tax" style="color: black;" name="tax" ></select></td><td><input type="number" class="form-control" id="amount" name="amount" min="0"></td><td><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="detail" class="btn btn-danger btn-delete btn-sm"><i class="fas fa-trash"></i></a></td></tr>');
                $(".btn-delete").click(function() {
                    var elm=this;
                    var a=$(elm).parent().parent().remove();
                });
                $("select, input[type='number']").change(function () {
                    checkTotal();
                });

                elm=$('#expense_table tr:last-child #expense');

                $(elm).parent().parent().find('#expense').html('');
                $('.loading').css("display",'block');

                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/finance/account/expense/') }}",
                    success: function(res){

                        $.each(res.cost.accounts,function (i,v) {
                            $(elm).parent().parent().find('#expense').append('<option value="'+v.name+'">('+v.number+') '+v.name+'</option>');
                            
                        })

                        $.each(res.expense.accounts,function (i,v) {
                            $(elm).parent().parent().find('#expense').append('<option value="'+v.name+'">('+v.number+') '+v.name+'</option>');
                            
                        })
                        $.each(res.other.accounts,function (i,v) {
                            $(elm).parent().parent().find('#expense').append('<option value='+v.name+'">('+v.number+') '+v.name+'</option>');
                            
                        })
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                $(elm).parent().parent().find('#tax').html('<option rate="0.0" value=0>no Tax</option>');
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/finance/taxes/list/') }}",
                    success: function(res){
                        $.each(res.company_taxes,function(i,v) {
                            $(elm).parent().parent().find('#tax').append('<option rate='+v.rate+' value='+v.id+'>'+v.name+'</option>');
                        });                        
                        $('.loading').css("display",'none');

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




