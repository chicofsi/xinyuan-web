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
                                <th>
                                    Invoice Number
                                </th>
                                <th>
                                    Customer
                                </th>
                                <th>
                                    Sales Name
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
