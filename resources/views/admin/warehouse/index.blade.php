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
        .images img{
            object-fit: contain !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-fileupload.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('js/jquery-tags-input/jquery.tagsinput.css') }} " />

    <link href="{{ asset('js/iCheck/skins/minimal/minimal.css') }} " rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/minimal/red.css') }} " rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/minimal/green.css') }} " rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/minimal/blue.css') }} " rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/minimal/yellow.css') }} " rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/minimal/purple.css') }} " rel="stylesheet">

    <link href="{{ asset('js/iCheck/skins/square/square.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/square/red.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/square/green.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/square/blue.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/square/yellow.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/square/purple.css')}}" rel="stylesheet">

    <link href="{{ asset('js/iCheck/skins/flat/grey.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/flat/red.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/flat/blue.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/flat/yellow.css')}}" rel="stylesheet">
    <link href="{{ asset('js/iCheck/skins/flat/purple.css')}}" rel="stylesheet">

    <!--multi-select-->
    <link rel="stylesheet" type="text/css" href="{{ asset('js/jquery-multi-select/css/multi-select.css')}}" />
    @endsection
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Manage Warehouse
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Warehouse</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper" id="body">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Warehouses
                        <span class="pull-right">
                            <a href="#WarehouseModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Warehouse <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                        </span>
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
                                        <th>
                                            Area
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                        <th>
                                            Maximum Capacity
                                        </th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="producttable"></tbody>
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
                        <div aria-hidden="true" role="dialog"  id="WarehouseDetailModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="WarehouseDetailModalTitle">Product Details</h4>
                                    </div>
                                    <div class="modal-body"  style="background-color: #eff0f4">





                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="profile-desk">
                                                                    <h1 id="WarehouseName"></h1>
                                                                    <span id="WarehouseArea" style="margin-bottom: 10px"></span>
                                                                    <span id="WarehouseArea" style="margin-bottom: 10px"></span>
                                                                    
                                                                    <a href="#ProductEditModal" data-toggle="modal" data-original-title='editproduct' class='btn btn-default btn-sm pull-right'>Edit Data</a>
                                                                    {{-- <a class="btn p-follow-btn pull-left" href="#"> <i class="fa fa-check"></i> Following</a> --}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <header class="panel-heading custom-tab ">
                                                                <ul class="nav nav-tabs">

                                                                    <li class="active">
                                                                        <a href="#transaction" data-toggle="tab"><i class="fas fa-user"></i> Transaction</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#purchase" data-toggle="tab"><i class="fas fa-user"></i> Purchase</a>
                                                                    </li>
                                                                </ul>
                                                            </header>
                                                            <div class="panel-body">
                                                                <div class="tab-content">
                                                                    <div class="tab-pane active" id="transaction">
                                                                        <table  class="display table table-striped" id="transaction_table">
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
                                                                                        Total Payment
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="TransactionList"></tbody>
                                                                        </table>
                                                                    </div>

                                                                    <div class="tab-pane" id="purchase">
                                                                        <table  class="display table table-striped" id="purchase_table">
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
                                                                                        Total Payment
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="PurchaseList"></tbody>
                                                                        </table>
                                                                    </div>
                                                                    {{-- <div class="tab-pane" id="stock">
                                                                        <ul class="activity-list" id="ProfileTransactionList">
                                                                        </ul>
                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="modal-footer">
                                        <form role="form" id="DeleteProductForm" name="DeleteProductForm">

                                            <input type="hidden" id="IdProduct" name="id" ></input>
                                            <button type="submit" id="DeleteButton" class="btn btn-danger">Delete Product</button>
                                            
                                        </form>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div aria-hidden="true" role="dialog"  id="WarehouseModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form role="form" id="WarehouseForm" name="WarehouseForm">

                                        <input type="hidden" name="id" id="IdProduct">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="WarehouseModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">New Warehouse</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul class="p-info">
                                                                <li>
                                                                    <div class="title">Area</div>
                                                                    <select class=" form-control desk" id="id_area" style="padding: 0px 10px;" name="id_area" >
                                                                        <?php foreach ($areas as $area):?>
                                                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </li>
                                                                <li>
                                                                    <div class="title">Name</div>
                                                                    <input type="text"  class="form-control desk" style="color: black" id="name" name="name" required placeholder="warehouse name">
                                                                </li>
                                                                <li>
                                                                    <div class="title">Capacity</div>
                                                                    <input type="number" min="0" class="form-control desk" style="color: black" id="capacity" name="capacity" required value="0">
                                                                </li>
                                                                <li>
                                                                    <div class="title">Address</div>
                                                                    <textarea rows="4" class="form-control desk" id="address" style="color: black;" name="address" placeholder="Enter Address"></textarea>
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
                    

                $('#count').click(function() {
                    $('#difference').attr('disabled',true);
                    $('#actual').attr('disabled',false);
                    $('#actual').val(parseInt($('#recordedqty').text()));
                    $('#difference').val($('#actual').val()-parseInt($('#recordedqty').text()));
                })
                $('#inout').click(function() {
                    $('#difference').attr('disabled',false);
                    $('#actual').attr('disabled',true);
                    $('#difference').val(0);
                    $('#actual').val(parseInt( $('#recordedqty').text()) + parseInt($('#difference').val()));
                })
                $('#difference').on("keyup",function() {
                    $('#actual').val(parseInt($('#recordedqty').text())+parseInt($(this).val()));
                })

                $('#actual').on("keyup",function() {
                    $('#difference').val($(this).val()-parseInt($('#recordedqty').text()));

                })
            });
            function getTables() {
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/warehouse/list') }}",
                    success: function(res){
                        $('#producttable').html(res.data);

                        showFilter($("thead tr th:eq( 1 )"),
                            "typefilter",
                            "<div class='form-group '></div>");

                        $.each(res.types,function (key, value) {
                            $('#typefilter .form-group').append(value);
                        })
                        $('#TypeFilter').click(function() {
                            toggleFilter("typefilter");
                        });

                        showFilter($("thead tr th:eq( 2 )"),
                            "sizefilter",
                            "<div class='form-group '></div>");

                        $.each(res.sizes,function (key, value) {
                            $('#sizefilter .form-group').append(value);
                        })
                        $('#SizeFilter').click(function() {
                            toggleFilter("sizefilter");
                        });

                        showFilter($("thead tr th:eq( 3 )"),
                            "colourfilter",
                            "<div class='form-group '></div>");

                        $.each(res.colours,function (key, value) {
                            $('#colourfilter .form-group').append(value);
                        })
                        $('#ColourFilter').click(function() {
                            toggleFilter("colourfilter");
                        });

                        showFilter($("thead tr th:eq( 4 )"),
                            "logofilter",
                            "<div class='form-group '></div>");

                        $.each(res.logos,function (key, value) {
                            $('#logofilter .form-group').append(value);
                        })
                        $('#LogoFilter').click(function() {
                            toggleFilter("logofilter");
                        });

                        showFilter($("thead tr th:eq( 5 )"),
                            "factoryfilter",
                            "<div class='form-group '></div>");

                        $.each(res.factory,function (key, value) {
                            $('#factoryfilter .form-group').append(value);
                        })
                        $('#FactoryFilter').click(function() {
                            toggleFilter("factoryfilter");
                        });

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
                $("#producttable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    var type=false;
                    $.each($("input[name='type']:checked"), function(){     
                        type=( $(elm).children().eq(1).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||type;
                    });

                    var size=false;
                    $.each($("input[name='size']:checked"), function(){     
                        size=( $(elm).children().eq(2).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||size;
                    });

                    var colour=false;
                    $.each($("input[name='colour']:checked"), function(){     
                        colour=( $(elm).children().eq(3).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||colour;
                    });

                    var logo=false;
                    $.each($("input[name='logo']:checked"), function(){     
                        logo=( $(elm).children().eq(4).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||logo;
                    });

                    var factory=false;
                    $.each($("input[name='factory']:checked"), function(){     
                        factory=( $(elm).children().eq(5).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||factory;
                    });

                    $(this).toggle(search && type && size && colour && logo && factory);
                });
            }
            

            function add(){
                $('#ProductForm').trigger("reset");
                $('#ProductModalTitle').html("Add Product");
                $('#id').val('');
            };

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/warehouse/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#WarehouseDetailModalTitle').html("Detail Warehouse");
                        $('#WarehouseDetailModal').modal('show');

                        $('#WarehouseName').text(res.name);
                        $('#WarehouseArea').text(res.area.name);


                        $('#IdProduct').val(res.id);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            

            function gd(year, month) {
                return new Date(year, month - 1, 1).getTime();
            }
            
            function showFilter(x, id, contents) {
                $('<div id="'+id+'" class="panel panel-primary">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    'min-width': x.outerWidth(),
                    top: $('th').first().offset().top + $('th').first().outerHeight() ,
                    left: x.offset().left ,
                    zindex: 100,
                    border: '1px solid #dddddd',
                    padding: '10px',
                        'font-size': '12px',
                        'border-radius': '3px',
                        'background-color': '#fff',
                    opacity: 1,
                }).appendTo("body");
            }

            function toggleFilter(id) {
                $('#'+id).toggle();
            }

           $('#WarehouseForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/warehouse/')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        getTables();
                        $("#WarehouseModal").modal('hide');
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
        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>
    @endsection
        <!--body wrapper end-->
</x-app-layout>
