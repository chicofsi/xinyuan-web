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
        .dropdown {
          position: relative;
          display: inline-block;
        }

        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #ffffff;
          min-width: 200px;
          max-width: 300px;
          max-height: 400px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          margin-top: 10px;
          z-index: 1;
        }

        .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
        }

        .dropdown-content a:hover {background-color: #ddd}

        .show {display:block;}
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
            Manage Purchase Payment
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Purchase Payment</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Purchase Payment
                        
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="row">
                                <div class="col-md-8" style="padding: 10px">
                                    <div class="col-md-8">
                                        <label class="control-label">Date Range
                                            <div class="col-md-10 input-group input-large custom-date-range"  data-date-format="mm/dd/yyyy">
                                                <input id="from" type="text" class="form-control dpd1" name="from"  value="{{date('m/d/Y',strtotime("-7 days"))}}">
                                                <span class="input-group-addon">To</span>
                                                <input id="to" type="text" class="form-control dpd2" name="to" value="{{date('m/d/Y')}}">
                                            </div>
                                        </label>
                                        <button type="submit" id="btn-search" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 10px">
                                    <label style="float: right; width: 100%">Search:

                                    <div class="input-group">
                                        <input id="searchbar" type="text" class="form-control" name="">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" id="btn-search-input" type="button">Search</button>
                                        </span>
                                    </div>
                                    </label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="transaction_table">
                                <thead>
                                    <tr>
                                        <th>
                                            Invoice Number
                                        </th>
                                        <th id="filterheader">
                                            Factories
                                            <a id="FactoryFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('factory')"  class="fas fa-filter pull-right"></a>
                                            <div id="factoryDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="factorySearch" class="form-control" onkeyup="searchFilter('factory')" placeholder="Search for Factory..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="factoryFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($factories as $factory):?>

                                                            <div class="col-md-12">
                                                                <div class="form-check" style="padding: 5px;">
                                                                    <input class="form-check-input" name="factory" type="checkbox" value="{{$factory->name}}" checked>
                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                        {{$factory->name}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach?>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('factory')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('factory')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Total Payment (in IDR)
                                        </th>
                                        <th>
                                            Payment Paid (in IDR)
                                        </th>

                                        <th>
                                            Total Payment
                                        </th>
                                        <th>
                                            Payment Paid
                                        </th>
                                        <th>
                                            Debt
                                        </th>
                                        <th>
                                            Debt Due Date
                                        </th>
                                        <th id="filterheader">
                                            Payment Status

                                            <a id="StatusFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('status')"  class="fas fa-filter pull-right"></a>
                                            <div id="statusDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="statusSearch" class="form-control" onkeyup="searchFilter('status')" placeholder="Search for Payment Status..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="statusFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="warning" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Due Date Today
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="danger" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Late Payment
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="info" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Haven't Paid
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="success" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Payment Done
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('status')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('status')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="no-sort">Action</th>
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
                                                                            <div class="title">Factories</div>
                                                                            <div class="desk" id="factories"></div>
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Currency</div>
                                                                            <div class="desk" id="currency"></div>
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
                                                                        <th>
                                                                            Date
                                                                        </th>
                                                                        <th>
                                                                            Payment Account
                                                                        </th>
                                                                        <th>
                                                                            Balance
                                                                        </th>
                                                                        <th>
                                                                            Note
                                                                        </th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="paymenthistorytable"></tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th colspan="2">
                                                                            Total
                                                                        </th>
                                                                        <th id="paid_payment">
                                                                            
                                                                        </th>
                                                                        <th colspan="2">
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
                                                                <li id="currency_rate">
                                                                    <div class="title">Currency Rate</div>
                                                                    <input type="number" min="1" class="form-control desk" style="color: black;" id="rates" name="rates" placeholder="Enter Currency Rate">
                                                                </li>
                                                                <li>
                                                                    <div class="title">Payment Account</div>
                                                                    <select class="desk form-control" id="id_payment_account" style="color: black;" name="id_payment_account" >
                                                                        <?php foreach ($accounts as $account):?>
                                                                            <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </li>
                                                                <li>
                                                                    <div class="title">Payment Date</div>
                                                                    <input class="form-control desk default-date-picker" style="color: black;" name="date" id="date" size="16" type="text" value="{{date('m/d/Y')}}" />
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
                        <div aria-hidden="true" role="dialog"  id="EditPaymentModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="EditPaymentForm" name="EditPaymentForm">

                                        <input type="hidden" name="id" id="editid">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="EditPaymentModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">

                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Edit Payment</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul class="p-info">
                                                                <li>
                                                                    <div class="title">Max Payment</div>
                                                                    <div class="desk" id="MaxPayment"></div>
                                                                </li>
                                                                <li>
                                                                    <div class="title">Pay</div>
                                                                    <input type="number" min="1" class="form-control desk" style="color: black;" id="editPayBalance" name="PayBalance" placeholder="Enter Pay Balance">
                                                                </li>
                                                                <li>
                                                                    <div class="title">Currency Rate</div>
                                                                    <input type="number" min="1" class="form-control desk" style="color: black;" id="editrates" name="rates" placeholder="Enter Currency Rate">
                                                                </li>
                                                                <li>
                                                                    <div class="title">Payment Account</div>
                                                                    <select class="desk form-control" id="editid_payment_account" style="color: black;" name="id_payment_account" >
                                                                        <?php foreach ($accounts as $account):?>
                                                                            <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </li>
                                                                <li>
                                                                    <div class="title">Payment Date</div>
                                                                    <input class="form-control desk default-date-picker" style="color: black;" name="date" id="editdate" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3"></div>
                                                    
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

            window.onclick = function(event) {
                if (!event.target.matches('#filterheader, #filterheader *') ) {
                    hideAllDropdown();
                }
            }
            function hideAllDropdown() {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
            function showDropdown(type) {
                hideAllDropdown();
                document.getElementById(type+"Dropdown").classList.toggle("show");
            }

            function clearSelection(type) {
                $.each($("input[name='"+type+"']"), function(){     
                    $(this).prop("checked",false);
                });
                checkFilter();
            }
            function allSelection(type) {
                $.each($("input[name='"+type+"']"), function(){     
                    $(this).prop("checked",true);
                });
                checkFilter();
            }

            function searchFilter(type) {
                $("#"+type+"FilterList div").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;

                    var searchtext=$("#"+type+"Search").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    $(this).toggle(search);
                });
            }

            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                getTables();

                $('#btn-search-input').click(function () {
                    checkFilter();
                })
                $('#btn-search').click(function () {
                    getTables();
                })                
                $("input[type='checkbox']").click(function() {
                    checkFilter();
                });
            });
            $('#editdate').datepicker({ dateFormat: 'mm/dd/yyyy' });
            
            $('#date').datepicker({ dateFormat: 'mm/dd/yyyy' });
            
            function getTables() {
                var from=$('#from').val();
                var to=$('#to').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/payment/list') }}",
                    data: { from: from, to: to },
                    dataType: 'json',
                    success: function(res){
                        $('#transactiontable').html(res.data);

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

                    var factory=false;
                    $.each($("input[name='factory']:checked"), function(){     
                        factory=( $(elm).children().eq(1).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||factory;
                    });

                    var status=false;
                    $.each($("input[name='status']:checked"), function(){     
                        status=( $(elm).children().eq(9).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||status;
                    });
                    $(this).toggle(search && factory && status);
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
                    url: "{{ url('/dashboard/purchase/payment/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#id').val(res.id);
                        $('#PaymentModalTitle').html("Payment Details");
                        $('#PaymentModal').modal('show');                 
                        $('#DebtRemaining').html(res.debt);       
                        $('#PayBalance').attr('max',parseInt(res.total_payment_idr)-parseInt(res.paid_idr));       
                        $('#paid_payment').html(parseInt(res.paid_idr));       
                        $('#invoice_number').html(res.invoice_number);
                        $('#factories').html(res.factories.name);
                        $('#currency').html(res.currency.name);
                        if(res.currency.name=="IDR"){
                            $('#currency_rate').css('display','none');
                        }else{
                            $('#currency_rate').css('display','inline-block');

                        }
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

            function editPayment(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/payment/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#editid').val(res.id);
                        $('#EditPaymentModalTitle').html("Edit Payment");
                        $('#EditPaymentModal').modal('show');                    
                        $('#editPayBalance').val(res.paid);       
                        $('#editid_payment_account').val(res.id_payment_account);       
                        $('#editrates').val(res.rates);       
                        $('#editdate').val(res.date);       
                        $('#MaxPayment').html(parseInt(res.transaction.total_payment)-parseInt(res.transaction.paid)+parseInt(res.paid));



                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }

            function getPaymentHistory(id) {
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/payment/detail') }}",
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
                if(parseInt($('#DebtRemaining').html())<parseInt($('#PayBalance').val())){
                    alert("Pay Balance Over!");
                }else{

                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/purchase/payment/pay')}}",
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

                }
            
                
            
               
            });

            $('#EditPaymentForm').submit(function(e) {
                e.preventDefault();            
                if(parseInt($('#MaxPayment').html())<parseInt($('#editPayBalance').val())){
                    alert("Pay Balance Over!");
                }else{

                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/purchase/payment/update')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $('#EditPaymentModal').modal('hide');                    
                            getTables();
                            getPaymentHistory($('#id').val());
                            $('#EditPaymentForm').trigger("reset");

                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 

                }
            
            });

        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>
