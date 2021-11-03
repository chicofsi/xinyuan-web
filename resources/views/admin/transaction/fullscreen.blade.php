<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <meta name="author" content="chico"/>
        
        <title>{{ config('app.name', 'Laravel') }}</title>


        <!-- Favicon -->
        <link rel="icon" href="{{ asset('/img/logo_icon.png') }}" type="image/x-icon"/>

        <link rel="stylesheet" href="{{asset('js/data-tables/DT_bootstrap.css')}}" />


        <link href="{{asset('css/all.css')}}" rel="stylesheet">

        <!--common-->
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet"> 
        <style type="text/css">
                
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
    </head>
<body>
	<div class="wrapper" id="body">
        <section class="panel">
            <header class="panel-heading">
                Transaction
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="row">
                        <div class="col-md-12" style="padding: 10px">
                            <label style="float: right; width: 40%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                        </div>
                    </div>
                    <table  class="display table table-striped" id="product_table">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                                                <?php foreach ($invoices as $invoice):?>

                                                    <div class="col-md-12">
                                                        <div class="form-check" style="padding: 5px;">
                                                            <input class="form-check-input" name="invoice" type="checkbox" value="{{$invoice->name}}" checked>
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                {{$invoice->name}}
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
                                <th>
                                    Customer
                                    <a id="CustomerFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('customer')"  class="fas fa-filter pull-right"></a>
                                    <div id="customerDropdown" class="dropdown-content" >
                                        <div class="container" style="width: 100%;">
                                            <div class="row">
                                                <div class="col-sm-12 mb-12">
                                                    <input type="text" id="customerSearch" class="form-control" onkeyup="searchFilter('customer')" placeholder="Search for Customer..." style="margin-top: 10px; margin-bottom: 10px;">
                                                </div>
                                            </div>

                                            <div class="row" id="customerFilterList" style="max-height: 200px; overflow-y: auto;">
                                                <?php foreach ($customers as $customer):?>

                                                    <div class="col-md-12">
                                                        <div class="form-check" style="padding: 5px;">
                                                            <input class="form-check-input" name="customer" type="checkbox" value="{{$customer->name}}" checked>
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                {{$customer->name}}
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
                                <th>
                                    Sales Name
                                    
                                    <a id="ColourFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('colour')"  class="fas fa-filter pull-right"></a>
                                    <div id="colourDropdown" class="dropdown-content" >
                                        <div class="container" style="width: 100%;">
                                            <div class="row">
                                                <div class="col-sm-12 mb-12">
                                                    <input type="text" id="colourSearch" class="form-control" onkeyup="searchFilter('colour')" placeholder="Search for Colour..." style="margin-top: 10px; margin-bottom: 10px;">
                                                </div>
                                            </div>

                                            <div class="row" id="colourFilterList" style="max-height: 200px; overflow-y: auto;">
                                                <?php foreach ($colours as $colour):?>

                                                    <div class="col-md-12">
                                                        <div class="form-check" style="padding: 5px;">
                                                            <input class="form-check-input" name="colour" type="checkbox" value="{{$colour->name}}" checked>
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                {{$colour->name}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach?>

                                            </div>

                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-sm-6 mb-6">
                                                    <button onclick="clearSelection('colour')" class="btn btn-danger">Clear</button>
                                                </div>
                                                <div class="col-sm-6 mb-6">
                                                    <button onclick="allSelection('colour')" class="btn btn-success">All</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Product
                                </th>
                                <th>
                                    Product Quantity
                                </th>
                                <th>
                                    Product Price
                                </th>
                                <th>Sub Total</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="transactiontable"></tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Invoice Number</th>
                                <th>Customer</th>
                                <th>Sales Name</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Product Quantity</th>
                                <th>Product Price</th>
                                <th>Sub Total</th>
                                <th>Total</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Placed js at the end of the document so the pages load faster -->
    <script src="{{asset('js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script src="{{asset('js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/modernizr.min.js')}}"></script>



    <!--common scripts for all pages-->

    <script>

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            getTables();

            $("#searchbar").on("keyup", function() {
                checkFilter();
            });
        });
        function getTables() {
            $.ajax({
                type:"GET",
                url: "{{ url('/dashboard/transaction/full/list') }}",
                success: function(res){
                    $('#transactiontable').html(res.data);


                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    </script>

</body>
</html>
