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
            Manage Giro
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Giro</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Giro
                        <span class="pull-right">
                            <a href="#TransactionModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Giro <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                        </span>
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
                                        <label class="control-label">Customer Status
                                            <select class="form-control" id="nice_level" style="padding: 0px 10px;" name="nice_level" >
                                                <option value="2">
                                                    All Customer
                                                </option>
                                                <option value="1">
                                                    Nice Customer
                                                </option>
                                                <option value="0">
                                                    Bad Customer
                                                </option>
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
                            <table  class="display table table-striped" id="giro_table">
                                <thead>
                                    <tr>
                                        <th>
                                            Date Received
                                        </th>
                                        <th>
                                            Bank
                                        </th>
                                        <th>
                                            Giro Number
                                        </th>
                                        <th>
                                            Balance
                                        </th>
                                        <th id="filterheader">
                                            Customer

                                            <a id="CustomerFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('customer')"  class="fas fa-filter pull-right"></a>
                                            <div id="customerDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="customerSearch" class="form-control" onkeyup="searchFilter('customer')" placeholder="Search for customer name..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="CustomerFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($customer as $cust):?>
                                                            <div class="col-md-12">
                                                                <div class="form-check" style="padding: 5px;">
                                                                    <input class="form-check-input" name="customer" type="checkbox" value="{{$cust->company_name}}" checked>
                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                        {{$cust->company_name}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach?>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('customer')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('customer')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th id="filterheader">
                                            Invoice Number

                                            <a id="InvoiceFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('invoice')"  class="fas fa-filter pull-right"></a>
                                            <div id="invoiceDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="invoiceSearch" class="form-control" onkeyup="searchFilter('invoice')" placeholder="Search for Invoice..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="invoiceFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($transaction as $invoice):?>

                                                            <div class="col-md-12">
                                                                <div class="form-check" style="padding: 5px;">
                                                                    <input class="form-check-input" name="invoice" type="checkbox" value="{{$invoice->invoice_number}}" checked>
                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                        {{$invoice->invoice_number}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach?>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('invoice')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('invoice')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th id="filterheader">
                                            Status

                                            <a id="StatusFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('status')"  class="fas fa-filter pull-right"></a>
                                            <div id="statusDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="statusSearch" class="form-control" onkeyup="searchFilter('status')" placeholder="Search for Giro Status..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="statusFilterList" style="max-height: 200px; overflow-y: auto;">

                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="Cashed on" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Cashed
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="Rejected" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Rejected
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-check" style="padding: 5px;">
                                                                <input class="form-check-input" name="status" type="checkbox" value="Haven't Cashed" checked>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Haven't Cashed
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('invoice')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('invoice')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="girotable"></tbody>
                                
                    
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="TransactionModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="TransactionModalTitle">Transaction List</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="row">
                                                                    <div class="col-md-6" style="padding: 10px">
                                                                        <label style="float: right; width: 100%">Search: <input id="searchbartransaction" type="text" class="form-control" name=""></label>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <table  class="display table table-striped" id="transaction_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                Invoice Number
                                                                            </th>
                                                                            <th>
                                                                                Customer
                                                                                <a id="CustomerFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                                                            </th>
                                                                            <th>
                                                                                Level
                                                                                <a id="LevelFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                                                            </th>
                                                                            <th>
                                                                                Sales Name
                                                                                <a id="SalesFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                                                            </th>
                                                                            <th>
                                                                                Date
                                                                            </th>
                                                                            <th>
                                                                                Total Payment
                                                                            </th>
                                                                            <th>
                                                                                Payment Paid
                                                                            </th>
                                                                            <th>
                                                                                Product 
                                                                            </th>
                                                                            <th class="no-sort">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="transactiontable"></tbody>
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
                        </div>

                        <div aria-hidden="true" role="dialog"  id="GiroModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="GiroForm" name="GiroForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="GiroModalTitle">Form Title</h4>
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
                                                                        <li>
                                                                            <div class="title">Debt Remaining</div>
                                                                            <div class="desk" id="DebtRemaining"></div>
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
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Add Giro</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Bank</div>
                                                                            <select class=" form-control desk" id="id_bank" style="color: black;" name="id_bank" >
                                                                                <?php foreach ($banks as $bank):?>
                                                                                <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Giro Number</div>
                                                                            <input type="text"  class="form-control desk" style="color: black;" id="giro_number" name="giro_number" placeholder="Enter Giro Number">
                                                                        </li>
                                                                        
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Giro Balance</div>
                                                                            <input type="number" min="10000" class="form-control desk" style="color: black;" id="giro_balance" name="giro_balance" placeholder="Enter Giro Balance">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Date Received</div>
                                                                            <input class="form-control desk default-date-picker" style="color: black;" name="date" id="date" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                                        </li>
                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            
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
                        <div aria-hidden="true" role="dialog"  id="GiroDetailModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="GiroDetailForm" name="GiroDetailForm">

                                        <input type="hidden" name="id" id="detail_id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="GiroDetailModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Giro Detail</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Giro Number</div>
                                                                            <div class="desk" id="detail_giro_number"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Customer</div>
                                                                            <div class="desk" id="detail_customer"></div>
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Bank</div>
                                                                            <div class="desk" id="detail_bank"></div>
                                                                        </li>
                                                                        
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Balance</div>
                                                                            
                                                                            <div class="desk" id="detail_balance"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Date Received</div>
                                                                            
                                                                            <div class="desk" id="detail_date_received"></div>
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Invoice Number</div>
                                                                            
                                                                            <div class="desk" id="detail_invoice_number"></div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Cash Details</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Payment Account</div>
                                                                            <select class=" form-control desk" id="detail_id_payment_account" style="color: black;" name="id_payment_account" >
                                                                                <?php foreach ($accounts as $account):?>
                                                                                    <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Date Cashed</div>
                                                                            <input class="form-control desk default-date-picker" style="color: black;" name="date" id="detail_date" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                                        </li>

                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div onclick="reject()" id="btn-delete" class="btn btn-danger pull-left" style="display: inline !important;">Reject</div>
                                            <button type="submit" id="btn-submit" class="btn btn-success">Cashed</button>
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

                $("#searchbar").on("keyup", function() {
                    checkFilter();
                });
                $("#searchbartransaction").on("keyup", function() {
                    checkFilterTransaction();
                });
                $('#btn-search').click(function () {
                    getTables();
                })

                $("input[type='checkbox']").click(function() {
                    checkFilter();
                });
                
                
            });
            function getTables() {
                var from=$('#from').val();
                var to=$('#to').val();
                var nice=$('#nice_level').val();
                var company=$('#company').val();

                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/payment/giro/list') }}",
                    data: { from: from, to: to, nice: nice, company: company },
                    dataType: 'json',
                    success: function(res){
                        $('#girotable').html(res.data);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            
            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#girotable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var customer=false;
                    $.each($("input[name='customer']:checked"), function(){     
                        customer=( $(elm).children().eq(4).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||customer;
                    });

                    var invoice=false;
                    $.each($("input[name='invoice']:checked"), function(){     
                        invoice=( $(elm).children().eq(5).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||invoice;
                    });

                    var status=false;
                    $.each($("input[name='status']:checked"), function(){     
                        status=( $(elm).children().eq(6).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||status;
                    });

                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;



                    $(this).toggle(search && invoice && status && customer);
                });
            }
            function checkFilterTransaction() {
                var value = $("#searchbartransaction").val().toLowerCase();

                $("#transactiontable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbartransaction").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;



                    $(this).toggle(search );
                });
            }

            function add(){
                $('#GiroForm').trigger("reset");
                $('#carttable').html("");
                $('#GiroModalTitle').html("Add Giro");
                $('#id').val('');
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/payment/giro/transaction') }}",
                    success: function(res){
                        $('#transactiontable').html(res.data);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function addGiro(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/payment/giro/transaction/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#id').val(res.id);
                        $('#GiroModalTitle').html("Transaction Details");
                        $('#GiroModal').modal('show');                 
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
            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/payment/giro/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#detail_id').val(res.id);

                        $('#GiroDetailModalTitle').html("Giro Details");
                        $('#GiroDetailModal').modal('show');
                        $('#detail_balance').html(res.balance);
                        $('#detail_bank').html(res.bank.name);
                        $('#detail_customer').html(res.customer.company_name);
                        $('#detail_invoice_number').html(res.transaction.invoice_number);
                        $('#detail_giro_number').html(res.giro_number);
                        $('#detail_date_received').html(res.date_received);

                        if(res.status == "cashed"){
                            $('#btn-delete').css('display','none');
                            $('#btn-submit').css('display','none');
                        }else if(res.status == "rejected"){
                            $('#btn-delete').css('display','none');
                            $('#btn-submit').css('display','inline-block');
                        }else{
                            $('#btn-delete').css('display','inline-block');
                            $('#btn-submit').css('display','inline-block');

                        }

                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }

            $('#GiroForm').submit(function(e) {
                e.preventDefault();            
                if($('#DebtRemaining').html()<$('#GiroBalance').val()){
                    alert("Giro Balance Over!");
                }else{

                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/payment/giro/pay')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            getTables();
                            $('#GiroForm').trigger("reset");
                            $('#GiroModal').modal('hide');                 
                            $('#TransactionModal').modal('hide');                 

                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 

                }
            
            });
            function reject() {
                var id = $('#detail_id').val();
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/payment/giro/reject')}}",
                    data: { id : id },
                    dataType: 'json',
                    success: (data) => {
                        getTables();
                        $('#GiroDetailForm').trigger("reset");
                        $('#GiroDetailModal').modal('hide');
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            };

            $('#GiroDetailForm').submit(function(e) {
                e.preventDefault();            

                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/payment/giro/cash')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        getTables();
                        $('#GiroDetailForm').trigger("reset");
                        $('#GiroDetailModal').modal('hide');                  

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
