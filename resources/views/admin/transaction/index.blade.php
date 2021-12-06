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
            Manage Transaction
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Transaction</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Transaction
                        <span class="pull-right">
                            <a href="{{url('/dashboard/transaction/full')}}" class=" btn btn-success btn-sm">View Full <i class="fa fa-plus"></i></a>
                            <a href="#TransactionModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Transaction <i class="fa fa-plus"></i></a>
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
                                        <button id="btn-export" onclick="export_data()" class="btn btn-danger">Export Excel</button>
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
                            <table  class="display table table-striped" id="transaction_table">
                                <thead>
                                    <tr>
                                        <th>
                                            Invoice Number
                                        </th> 
                                        <th id="CustomerHeader">
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
                                        <th id="LevelHeader">
                                            Level
                                            <a id="LevelFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('level')"  class="fas fa-filter pull-right"></a>
                                            <div id="levelDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="levelSearch" class="form-control" onkeyup="searchFilter('level')" placeholder="Search for customer level..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="LevelFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($level as $lev):?>

                                                            <div class="col-md-12">
                                                                <div class="form-check" style="padding: 5px;">
                                                                    <input class="form-check-input" name="level" type="checkbox" value="{{$lev->level}}" checked>
                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                        {{$lev->level}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach?>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('level')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('level')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th id="SalesHeader">
                                            Sales Name
                                            <a id="SalesFilter" style="text-decoration: none;color: #dddddd"  onclick="showDropdown('sales')"  class="fas fa-filter pull-right"></a>
                                            <div id="salesDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="levelSearch" class="form-control" onkeyup="searchFilter('sales')" placeholder="Search for Sales Name..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="SalesFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($sales as $sal):?>

                                                            <div class="col-md-12">
                                                                <div class="form-check" style="padding: 5px;">
                                                                    <input class="form-check-input" name="sales" type="checkbox" value="{{$sal->name}}" checked>
                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                        {{$sal->name}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach?>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('sales')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('sales')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <th>
                                            Company 
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
                                    
                                <tfoot>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Customer</th>
                                        <th>Level</th>
                                        <th>Sales Name</th>
                                        <th>Date</th>
                                        <th>Total Payment</th>
                                        <th>Payment Paid</th>
                                        <th>Product</th>
                                        <th>Company</th>
                                        <th>Action</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="TransactionModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="TransactionForm" name="TransactionForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="TransactionModalTitle">Form Title</h4>
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
                                                                            <input type="text" class="form-control desk" style="color: black;" id="invoice_number" name="invoice_number" placeholder="Enter Invoice Number">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Customer</div>

                                                                            <select class="desk form-control" id="id_customer"style="color: black;" name="id_customer" >
                                                                                @foreach ($customer as $cust)
                                                                                    <option value="{{$cust->id}}">{{$cust->company_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Transaction Date</div>
                                                                            <input data-date-format="mm/dd/yyyy" class="form-control desk default-date-picker" style="color: black;" name="date" id="date" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Warehouse</div>
                                                                            <select class="desk form-control" id="id_warehouse" style="color: black;" name="id_warehouse" >
                                                                                <?php foreach ($warehouses as $warehouse):?>
                                                                                    <option value="{{$warehouse->id}}">{{$warehouse->name}} </option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Payment Method</div>
                                                                            <select class="desk form-control" id="payment" style="color: black;" name="payment" >
                                                                                <option value="cash">cash</option>
                                                                                <option value="postpaid">postpaid</option>
                                                                            </select>
                                                                        </li>
                                                                        <li id="payment_account_input">
                                                                            <div class="title">Payment Account</div>
                                                                            <select class="desk form-control" id="id_payment_account" style="color: black;" name="id_payment_account" >
                                                                                <?php foreach ($accounts as $account):?>
                                                                                    <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li id="tempo_input" style="display: none">
                                                                            <div class="title">Tempo</div>
                                                                            <select class="desk form-control" id="tempo"style="color: black;" name="tempo" >
                                                                                <option value="0">0 Days</option>
                                                                                <option value="7">7 Days</option>
                                                                                <option value="15">15 Days</option>
                                                                                <option value="30">30 Days</option>
                                                                                <option value="45">45 Days</option>
                                                                                <option value="60">60 Days</option>
                                                                                <option value="75">75 Days</option>
                                                                                <option value="90">90 Days</option>
                                                                            </select>
                                                                        </li>

                                                                        <li id="tempo_input" >
                                                                            <div class="title">Company</div>
                                                                            <select class="desk form-control" id="company"style="color: black;" name="company" >
                                                                                @foreach ($company as $comp)
                                                                                    <option value="{{$comp->id}}">{{$comp->display_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel">
                                                        <header class="panel-heading">
                                                            Product
                                                            <span class="pull-right">
                                                                <a href="#ProductModal" data-toggle="modal" class=" btn btn-primary btn-sm">Add Product <i class="fa fa-plus"></i></a>
                                                                {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                                                            </span>
                                                        </header>
                                                        <div class="panel-body">
                                                            <div class="row">

                                                                <div class="col-md-12">

                                                                    <table class="display table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>
                                                                                    Photo 
                                                                                </th>
                                                                                <th>
                                                                                    Type
                                                                                </th>
                                                                                <th>
                                                                                    Size
                                                                                </th>
                                                                                <th>
                                                                                    Weight(gr)
                                                                                </th>
                                                                                <th>
                                                                                    Gross Weight (Kg)
                                                                                </th>
                                                                                <th>
                                                                                    Colour
                                                                                </th>
                                                                                <th>
                                                                                    Logo
                                                                                </th>
                                                                                <th>
                                                                                    Factory Name
                                                                                </th>
                                                                                <th>
                                                                                    Input
                                                                                </th>
                                                                                <th class="no-sort">Subtotal</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="carttable">
                                                                            <tr>
                                                                                <td colspan="11">
                                                                                    No Items
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan="10">Total</th>
                                                                                <th id="total_payment">0</th>

                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="panel" id="returned_item">
                                                        <header class="panel-heading">
                                                            Returned Item
                                                            
                                                        </header>
                                                        <div class="panel-body">
                                                            <div class="row">

                                                                <div class="col-md-12">

                                                                    <table class="display table ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>
                                                                                    Date Returned
                                                                                </th>
                                                                                <th>
                                                                                    Cashback
                                                                                </th>
                                                                                <th>
                                                                                    Type
                                                                                </th>
                                                                                <th>
                                                                                    Size
                                                                                </th>
                                                                                <th>
                                                                                    Weight(gr)
                                                                                </th>
                                                                                <th>
                                                                                    Gross Weight (Kg)
                                                                                </th>
                                                                                <th>
                                                                                    Colour
                                                                                </th>
                                                                                <th>
                                                                                    Logo
                                                                                </th>
                                                                                <th>
                                                                                    Factory Name
                                                                                </th>
                                                                                <th>
                                                                                    Quantity
                                                                                </th>
                                                                                <th class="no-sort">Product Cashback</th>
                                                                                <th class="no-sort">Total Cashback</th>
                                                                                <th class="no-sort">Note</th>
                                                                                <th class="no-sort">Edit</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="returntable">
                                                                            <tr>
                                                                                <td colspan="13">
                                                                                    No Items
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan="12">Total</th>
                                                                                <th id="total_cashback">0</th>

                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                            </div>






                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button onclick="deleteTransaction()" id="btn-delete" class="btn btn-danger pull-left" style="display: inline !important;">Delete Transaction</button>
                                            <div onclick="productReturn()" id="btn-add-return" class="btn btn-info pull-left">Return Product</div>
                                            <button type="submit" id="btn-save" class="btn btn-success">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div aria-hidden="true" role="dialog"  id="ProductModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="ProductModalTitle">Product List</h4>
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
                                                                        <label style="float: right; width: 100%">Search: <input id="searchbarproduct" type="text" class="form-control" name=""></label>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <table class="display table table-striped" id="product_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>
                                                                                Photo 
                                                                            </th>
                                                                            <th>
                                                                                Type
                                                                            </th>
                                                                            <th>
                                                                                Size
                                                                            </th>
                                                                            <th>
                                                                                Weight(gr)
                                                                            </th>
                                                                            <th>
                                                                                Gross Weight (Kg)
                                                                            </th>
                                                                            <th>
                                                                                Colour
                                                                            </th>
                                                                            <th>
                                                                                Logo
                                                                            </th>
                                                                            <th>
                                                                                Factory Name
                                                                            </th>
                                                                            <th class="no-sort">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="producttable"></tbody>
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
                        <div aria-hidden="true" role="dialog"  id="TransactionProductModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="TransactionReturnForm" name="TransactionReturnForm">
                                        <input type="hidden" name="id" id="idRefund">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="TransactionProductModalTitle">Select Product to return</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Return Detail</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Transaction Date</div>
                                                                            <input data-date-format="mm/dd/yyyy" class="form-control desk default-date-picker" style="color: black;" name="date" id="return_date" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Cashback</div>
                                                                            <input type='number' class='form-control desk' style='color: black;' id='cashback' name='cashback' placeholder='Cashback' value="0" min="0">
                                                                        </li>
                                                                        
                                                                        <li>
                                                                            <div class="title">Note</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="note" name="note" placeholder="Enter Note">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Payment Account</div>
                                                                            <select class="desk form-control" id="return_id_payment_account" style="color: black;" name="id_payment_account" >
                                                                                <?php foreach ($accounts as $account):?>
                                                                                    <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="display table table-striped" id="transaction_product_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>
                                                                                    Photo 
                                                                                </th>
                                                                                <th>
                                                                                    Type
                                                                                </th>
                                                                                <th>
                                                                                    Size
                                                                                </th>
                                                                                <th>
                                                                                    Weight(gr)
                                                                                </th>
                                                                                <th>
                                                                                    Gross Weight (Kg)
                                                                                </th>
                                                                                <th>
                                                                                    Colour
                                                                                </th>
                                                                                <th>
                                                                                    Logo
                                                                                </th>
                                                                                <th>
                                                                                    Factory Name
                                                                                </th>
                                                                                <th>
                                                                                    Quantity
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="transactionproducttable"></tbody>
                                                                    </table>
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
                if (!event.target.matches('#CustomerHeader, #CustomerHeader *, #LevelHeader, #LevelHeader *, #SalesHeader, #SalesHeader *') ) {
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
                switch(type) {
                    case "customer":
                        document.getElementById("customerDropdown").classList.toggle("show");
                        break;
                    case "level":
                        document.getElementById("levelDropdown").classList.toggle("show");
                        break;
                    case "sales":
                        document.getElementById("salesDropdown").classList.toggle("show");
                        break;
                }
            }

            function clearSelection(type) {
                switch(type) {
                    case "customer":
                        $.each($("input[name='customer']"), function(){     
                            $(this).prop("checked",false);
                        });
                        checkFilter();
                        break;
                    case "level":
                        $.each($("input[name='level']"), function(){     
                            $(this).prop("checked",false);
                        });
                        checkFilter();
                        break;
                    case "sales":
                        $.each($("input[name='sales']"), function(){     
                            $(this).prop("checked",false);
                        });
                        checkFilter();
                        break;
                }
            }
            function allSelection(type) {
                switch(type) {
                    case "customer":
                        $.each($("input[name='customer']"), function(){     
                            $(this).prop("checked",true);
                        });
                        checkFilter();
                        break;
                    case "level":
                        $.each($("input[name='level']"), function(){     
                            $(this).prop("checked",true);
                        });
                        checkFilter();
                        break;
                    case "sales":
                        $.each($("input[name='sales']"), function(){     
                            $(this).prop("checked",true);
                        });
                        checkFilter();
                        break;
                }
            }

            function searchFilter(type) {
                switch(type) {
                    case "customer":
                        $("#CustomerFilterList div").filter(function() {
                            var value=$(this).text().toLowerCase();
                            var elm=this;

                            var searchtext=$("#customerSearch").val().toLowerCase();
                            var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                            $(this).toggle(search);
                        });
                        break;
                    case "level":
                        $("#LevelFilterList div").filter(function() {
                            var value=$(this).text().toLowerCase();
                            var elm=this;

                            var searchtext=$("#levelSearch").val().toLowerCase();
                            var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                            $(this).toggle(search);
                        });
                        break;
                    case "sales":
                        $("#SalesFilterList div").filter(function() {
                            var value=$(this).text().toLowerCase();
                            var elm=this;

                            var searchtext=$("#salesSearch").val().toLowerCase();
                            var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                            $(this).toggle(search);
                        });
                        break;
                }

            }
            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#transactiontable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    var customer=false;
                    $.each($("input[name='customer']:checked"), function(){     
                        customer=( $(elm).children().eq(1).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||customer;
                    });

                    var level=false;
                    $.each($("input[name='level']:checked"), function(){     
                        level=( $(elm).children().eq(2).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||level;
                    });

                    var sales=false;
                    $.each($("input[name='sales']:checked"), function(){     
                        sales=( $(elm).children().eq(3).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||sales;
                    });

                    $(this).toggle(search && customer && level && sales);
                });
            }


            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                getTables();
                getProduct();

                $("#searchbar").on("keyup", function() {
                    checkFilter();
                });

                $("input[type='checkbox']").click(function(){
                    checkFilter();
                });

                $('#payment').change( function() {
                    if($('#payment').val()=='cash'){
                        $('#payment_account_input').css("display", "block");
                        $('#tempo_input').css("display", "none");
                    }else{
                        $('#payment_account_input').css("display", "none");
                        $('#tempo_input').css("display", "block");
                    }
                });

                $('#btn-search').click(function () {
                    getTables();
                });
                $("#searchbarproduct").on("keyup", function() {
                    checkFilterProduct();
                });
                
                
            });
            function deleteTransaction() {
                var id=$('#id').val();
                
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/transaction/delete') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#TransactionModal').modal('hide');
                        getTables();
                        

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function getTables() {
                var from=$('#from').val();
                var to=$('#to').val();
                var nice=$('#nice_level').val();
                var company=$('#company').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/transaction/list') }}",
                    data: { from: from, to: to, nice:nice, company:company },
                    dataType: 'json',
                    success: function(res){
                        $('#transactiontable').html(res.data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function checkFilterProduct() {

                $("#producttable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbarproduct").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    $(this).toggle(search);
                });
            }

            function add(){
                $('#btn-delete').css('display','none');
                $('#btn-add-return').css('display','none');
                $('#TransactionForm').trigger("reset");
                $('#carttable').html("");
                $('#TransactionModalTitle').html("Add Transaction");
                $('#id').val('');
                $('#transactionproducttable').html("");
                $('#returned_item').css('display','none');
                $('#returntable').html("");
                checkTotalPayment();
            }
            function productReturn(){
                $('#TransactionProductModal').modal('show');
                $('#idRefund').val('');
            }

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/transaction/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#btn-add-return').css('display','inline');
                        $('#btn-delete').css('display','inline');

                        $('#id').val(res.id);
                        $('#carttable').html("");
                        $('#transactionproducttable').html("");
                        $('#returntable').html("");

                        $('#invoice_number').val(res.invoice_number);
                        $('#id_customer').val(res.id_customer);
                        $('#id_sales').val(res.id_sales);
                        $('#payment').val(res.payment);
                        $('#tempo').val(res.tempo);
                        $('#date').val(res.date);
                        $('#company').val(res.company);

                        $('#TransactionModalTitle').html("Transaction Details");
                        $('#TransactionModal').modal('show');
                        $.each(res.transactiondetails, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getbyid') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    $('#carttable').append("<tr><td>"+v.id+'<input type="hidden" name="id" id="id_transaction_details" value="'+v.id+'">'+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' value="+v.quantity+" placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' value="+v.price+" placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>"+v.total+"</td></tr>");

                                    $('#carttable #quantity').each(function() {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;

                                            if($(this).parent().parent().parent().parent().find('#price').val()){
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            quantity=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity);
                                            checkTotalPayment();
                                        })
                                    })
                                    
                                    $('#carttable #price').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            }
                                            price=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity);
                                            checkTotalPayment();
                                        })
                                    })

                                    checkTotalPayment();

                                    

                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getreturn') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    $('#transactionproducttable').append(data.data);

                                    $('#transactionproducttable tr:eq('+i+')').children().eq(0).text(res.transactiondetails[i].id);
                                    $('#transactionproducttable tr:eq('+i+')').children().eq(9).find('#max-qty').html(res.transactiondetails[i].totalprod);

                                    $('#transactionproducttable tr:eq('+i+')').children().eq(9).find('#price').html(res.transactiondetails[i].price);
                                    $('#transactionproducttable tr:eq('+i+')').children().eq(10).text(res.transactiondetails[i].total);

                                    

                                    
                                    
                                    
                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                        });

                        if(res.transactionrefund.length===0){
                            $('#returned_item').css('display','none');
                        }else{
                            $('#returned_item').css('display','block');

                        }
                        $.each(res.transactionrefund, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/transaction/return/show') }}",
                                data: { id: v.id },
                                dataType: 'json',
                                success: function(data){
                                    $('#returntable').append(data.data);

                                    checkTotalCashback();
                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                            
                        });
                        

                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                checkTotalCashback();
                
            }
            function refreshData(){
                var id=$('#id').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/transaction/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#btn-add-return').css('display','inline');
                        $('#btn-delete').css('display','inline');

                        $('#id').val(res.id);
                        $('#carttable').html("");
                        $('#transactionproducttable').html("");
                        $('#returntable').html("");

                        $('#invoice_number').val(res.invoice_number);
                        $('#id_customer').val(res.id_customer);
                        $('#id_sales').val(res.id_sales);
                        $('#payment').val(res.payment);
                        $('#tempo').val(res.tempo);
                        $('#date').val(res.date);
                        $('#company').val(res.company);


                        $('#TransactionModalTitle').html("Transaction Details");
                        $('#TransactionModal').modal('show');
                        $.each(res.transactiondetails, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getbyid') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    $('#carttable').append("<tr><td>"+v.id+'<input type="hidden" name="id" id="id_transaction_details" value="'+v.id+'">'+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' value="+v.quantity+" placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' value="+v.price+" placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>"+v.total+"</td></tr>");
                                    $('#carttable #quantity').each(function() {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;

                                            if($(this).parent().parent().parent().parent().find('#price').val()){
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            quantity=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity);
                                            checkTotalPayment();
                                        })
                                    })
                                    
                                    $('#carttable #price').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            }
                                            price=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity);
                                            checkTotalPayment();
                                        })
                                    })
                                    checkTotalPayment();

                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                            

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getreturn') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    $('#transactionproducttable').append(data.data);

                                    $('#transactionproducttable tr:eq('+i+')').children().eq(0).text(res.transactiondetails[i].id);
                                    $('#transactionproducttable tr:eq('+i+')').children().eq(9).find('#max-qty').html(res.transactiondetails[i].totalprod);

                                    $('#transactionproducttable tr:eq('+i+')').children().eq(9).find('#price').html(res.transactiondetails[i].price);
                                    $('#transactionproducttable tr:eq('+i+')').children().eq(10).text(res.transactiondetails[i].total);
                                    

                                    
                                    
                                    
                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                            
                        });
                        if(res.transactionrefund.length===0){
                            $('#returned_item').css('display','none');
                        }else{
                            $('#returned_item').css('display','block');

                        }
                        $.each(res.transactionrefund, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/transaction/return/show') }}",
                                data: { id: v.id },
                                dataType: 'json',
                                success: function(data){
                                    $('#returntable').append(data.data);

                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                            
                        });
                        

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                checkTotalCashback();

                
            }

            function addproduct(id) {

                var a=false;
                if(a){
                    $('#ProductModal').modal('hide');   
                }else{
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/product/getbyid') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(data){
                            $('#ProductModal').modal('hide');
                            $('#carttable').append("<tr><td>"+data.data.id+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity'  placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>0</td></tr>");
                    

                            $('#carttable #quantity').each(function() {
                                $(this).change(function () {
                                    var price=0;
                                    var quantity=0;

                                    if($(this).parent().parent().parent().parent().find('#price').val()){
                                        price=$(this).parent().parent().parent().parent().find('#price').val();
                                    }
                                    quantity=$(this).val();
                                    $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity);
                                    checkTotalPayment();
                                })
                            })
                            
                            $('#carttable #price').each(function () {
                                $(this).change(function () {
                                    var price=0;
                                    var quantity=0;

                                    if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                        quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                    }
                                    price=$(this).val();
                                    $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity);
                                    checkTotalPayment();
                                })
                            })
                            
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
                
            }

            function checkTotalPayment() {
                var total_payment=0;
                $('#carttable tr').filter(function() {
                    var elm=this;

                    total_payment+= parseInt($(elm).children().eq(10).text()) ;
                    
                });
                $('#total_payment').html(total_payment);
            }
            function checkTotalCashback() {
                var total_cashback=0;
                $('#returntable tr ').filter(function() {
                    var elm=this;

                    total_cashback+= parseInt($(elm).find(".cashback").text()) ;
                    
                });
                $('#total_cashback').html(total_cashback);
            }

            function deleteProduct(id) {
                $("#carttable tr").filter(function() { 
                    var elm=this;

                    a=( $(elm).children().eq(0).text().toLowerCase().indexOf(id) > -1 );
                    if(a){
                        $(this).remove();
                    }
                });
            }
            $('#date').datepicker({ dateFormat: 'mm/dd/yyyy' });

            function getProduct(){
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/product/addtocart') }}",
                    success: function(res){
                        $('#producttable').html(res.data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }
            function editRefund(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/transaction/refund/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#idRefund').val(res.id);

                        $('#TransactionProductModal').modal('show');
                        $('#cashback').val(res.cashback);
                        $('#return_date').val(res.date);
                        $('#note').val(res.note);

                        $.each(res.transactionreturn, function(i, v){  
                            $("#transactionproducttable tr").filter(function() {
                                var searchtext=v.id_transaction_details;
                                var search=$(this).children().eq(0).text() == searchtext;
                                console.log($(this).children().eq(0).text());
                                if(search){
                                    $(this).children().eq(9).find('#quantity').val(v.qty);
                                }
                            });
                            
                        });
                        

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            }

            $('#TransactionReturnForm').submit(function (e) {
                e.preventDefault();
                var form=new FormData();

                form.append('id_transaction', $('#id').val());
                form.append('date', $('#return_date').val());
                form.append('cashback', $('#cashback').val());
                form.append('note', $('#note').val());
                form.append('id_payment_account', $('#return_id_payment_account').val());

                var total_cashback = parseInt($('#cashback').val());
                $('#transactionproducttable tr').filter(function() {
                    var elm=this;
                    if($(elm).children().eq(9).find('#quantity').val()>0 && $(elm).children().eq(9).find('#quantity').val().length!=0){
                        total_cashback+= (parseInt($(elm).children().eq(9).find('#quantity').val())) * (parseInt($(elm).children().eq(9).find('#price').html())) ;
                    }
                });

                form.append('total_cashback', total_cashback);

                var url;
                if($('#idRefund').val()){
                    form.append('id', $('#idRefund').val());
                    url="{{ url('/dashboard/transaction/refund/edit')}}";
                }else{
                    url="{{ url('/dashboard/transaction/refund/store')}}";

                }


                $.ajax({
                    type:'POST',
                    url: url,
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {

                        $('#transactionproducttable tr').each(function (index, element) {
                            var elm=this;
                            var product=new Array();
                            var form2=new FormData();
                            if( $(elm).children().eq(9).find('#quantity').val()>0 && $(elm).children().eq(9).find('#quantity').val().length!=0) {
                                form2.append('id_transaction_refund', data.id);
                                form2.append('id_transaction_details', $(elm).children().eq(0).text());
                                form2.append('qty', $(elm).children().eq(9).find('#quantity').val());

                                var total_refund= parseInt($(elm).children().eq(9).find('#quantity').val()) * parseInt($(elm).children().eq(9).find('#price').html()) 

                                form2.append('total_refund', total_refund);
                                console.log(total_refund);

                                $.ajax({
                                    type:'POST',
                                    url: "{{ url('/dashboard/transaction/return/store')}}",
                                    data: form2,
                                    cache:false,
                                    contentType: false,
                                    processData: false,
                                    success: (data) => {
                                       
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                }); 
                            }
                        });
                        $('#TransactionProductModal').modal('hide');
                        refreshData();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            })


            $('#TransactionForm').submit(function(e) {
                e.preventDefault();
                var obj=this;

                if($('#id').val()){
                    var quantityinput=true;
                    var priceinput=true;
                    $('#carttable #price').each(function () {
                        if(!$(this).val()){
                            priceinput=false;
                        }
                    })
                    $('#carttable #quantity').each(function () {
                        if(!$(this).val()){
                            quantityinput=false;
                        }
                    })
                    if(! $('#invoice_number').val()){
                        alert('Enter Invoice Number!');
                    }
                    else if($('#carttable').html()==""){
                        alert('Add Product First!');
                    }
                    else if(! quantityinput){
                        alert('Enter Quantity!');
                    }
                    else if(! priceinput){
                        alert('Enter Price!');
                    }
                    else{
                        var formData = new FormData(obj);
                        var body={};
                        formData.forEach(function(value, key){
                            body[key] = value;
                        }); 
                        body["total_payment"]=$('#total_payment').html();
                        body["id"]=$('#id').val();
                        console.log($('#id').val());
                        body["details"]=[];

                        $('#carttable tr').each(function (index, element) {
                            var elm=this;
                            var product=new Array();

                            var cart={
                                'id_transaction' : $('#id').val(), 
                                'quantity': $(elm).children().eq(9).find('#quantity').val(),
                                'price': $(elm).children().eq(9).find('#price').val(),
                                'total': $(elm).children().eq(10).text()
                            };
                            cart['id_product'] = $(elm).children().eq(0).text();
                            cart["id_transaction_details"]=$(elm).children().eq(0).find('#id_transaction_details').val();
                            body.details.push(cart);
                            
                        });



                        $.ajax({
                            type:'POST',
                            url: "{{ url('/dashboard/transaction/edit')}}",
                            data: JSON.stringify(body),
                            contentType: "json",
                            processData: false,
                            cache:false,
                            success: (data) => {


                                $("#TransactionModal").modal('hide');
                                getTables();
                                $("#btn-save").html('Submit');
                                $("#btn-save").attr("disabled", false);

                            },
                            error: function(data){
                                console.log(data);
                            }
                        }); 
                    }
                }else{
                    var quantityinput=true;
                    var priceinput=true;
                    $('#carttable #price').each(function () {
                        if(!$(this).val()){
                            priceinput=false;
                        }
                    })
                    $('#carttable #quantity').each(function () {
                        if(!$(this).val()){
                            quantityinput=false;
                        }
                    })

                    
                    if(! $('#invoice_number').val()){
                        alert('Enter Invoice Number!');
                    }
                    else if($('#carttable').html()==""){
                        alert('Add Product First!');
                    }
                    else if(! quantityinput){
                        alert('Enter Quantity!');
                    }
                    else if(! priceinput){
                        alert('Enter Price!');
                    }
                    else{
                        var formData = new FormData(this);
                        formData.append("total_payment", $('#total_payment').html());




                        $.ajax({
                            type:'POST',
                            url: "{{ url('/dashboard/transaction/store')}}",
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                var id_transaction=data.id;
                                console.log(id_transaction);
                                $('#carttable tr').each(function (index, element) {
                                    var elm=this;
                                    var product=new Array();
                                    var form=new FormData();

                                    form.append('id_transaction', id_transaction);
                                    form.append('id_product', $(elm).children().eq(0).text());
                                    form.append('quantity', $(elm).children().eq(9).find('#quantity').val());
                                    form.append('price', $(elm).children().eq(9).find('#price').val());
                                    form.append('total', $(elm).children().eq(10).text());
                                    $.ajax({
                                        type:'POST',
                                        url: "{{ url('/dashboard/transaction/store/product')}}",
                                        data: form,
                                        cache:false,
                                        contentType: false,
                                        processData: false,
                                        success: (data) => {
                                           
                                        },
                                        error: function(data){
                                            console.log(data);
                                        }
                                    }); 
                                });
                                $.ajax({
                                    type:'POST',
                                    url: "{{ url('/dashboard/transaction/jurnal')}}",
                                    data: { id_transaction: id_transaction },
                                    dataType: 'json',
                                    success: (data) => {
                                        
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                }); 

                                $("#TransactionModal").modal('hide');
                                getTables();
                                $("#btn-save").html('Submit');
                                $("#btn-save").attr("disabled", false);

                            },
                            error: function(data){
                                console.log(data);
                            }
                        }); 
                    }
                }
                
            
               
            });

            function export_data() {
                var from=$('#from').val();
                var to=$('#to').val();
                var company=$('#company').val();
                window.location.replace("{{ url('/dashboard/transaction/export')}}?from="+from+"&to="+to+"&id_company="+company);
            }

        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>
