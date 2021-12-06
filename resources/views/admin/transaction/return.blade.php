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
            Manage Refund and Product Return
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active">Manage Refund and Product Return</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Refund and Product Return
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
                            <table class="display table ">
                                <thead>
                                    <tr>
                                        <th>
                                            Invoice Number
                                        </th>
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
                                    </tr>
                                </thead>
                                <tbody id="girotable">
                                    <tr>
                                        <td colspan="12">
                                            No Items
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="12">Total</th>
                                        <th id="total_cashback">0</th>
                                        <th ></th>

                                    </tr>
                                </tfoot>
                            </table>



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
                var nice=$('#nice_level').val();                
                var company=$('#company').val();

                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/transaction/refund/list') }}",
                    data: { from: from, to: to, nice: nice, company: company },
                    dataType: 'json',
                    success: function(res){
                        $('#girotable').html(res.data);
                        checkTotalCashback();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function checkTotalCashback() {
                var total_payment=0;
                $('.cashback').filter(function() {
                    var elm=this;

                    total_payment+= parseInt($(elm).text()) ;
                    
                });
                $('#total_cashback').html(total_payment);
            }
            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#girotable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;



                    $(this).toggle(search );
                });
            }

            function export_data() {
                var from=$('#from').val();
                var to=$('#to').val();
                var company=$('#company').val();
                window.location.replace("{{ url('/dashboard/transaction/refund/export')}}?from="+from+"&to="+to+"&id_company="+company);
            }

            
        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>
