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
            Manage Product
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Product</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper" id="body">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Product
                        <span class="pull-right">
                            <a href="#ProductModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Product <i class="fa fa-plus"></i></a>
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
                                            Photo 
                                        </th>
                                        <th>
                                            Type
                                            <a id="TypeFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                        </th>
                                        <th>
                                            Size
                                            <a id="SizeFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                        </th>
                                        <th>
                                            Net Weight
                                        </th>
                                        <th>
                                            Gross Weight
                                        </th>
                                        <th>
                                            Colour
                                            <a id="ColourFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                        </th>
                                        <th>
                                            Logo
                                            <a id="LogoFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                        </th>
                                        <th>
                                            Factory Name
                                            <a id="FactoryFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
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

                        

                        <div aria-hidden="true" role="dialog"  id="ProductDetailModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="ProductDetailModalTitle">Product Details</h4>
                                    </div>
                                    <div class="modal-body"  style="background-color: #eff0f4">





                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="profile-desk">
                                                                    <h1 id="ProductType"></h1>
                                                                    <span id="ProductSize" style="margin-bottom: 10px"></span>
                                                                    
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
                                                                        <a href="#statistic" data-toggle="tab"><i class="fas fa-chart-bar"></i> Product Statistic</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#gallery" data-toggle="tab"><i class="fas fa-user"></i> Gallery</a>
                                                                    </li>

                                                                    <li class="">
                                                                        <a href="#transaction" data-toggle="tab"><i class="fas fa-user"></i> Transaction</a>
                                                                    </li>
                                                                    {{-- <li class="">
                                                                        <a href="#stock" data-toggle="tab"><i class="fas fa-cash-register"></i> Stock</a>
                                                                    </li> --}}
                                                                </ul>
                                                            </header>
                                                            <div class="panel-body">
                                                                <div class="tab-content">
                                                                    <div class="tab-pane active" id="statistic">
                                                                        Product Sold Past 1 Year
                                                                        <div id="product-sold-chart">
                                                                            <div id="product-sold-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                    </div>
                                                                    <div class="tab-pane" id="gallery">
                                                                        <ul id="filters" class="media-filter">
                                                                        </ul>

                                                                        <div class="btn-group pull-right">
                                                                            <a  href="#PhotoModal" data-toggle="modal">
                                                                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-folder-open"></i> Add New</button>
                                                                            </a>
                                                                        </div>

                                                                        <div id="ProductGallery" class="media-gal">
                                                                            

                                                                        </div>

                                                                        
                                                                    </div>
                                                                    <div class="tab-pane" id="transaction">
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
                                    <div class="modal-footer">
                                        <form role="form" id="DeleteProductForm" name="DeleteProductForm">

                                            <input type="hidden" id="IdProduct" name="id" ></input>
                                            <button type="submit" id="DeleteButton" class="btn btn-danger">Delete Product</button>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" role="dialog"  id="ProductModal" class="modal fade">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="ProductForm" name="ProductForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="ProductModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Type</div>
                                                                            <select class=" form-control desk" id="id_type" style="padding: 0px 10px;" name="id_type" >
                                                                                <?php foreach ($types as $type):?>
                                                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Size</div>
                                                                            <select class=" form-control desk" id="id_size" style="padding: 0px 10px;" name="id_size" >
                                                                                <?php foreach ($sizes as $size):?>
                                                                                <option value="{{$size->id}}">{{$size->width}}X{{$size->height}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Net Weight</div>
                                                                            <select class=" form-control desk" id="id_weight" style="padding: 0px 10px;" name="id_weight" >
                                                                                <?php foreach ($weights as $weight):?>
                                                                                <option value="{{$weight->id}}">{{$weight->weight}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Gross Weight</div>
                                                                            <select class=" form-control desk" id="id_gross_weight" style="padding: 0px 10px;" name="id_gross_weight" >
                                                                                <?php foreach ($grossweights as $grossweight):?>
                                                                                <option value="{{$grossweight->id}}">{{$grossweight->gross_weight}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Colour</div>
                                                                            <select class=" form-control desk" id="id_colour" style="padding: 0px 10px;" name="id_colour" >
                                                                                <?php foreach ($colours as $colour):?>
                                                                                <option value="{{$colour->id}}">{{$colour->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Logo</div>
                                                                            <select class=" form-control desk" id="id_logo" style="padding: 0px 10px;" name="id_logo" >
                                                                                <?php foreach ($logos as $logo):?>
                                                                                <option value="{{$logo->id}}">{{$logo->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Cost</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="cost" name="cost" placeholder="Enter Product Cost">
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Factories</div>
                                                                            <select class=" form-control desk" id="id_factories"style="padding: 0px 10px;" name="id_factories" >
                                                                                <?php foreach ($factories as $factory):?>
                                                                                <option value="{{$factory->id}}">{{$factory->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
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
                        <div aria-hidden="true" role="dialog"  id="ProductEditModal" class="modal fade">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="ProductEditForm" name="ProductEditForm">

                                        <div class="modal-header"style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="ProductEditModalTitle">Edit Product</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <ul class="p-info">

                                                                        <input type="hidden" name="id" id="edit_id">
                                                                        <li>
                                                                            <div class="title">Type</div>
                                                                            <select class=" form-control desk" id="edit_id_type" style="padding: 0px 10px;" name="id_type" >
                                                                                <?php foreach ($types as $type):?>
                                                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Size</div>
                                                                            <select class=" form-control desk" id="edit_id_size" style="padding: 0px 10px;" name="id_size" >
                                                                                <?php foreach ($sizes as $size):?>
                                                                                <option value="{{$size->id}}">{{$size->width}}X{{$size->height}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Net Weight</div>
                                                                            <select class=" form-control desk" id="edit_id_weight" style="padding: 0px 10px;" name="id_weight" >
                                                                                <?php foreach ($weights as $weight):?>
                                                                                <option value="{{$weight->id}}">{{$weight->weight}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Gross Weight</div>
                                                                            <select class=" form-control desk" id="edit_id_gross_weight" style="padding: 0px 10px;" name="id_gross_weight" >
                                                                                <?php foreach ($grossweights as $grossweight):?>
                                                                                <option value="{{$grossweight->id}}">{{$grossweight->gross_weight}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Colour</div>
                                                                            <select class=" form-control desk" id="edit_id_colour" style="padding: 0px 10px;" name="id_colour" >
                                                                                <?php foreach ($colours as $colour):?>
                                                                                <option value="{{$colour->id}}">{{$colour->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Logo</div>
                                                                            <select class=" form-control desk" id="edit_id_logo" style="padding: 0px 10px;" name="id_logo" >
                                                                                <?php foreach ($logos as $logo):?>
                                                                                <option value="{{$logo->id}}">{{$logo->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Cost</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="edit_cost" name="cost" placeholder="Enter Product Cost">
                                                                        </li>

                                                                        <li>
                                                                            <div class="title">Factories</div>
                                                                            <select class=" form-control desk" id="edit_id_factories"style="padding: 0px 10px;" name="id_factories" >
                                                                                <?php foreach ($factories as $factory):?>
                                                                                <option value="{{$factory->id}}">{{$factory->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
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
                        <div aria-hidden="true" role="dialog"  id="PhotoModal" class="modal fade ">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="PhotoForm" name="PhotoForm">

                                        <div class="modal-header " style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PhotoModalTitle">Add Product Photo</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">

                                                                <div class="fileupload-new  text-center">
                                                                    <img src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image" style="max-height: 150px" alt="" />
                                                                </div>
                                                                <div class="fileupload-preview thumbnail  text-center" style="width: 100%;border: none; object-fit: contain;">
                                                                </div>

                                                                <div style="width: 100%" class="text-center">
                                                                   <span class="btn btn-default btn-file" style="width: 50%">
                                                                       <span class="fileupload-new"><i class="fas fa-paperclip"></i> Select image</span>
                                                                       <span class="fileupload-exists" ><i class="fas fa-undo"></i> Change</span>
                                                                       <input id="photo" name="photo" type="file" class="default" />
                                                                   </span>
                                                                    <a href="#" class="btn btn-danger fileupload-exists" style="width: 50%" data-dismiss="fileupload"><i class="fas fa-trash"></i> Remove</a>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="btn-save" class="btn btn-info">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" role="dialog"  id="PhotoDeleteModal" class="modal fade ">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="PhotoDeleteForm" name="PhotoDeleteForm">
                                        <input type="hidden" name="id_product_photo" id="id_product_photo">

                                        <div class="modal-header " style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PhotoDeleteModalTitle">Product Photo</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <div class="form-group" id="icon_current">
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">

                                                                <div class="fileupload-new  text-center">
                                                                    <img id="icon_cur" src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image" style="max-height: 150px" alt="" />
                                                                </div>
                                                            </div>
                                                            <br/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="btn-save" class="btn btn-danger">Remove</button>
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
            });
            function getTables() {
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/product/list') }}",
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

                        showFilter($("thead tr th:eq( 5 )"),
                            "colourfilter",
                            "<div class='form-group '></div>");

                        $.each(res.colours,function (key, value) {
                            $('#colourfilter .form-group').append(value);
                        })
                        $('#ColourFilter').click(function() {
                            toggleFilter("colourfilter");
                        });

                        showFilter($("thead tr th:eq( 6 )"),
                            "logofilter",
                            "<div class='form-group '></div>");

                        $.each(res.logos,function (key, value) {
                            $('#logofilter .form-group').append(value);
                        })
                        $('#LogoFilter').click(function() {
                            toggleFilter("logofilter");
                        });

                        showFilter($("thead tr th:eq( 7 )"),
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
                        colour=( $(elm).children().eq(5).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||colour;
                    });

                    var logo=false;
                    $.each($("input[name='logo']:checked"), function(){     
                        logo=( $(elm).children().eq(6).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||logo;
                    });

                    var factory=false;
                    $.each($("input[name='factory']:checked"), function(){     
                        factory=( $(elm).children().eq(7).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||factory;
                    });

                    $(this).toggle(search && type && size && colour && logo && factory);
                });
            }
            

            function add(){
                $('#ProductForm').trigger("reset");
                $('#ProductModalTitle').html("Add Product");
                $('#id').val('');
            };
            function imgdetail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/product/photo/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#PhotoDeleteForm').trigger("reset");
                        $('#PhotoDeleteModal').modal('show');
                        $('#id_product_photo').val(id);
                        $('#icon_cur').attr('src',res.photo_url);



                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            };

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/product/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#ProductDetailModalTitle').html("Product Detail");
                        $('#ProductDetailModal').modal('show');

                        $('#IdProduct').val(res.id);
                        $('#ProductType').html(res.type.name);
                        $('#ProductSize').html(res.size.width+'X'+res.size.height);
                        var data=[];
                        $.each(res.chart, function(){     
                            data.push([gd(this.year,this.month),this.sold]);
                        });
                        productChart(data);

                        $('#ProductGallery').html(res.gallery);
                        $('#TransactionList').html(res.transactionlist);


                        $('#edit_cost').val(res.cost);
                        $('#edit_id_factories').val(res.id_factories);
                        $('#edit_id_logo').val(res.id_logo);
                        $('#edit_id_colour').val(res.id_colour);
                        $('#edit_id_weight').val(res.id_weight);
                        $('#edit_id_gross_weight').val(res.id_gross_weight);
                        $('#edit_id_size').val(res.id_size);
                        $('#edit_id_type').val(res.id_type);
                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function getPhoto(id) {
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/product/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#ProductGallery').html(res.gallery);
                        getTables();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            $('#PhotoForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var idProduct=$('#IdProduct').val();
                formData.append("id_product", $('#IdProduct').val());
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/product/photo')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#PhotoModal").modal('hide');
                        getPhoto(idProduct);
                        $('#PhotoForm').trigger('reset');
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
            })
            $('#ProductEditForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var idProduct=$('#IdProduct').val();
                formData.append("id_product", $('#IdProduct').val());
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/product/edit')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#ProductDetailModal").modal('hide');
                        $("#ProductEditModal").modal('hide');
                        getTables();
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
            })

            $('#PhotoDeleteForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var idProduct=$('#IdProduct').val()

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/product/photo/delete')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#PhotoDeleteModal").modal('hide');
                        getPhoto(idProduct);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
            })

            $('#DeleteProductForm').submit(function (e) {
                e.preventDefault();
                if (confirm("Delete Product?") == true) {
                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/product/delete')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#ProductDetailModal").modal('hide');
                            getTables();
                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 
                }
            })

            $('#ProductForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/product/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#ProductModal").modal('hide');
                        getTables();
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
                
               
            });
            

            function productChart(x) {
                var past = new Date();
                past.setMonth(past.getMonth()-11);

                $.plot($("#product-sold-chart #product-sold-container"), [
                    {
                        data: x,
                        label: "Product Sold",
                        lines: {
                            fill: true
                        }
                    }
                ],
                    {
                        series: {
                            lines: {
                                show: true,
                                fill: false
                            },
                            points: {
                                show: true,
                                lineWidth: 2,
                                fill: true,
                                fillColor: "#ffffff",
                                symbol: "circle",
                                radius: 5
                            },
                            shadowSize: 0
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#f9f9f9",
                            borderWidth: 1,
                            borderColor: "#eeeeee"
                        },
                        colors: ["#65CEA7"],
                        yaxis: {
                        },
                        xaxis: {
                            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                            mode: "time",
                            tickSize: [1, "month"],
                            min: past,
                            max: new Date().getTime(),
                            timeformat: "%b %Y",
                        }
                    }
                );
            }

            
            

            var previousPoint = null;

            function gd(year, month) {
                return new Date(year, month - 1, 1).getTime();
            }

            function showTooltip(x, y, color, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 120,
                    zindex: 100,
                    border: '2px solid ' + color,
                    padding: '3px',
                        'font-size': '9px',
                        'border-radius': '5px',
                        'background-color': '#fff',
                        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                    opacity: 0.9
                }).appendTo("#ProductDetailModal").fadeIn(200);
            }


            $("#product-sold-container").on("plothover", function (event, pos, item) {
                if (item) {
                    if ( previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
                        $("#tooltip").remove();

                        var x = item.datapoint[0];
                        var y = item.datapoint[1];

                        var color = item.series.color;

                        //console.log(item.series.xaxis.ticks[x].label);               

                        showTooltip(item.pageX,
                        item.pageY,
                        color,
                            "<strong>" + y + " Item Has Been Sold</strong>");
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
            
            



            
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
