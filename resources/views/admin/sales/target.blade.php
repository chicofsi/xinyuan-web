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
    <link href="{{asset('css/jquery.stepy.css')}}" rel="stylesheet">
    @endsection
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Manage Sales Target
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li > <a href="{{ url('/dashboard/sales') }}">Manage Sales</a></li>
            <li class="active"> Manage Sales Target</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Sales Target
                        
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
                                    <label style="float: right; width: 40%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="target_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Sales Target</th>
                                        <th>Billing Target</th>
                                        <th>
                                            Sales Progress
                                        </th>
                                        <th>
                                            Billing Progress
                                        </th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="targettable"></tbody>
                                    
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Sales Target</th>
                                        <th>Billing Target</th>
                                        <th>
                                            Sales Progress
                                        </th>
                                        <th>
                                            Billing Progress
                                        </th>
                                        <th>Action</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                        <div aria-hidden="true" role="dialog"  id="TargetEditModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="TargetEditForm" name="TargetEditForm">

                                        <input type="hidden" name="id_sales" id="id_sales">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="TargetEditModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Sales Detail</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="p-info"> 
                                                                        <li>
                                                                            <div class="title">Name</div>
                                                                            <div class="desk" id="ProfileName"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Gender</div>
                                                                            <div class="desk" id="ProfileGender"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Area</div>
                                                                            <div class="desk" id="ProfileArea"></div>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Address</div>
                                                                            <div class="desk" id="ProfileAddress"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Phone</div>
                                                                            <div class="desk" id="ProfilePhonenumber"></div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Email</div>
                                                                            <div class="desk" id="ProfileEmail"></div>
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
                                                            <div class="panel-title">Current Target</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            
                                                            <ul class="goal-progress">
                                                                <li>
                                                                    <div class="details">
                                                                        <div class="title">
                                                                            Sales Target - <span id="ProfileSalesTarget"></span> 
                                                                        </div>
                                                                        <div class="progress  progress-striped progress-xs">
                                                                            <div id="ProfileSalesProgressBar" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                                                                <span id="ProfileSales"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="details">
                                                                        <div class="title">
                                                                            Billing Target - <span id="ProfileBillingTarget"></span> 
                                                                        </div>
                                                                        <div class="progress progress-striped progress-xs">
                                                                            <div id="ProfileBillingProgressBar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 91%">
                                                                                <span id="ProfileBilling">91%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Edit Target</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul class="p-info">
                                                                <li>
                                                                    <div class="title">Sales Target</div>
                                                                    <input type="number" min="1" class="form-control desk" style="color: black;" id="SalesTarget" name="SalesTarget" placeholder="Enter Sales Target">
                                                                </li>
                                                                <li>
                                                                    <div class="title">Billing Target</div>
                                                                    <input type="number" min="1" class="form-control desk" style="color: black;" id="BillingTarget" name="BillingTarget" placeholder="Enter Billing Target">
                                                                </li>
                                                                <li>
                                                                    <span class="pull-right">
                                                                        <button type="submit" id="btn-save" class="btn btn-success">Submit</button>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                            </div>
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
            });

            function getTables() {
                var url="{{ url('/dashboard/employee/target/list') }}";
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        $('#targettable').html(res.data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();
                

                $("#targettable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                   

                    $(this).toggle(search);
                });
            }

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/employee/target/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#TargetEditModalTitle').html("Sales Details");
                        $('#TargetEditModal').modal('show');

                        $('#id_sales').val(res.id);

                        $('#ProfilePic').attr('src',res.photo_url);
                        $('#ProfileName').html(res.name);
                        $('#ProfileJoined').html('Joined Since '+res.joined);
                        $('#ProfileGender').html(res.gender);
                        $('#ProfileEmail').html(res.email);
                        $('#ProfilePhonenumber').html(res.phone);
                        $('#ProfileAddress').html(res.address);
                        $('#ProfileArea').html(res.area['name']);
                        $('#ProfileCustomerCount').html(res.customercount+' Customer');
                        $('#ProfileTransactionCount').html(res.transactioncount+' Transaction');
                        $('#ProfileCustomerList').html(res.customerlist);
                        $('#ProfileTransactionList').html(res.transactionlist);
                        $('#AddCustomerButton').attr('onclick',"addcustomer("+res.id+")");


                        $('#ProfileSales').html(res.sell);
                        $('#ProfileBilling').html(res.bill);
                        $('#ProfileBillingProgressBar').css('width',res.widthbill+'%');
                        $('#ProfileSalesProgressBar').css('width',res.widthsales+'%');
                        $('#ProfileBillingTarget').html(res.target.billing_target);
                        $('#ProfileSalesTarget').html(res.target.sales_target);

                        $('#BillingTarget').val(res.target.billing_target);
                        $('#SalesTarget').val(res.target.sales_target);


                        



                        
                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }

            function add(){
                $('#SalesForm').trigger("reset");
                $('#SalesModalTitle').html("Add Sales");
                $('#id').val('');
            };

            $('#TargetEditForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/employee/target/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#TargetEditModal").modal('hide');
                        getTables();
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });
            

            
            




        
            

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
