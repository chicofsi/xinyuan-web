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
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Payment History
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Payment History</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Payment History
                        
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="row">
                                <div class="col-md-8" style="padding: 10px">
                                    <div class="col-md-6">
                                        <label class="control-label">Date Range
                                            <div class="col-md-10 input-group input-large custom-date-range"  data-date-format="mm/dd/yyyy">
                                                <input id="from" type="text" class="form-control dpd1" name="from"  value="{{date('m/d/Y',strtotime("-7 days"))}}">
                                                <span class="input-group-addon">To</span>
                                                <input id="to" type="text" class="form-control dpd2" name="to" value="{{date('m/d/Y')}}">
                                            </div>
                                        </label>
                                        <button type="submit" id="btn-search" class="btn btn-info">Search</button>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Payment Account
                                            <select class="desk form-control" id="id_payment_account" style="color: black;" name="id_payment_account" >
                                                <option value="0">Show All</option>
                                                <?php foreach ($accounts as $account):?>
                                                    <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                <?php endforeach?>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="control-label">Company
                                            <select class="form-control" id="company" style="padding: 0px 10px;" name="company" >
                                                <option value="0">
                                                    All Company
                                                </option>
                                                @foreach ($company as $comp)
                                                    <option value="{{$comp->id}}">{{$comp->display_name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 10px">
                                    <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="transaction_table">
                                <thead>
                                    <tr>
                                        <th>
                                            Invoice Number
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Sales Name
                                        </th>
                                        <th>
                                            Customer
                                        </th>
                                        <th>Level</th>
                                        <th>
                                            Payment Account
                                        </th>
                                        <th>
                                            Paid
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="transactiontable"></tbody>
                                {{-- <tbody>
                                    <?php foreach ($menu_list as $menu):?>
                                    @csrf
                                    <tr>
                                        <td>{{$menu->id}}</td>
                                        <td><strong>{{$menu->menu_name}}</strong></td>
                                        <td>{{$menu->route}}</td>
                                        <td> @if($menu->active == '1')
                                                <span class="label label-success">Active</span>
                                             @else
                                                <span class="label label-warning">Unactive</span>
                                            @endif
                                        </td>
                                        <td> @if($menu->admin_access == '1')
                                                <span class="label label-success">Accessable</span>
                                             @else
                                                <span class="label label-warning">Unactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            
                                            <a href="#myModal" data-toggle="modal">
                                                <button type="button" class="btn btn-success" data-action="expand-all">Edit</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach?>
                                  --}}   
                                    
                                <tfoot>
                                    <tr>
                                        <th colspan="6">Total</th>
                                        <th id="total">
                                           
                                        </th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="PaymentModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="PaymentForm" name="PaymentForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PaymentModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Transaction Detail</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Invoice Number</div>
                                                                            <div class="desk" id="invoice_number"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Customer</div>
                                                                            <div class="desk" id="customer"></div>
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Sales</div>
                                                                            
                                                                            <div class="desk" id="sales"></div>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Payment Method</div>
                                                                            
                                                                            <div class="desk" id="payment"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Tempo</div>
                                                                            
                                                                            <div class="desk" id="tempo"></div>
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Deadline</div>
                                                                            
                                                                            <div class="desk" id="deadline"></div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Payment History</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table  class="display table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>
                                                                            Date
                                                                        </th>
                                                                        <th>
                                                                            Payment Balance
                                                                        </th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="paymenthistorytable"></tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>
                                                                            Date
                                                                        </th>
                                                                        <th>
                                                                            Payment Balance
                                                                        </th>
                                                                        
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Add Payment</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul class="p-info">
                                                                <li>
                                                                    <div class="title">Debt Remaining</div>
                                                                    <div class="desk" id="DebtRemaining"></div>
                                                                </li>
                                                                <li>
                                                                    <div class="title">Pay</div>
                                                                    <input type="number" min="1" class="form-control desk" style="color: black;" id="PayBalance" name="PayBalance" placeholder="Enter Pay Balance">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="btn-save" class="btn btn-success">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @section('script')
        <script src="{{asset('js/flot-chart/jquery.flot.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.tooltip.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.pie.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.selection.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.time.js')}}"></script>
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

                getTables();

                $("#searchbar").on("keyup", function() {
                    checkFilter();
                });
                $('#btn-search').click(function () {
                    getTables();
                })
            });
            function getTables() {
                var from=$('#from').val();
                var to=$('#to').val();
                var account=$('#id_payment_account').val();
                var company=$('#company').val();

                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/payment/history/list') }}",
                    data: { from: from, to: to, account: account, company: company },
                    dataType: 'json',
                    success: function(res){
                        $('#transactiontable').html(res.data);
                        $('#total').html(res.total);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#transactiontable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    // var area=false;
                    // $.each($("input[name='area']:checked"), function(){     
                    //     area=( $(elm).children().eq(3).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||area;
                    // });
 


                    $(this).toggle(search );
                });
            }

            function add(){
                $('#PaymentForm').trigger("reset");
                $('#carttable').html("");
                $('#PaymentModalTitle').html("Add Payment");
                $('#id').val('');
            }

            function pay(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/payment/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#id').val(res.id);
                        $('#PaymentModalTitle').html("Payment Details");
                        $('#PaymentModal').modal('show');                 
                        $('#DebtRemaining').html(parseInt(res.total_payment)-parseInt(res.paid));       
                        $('#PayBalance').attr('max',parseInt(res.total_payment)-parseInt(res.paid));       
                        $('#invoice_number').html(res.invoice_number);
                        $('#customer').html(res.customer.company_name);
                        $('#sales').html(res.sales.name);
                        $('#payment').html(res.payment);
                        $('#tempo').html(res.tempo);
                        $('#deadline').html(res.payment_deadline);


                        $('#paymenthistorytable').html(res.paymenthistory);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }

            function getPaymentHistory(id) {
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/payment/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#paymenthistorytable').html(res.paymenthistory);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }


            $('#PaymentForm').submit(function(e) {
                e.preventDefault();            
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/payment/pay')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        getTables();
                        getPaymentHistory($('#id').val());
                        $('#PaymentForm').trigger("reset");

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
