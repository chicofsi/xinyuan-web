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
            Manage Purchase
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Purchase</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Purchase
                        <span class="pull-right">
                            <a href="#PurchaseModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Purchase <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                        </span>
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
                                        <button id="btn-export" onclick="export_data()" class="btn btn-danger">Export Excel</button>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 10px">
                                    <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="purchase_table">
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
                                            Total Payment
                                        </th>
                                        <th>
                                            Rates
                                        </th>
                                        <th>
                                            Total Payment in IDR
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
                                <tbody id="purchasetable"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Factories</th>
                                        <th>Date</th>
                                        <th>Total Payment</th>
                                        <th>Rates</th>
                                        <th>Total Payment in IDR</th>
                                        <th>Payment Paid</th>
                                        <th>Product</th>
                                        <th>Action</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="PurchaseModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="PurchaseForm" name="PurchaseForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PurchaseModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Purchase Detail</div>
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
                                                                            <div class="title">Factories</div>

                                                                            <select class="desk form-control" id="id_factories"style="color: black;" name="id_factories" >
                                                                                @foreach ($factories as $fact)
                                                                                    <option value="{{$fact->id}}">{{$fact->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Purchase Date</div>
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
                                                                        <li>
                                                                            <div class="title">Currency</div>

                                                                            <select class="desk form-control" id="id_currency"style="color: black;" name="id_currency" >
                                                                                @foreach ($currency as $curr)
                                                                                    <option value="{{$curr->id}}">{{$curr->name}}</option>
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button onclick="deletePurchase()" id="btn-delete" class="btn btn-danger pull-left" style="display: inline !important;">Delete Purchase</button>
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
                getProduct();

                $('#id_currency').change(function () {
                    changeCurrency();
                })

                $("#searchbar").on("keyup", function() {
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
                $("input[type='checkbox']").click(function() {
                    checkFilter();
                });
                
                
            });

            function changeCurrency() {
                $('#carttable tr').filter(function() {
                    if($('#id_currency').val()=='1'){
                        $(this).find('#rates').css("display","none");
                    }else{
                        $(this).find('#rates').css("display","block");
                    }

                    var price=0;
                    var quantity=0;
                    var rates=0;

                    if($(this).find('#price').val() ){
                        price=$(this).find('#price').val();
                        console.log('found price');
                    }
                    if($(this).find('#quantity').val() ){
                        quantity=$(this).find('#quantity').val();
                        console.log('found qty');
                    }
                    if($('#id_currency').val()==1){
                        rates=1;
                    }else{
                        if($(this).find('#rates').val() ){
                            rates=$(this).find('#rates').val();
                        }
                    }
                    
                    $(this).find('#subtotal').html(price*quantity*rates);
                    checkTotalPayment();
                })
            }

            function deletePurchase() {
                var id=$('#id').val();
                
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/delete') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#PurchaseModal').modal('hide');
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
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/list') }}",
                    data: { from: from, to: to},
                    dataType: 'json',
                    success: function(res){
                        $('#purchasetable').html(res.data);

                        $("input[type='checkbox']").click(function() {
                            checkFilter();
                        });
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            
            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#purchasetable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;

                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    var factory=false;
                    $.each($("input[name='factory']:checked"), function(){     
                        factory=( $(elm).children().eq(1).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||factory;
                    });

                    $(this).toggle(search && factory);
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
                $('#PurchaseForm').trigger("reset");
                $('#carttable').html("");
                $('#PurchaseModalTitle').html("Add Purchase");
                $('#id').val('');
                $('#purchaseproducttable').html("");
                checkTotalPayment();
            }

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#btn-add-return').css('display','inline');
                        $('#btn-delete').css('display','inline');

                        $('#id').val(res.id);
                        $('#carttable').html("");
                        $('#purchaseproducttable').html("");
                        $('#returntable').html("");

                        $('#invoice_number').val(res.invoice_number);
                        $('#id_factories').val(res.id_factories);
                        $('#id_currency').val(res.id_currency);
                        $('#payment').val(res.payment);
                        $('#tempo').val(res.tempo);
                        $('#date').val(res.date);

                        $('#PurchaseModalTitle').html("Purchase Details");
                        $('#PurchaseModal').modal('show');
                        $.each(res.purchasedetails, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getbyid') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    if($('#id_currency').val()==1){
                                        rate="display:none";
                                    }else{
                                        rate="display:block";
                                    }
                                    $('#carttable').append("<tr><td>"+v.id+'<input type="hidden" name="id" id="id_purchase_details" value="'+v.id+'">'+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' value="+v.quantity+" placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;"+rate+"' id='rates' name='rates' value="+v.rates+" placeholder='Rates' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' value="+v.price+" placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>"+v.total_idr+"</td></tr>");

                                    $('#carttable #quantity').each(function() {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#price').val() ){
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            
                                            quantity=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })
                                    
                                    $('#carttable #price').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            }

                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            price=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    $('#carttable #rates').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val() && $(this).parent().parent().parent().parent().find('#price').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            rates=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    checkTotalPayment();

                                    

                                    
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
                    url: "{{ url('/dashboard/purchase/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#btn-add-return').css('display','inline');
                        $('#btn-delete').css('display','inline');

                        $('#id').val(res.id);
                        $('#carttable').html("");
                        $('#purchaseproducttable').html("");
                        $('#returntable').html("");

                        $('#invoice_number').val(res.invoice_number);
                        $('#id_factories').val(res.id_factories);
                        $('#id_currency').val(res.id_currency);
                        $('#payment').val(res.payment);
                        $('#tempo').val(res.tempo);
                        $('#date').val(res.date);


                        $('#PurchaseModalTitle').html("Purchase Details");
                        $('#PurchaseModal').modal('show');
                        $.each(res.purchasedetails, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getbyid') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    if($('#id_currency').val()==1){
                                        rate="display:none";
                                    }else{
                                        rate="display:block";
                                    }
                                    $('#carttable').append("<tr><td>"+v.id+'<input type="hidden" name="id" id="id_purchase_details" value="'+v.id+'">'+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' value="+v.quantity+" placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;"+rate+"' id='rates' name='rates' value="+v.rates+" placeholder='Rates' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' value="+v.price+" placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>"+v.total_idr+"</td></tr>");

                                    $('#carttable #quantity').each(function() {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#price').val() ){
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }

                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            quantity=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })
                                    
                                    $('#carttable #price').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            }

                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            price=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    $('#carttable #rates').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val() && $(this).parent().parent().parent().parent().find('#price').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            rates=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    checkTotalPayment();

                                    

                                    
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

                            if($('#id_currency').val()==1){
                                rate="display:none";
                            }else{
                                rate="display:block";
                            }

                            $('#carttable').append("<tr><td>"+data.data.id+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity'  placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;"+rate+"' id='rates' name='rates' placeholder='Rates' min='1'><input type='number' class='form-control' style='color: black;' id='price' name='price' placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>0</td></tr>");
                    
                                $('#carttable #quantity').each(function() {
                                    $(this).change(function () {
                                        var price=0;
                                        var quantity=0;
                                        var rates=0;

                                        if($(this).parent().parent().parent().parent().find('#price').val()){
                                            price=$(this).parent().parent().parent().parent().find('#price').val();
                                        }

                                        if($('#id_currency').val()==1){
                                            rates=1;
                                        }else{
                                            if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                            }
                                        }
                                        quantity=$(this).val();
                                        $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                        checkTotalPayment();
                                    })
                                })
                                
                                $('#carttable #price').each(function () {
                                    $(this).change(function () {
                                        var price=0;
                                        var quantity=0;
                                        var rates=0;

                                        if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                            quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                        }
                                        if($('#id_currency').val()==1){
                                            rates=1;
                                        }else{
                                            if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                            }
                                        }
                                        price=$(this).val();
                                        $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                        checkTotalPayment();
                                    })
                                })

                                $('#carttable #rates').each(function () {
                                    $(this).change(function () {
                                        var price=0;
                                        var quantity=0;
                                        var rates=0;

                                        if($(this).parent().parent().parent().parent().find('#quantity').val() && $(this).parent().parent().parent().parent().find('#price').val()){
                                            quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            price=$(this).parent().parent().parent().parent().find('#price').val();
                                        }
                                        rates=$(this).val();
                                        $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
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


            $('#PurchaseForm').submit(function(e) {
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
                        body["total_payment_idr"]=$('#total_payment').html();
                        body["id"]=$('#id').val();
                        console.log($('#id').val());
                        body["details"]=[];

                        $('#carttable tr').each(function (index, element) {
                            var elm=this;
                            var product=new Array();

                            var cart={
                                'id_purchase' : $('#id').val(), 
                                'quantity': $(elm).children().eq(9).find('#quantity').val(),
                                'price': $(elm).children().eq(9).find('#price').val(),
                                'rates': $(elm).children().eq(9).find('#rates').val(),
                                'total': $(elm).children().eq(10).text()
                            };
                            cart['id_product'] = $(elm).children().eq(0).text();
                            cart["id_purchase_details"]=$(elm).children().eq(0).find('#id_purchase_details').val();
                            body.details.push(cart);
                            
                        });



                        $.ajax({
                            type:'POST',
                            url: "{{ url('/dashboard/purchase/edit')}}",
                            data: JSON.stringify(body),
                            contentType: "json",
                            processData: false,
                            cache:false,
                            success: (data) => {


                                $("#PurchaseModal").modal('hide');
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
                        formData.append("total_payment_idr", $('#total_payment').html());




                        $.ajax({
                            type:'POST',
                            url: "{{ url('/dashboard/purchase/store')}}",
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                var id_purchase=data.id;
                                console.log(id_purchase);
                                $('#carttable tr').each(function (index, element) {
                                    var elm=this;
                                    var product=new Array();
                                    var form=new FormData();

                                    form.append('id_purchase', id_purchase);
                                    form.append('id_product', $(elm).children().eq(0).text());
                                    form.append('quantity', $(elm).children().eq(9).find('#quantity').val());
                                    form.append('price', $(elm).children().eq(9).find('#price').val());
                                    form.append('rates', $(elm).children().eq(9).find('#rates').val());
                                    form.append('total', $(elm).children().eq(10).text());
                                    $.ajax({
                                        type:'POST',
                                        url: "{{ url('/dashboard/purchase/store/product')}}",
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
                                    url: "{{ url('/dashboard/purchase/jurnal')}}",
                                    data: { id_purchase: id_purchase },
                                    dataType: 'json',
                                    success: (data) => {
                                        
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                }); 

                                $("#PurchaseModal").modal('hide');
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
                window.location.replace("{{ url('/dashboard/purchase/export')}}?from="+from+"&to="+to);
            }
        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>
