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
    <link href="{{asset('css/jquery.stepy.css')}}" rel="stylesheet">
    @endsection
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Manage Sales @isset ($area)
                {{$area->name}}
            @endisset
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Sales </li>
            @isset ($area)
                <li class="active"> Manage Sales {{$area->name}}</li>
            @endisset
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Sales @isset ($area)
                            {{$area->name}}
                        @endisset
                        <span class="pull-right">
                            <a href="#SalesModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Sales <i class="fa fa-plus"></i></a>
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
                            <table  class="display table table-striped" id="sales_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th id="AreaHeader">
                                            Area

                                            <a id="AreaFilter" style="text-decoration: none;color: #dddddd" onclick="showDropdown('area')"  class="fas fa-filter pull-right"></a>
                                            <div id="areaDropdown" class="dropdown-content" >
                                                <div class="container" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-12">
                                                            <input type="text" id="areaSearch" class="form-control" onkeyup="searchFilter('area')" placeholder="Search for Area..." style="margin-top: 10px; margin-bottom: 10px;">
                                                        </div>
                                                    </div>

                                                    <div class="row" id="AreaFilterList" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($arealist as $areas):?>

                                                            <div class="col-md-12">
                                                                <div class="form-check" style="padding: 5px;">
                                                                    <input class="form-check-input" name="area" type="checkbox" value="{{$areas->name}}" checked>
                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                        {{$areas->name}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach?>

                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="clearSelection('area')" class="btn btn-danger">Clear</button>
                                                        </div>
                                                        <div class="col-sm-6 mb-6">
                                                            <button onclick="allSelection('area')" class="btn btn-success">All</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="salestable"></tbody>

                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="SalesModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" id="SalesForm" name="SalesForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="SalesModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <div class="fileupload fileupload-new" data-provides="fileupload">

                                                                            <div class="fileupload-new profile-pic text-center">
                                                                                <img src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image" style="max-height: 150px" alt="" />
                                                                            </div>
                                                                            <div class="fileupload-preview thumbnail profile-pic text-center" style="width: 100%;border: none; object-fit: contain;">
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
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel">
                                                                <div class="panel-body">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Name</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="name" name="name" placeholder="Enter Sales Name">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Gender</div>
                                                                            <select class="desk form-control" id="gender"style="color: black;" name="gender" >
                                                                                <option value="male">Male</option>
                                                                                <option value="female">Female</option>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Email</div>
                                                                            <input type="textEmail" class="form-control desk" style="color: black;" id="email" name="email" placeholder="Enter Email">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Phone</div>
                                                                            <input type="phone" class="form-control desk" id="phone" style="color: black;" name="phone" placeholder="Enter Phone Number">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Area</div>
                                                                            <select class="desk form-control" id="id_area"style="color: black;" name="id_area" >
                                                                                <?php foreach ($arealist as $areas):?>
                                                                                <option value="{{$areas->id}}">{{$areas->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Address</div>
                                                                            <textarea rows="4" class="form-control desk" id="address" style="color: black;" name="address" placeholder="Enter Address"></textarea>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Password</div>
                                                                            <input type="password" class="form-control desk" id="password" style="color: black;" name="password" placeholder="Enter Password">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Confirm Password</div>
                                                                            <input type="password" class="form-control desk" id="confirm_password" style="color: black;" name="confirm_password" placeholder="Enter Password Again">
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
                        


                        <div aria-hidden="true" role="dialog"  id="SalesDetailModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="SalesDetailModalTitle">Sales Details</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">
                                        <input type="hidden" id="idSales">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="profile-pic text-center">
                                                                    <img style="object-fit: contain;" id="ProfilePic"/>
                                                                </div>
                                                                <div class="text-center">
                                                                    <a href="#EditPhotoModal" data-toggle="modal" data-original-title='editphotosales' onclick="editPhoto()" class='btn btn-default btn-sm '>Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <ul class="p-info">
                                                                    <li>
                                                                        <div class="title">Gender</div>
                                                                        <div class="desk" id="ProfileGender">Male</div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="title">Area</div>
                                                                        <div class="desk" id="ProfileArea"></div>
                                                                    </li>
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
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body p-states">
                                                                <div class="summary pull-left">
                                                                    <h4>Total</h4>
                                                                    <span>Customer</span>
                                                                    <h3><div id="ProfileCustomerCount"></div></h3>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body p-states">
                                                                <div class="summary pull-left">
                                                                    <h4>Total</h4>
                                                                    <span>Transaction</span>
                                                                    <h3><div id="ProfileTransactionCount"></div></h3>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="profile-desk">
                                                                    <h1 id="ProfileName"></h1>
                                                                    <a href="#EditSalesModal" data-toggle="modal" data-original-title='editsales' onclick="editPhoto()" class='btn btn-default btn-sm pull-right'>Edit Data</a>
                                                                    <a href="#PasswordModal" data-toggle="modal" data-original-title='changepassword' class='btn btn-default btn-sm pull-right'>Change Password</a>
                                                                    <span id="ProfileJoined" style="margin-bottom: 10px"></span>

                                                                    
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
                                                                        <a href="#statistic" data-toggle="tab"><i class="fas fa-chart-bar"></i> Statistic</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#customer" data-toggle="tab"><i class="fas fa-user"></i> Customer</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#transaction" data-toggle="tab"><i class="fas fa-cash-register"></i> Transaction</a>
                                                                    </li>
                                                                    <li class="">
                                                                        <a href="#todo" data-toggle="tab"><i class="fas fa-clipboard-check"></i> To Do</a>
                                                                    </li>
                                                                </ul>
                                                            </header>
                                                            <div class="panel-body">
                                                                <div class="tab-content">
                                                                    <div class="tab-pane active" id="statistic">
                                                                        <strong> Transaction Count Past 1 Year</strong>
                                                                        <div id="transaction-chart">
                                                                            <div id="transaction-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                            </div>
                                                                        </div>
                                                                        <br><br>
                                                                        <strong> Total Selling Past 1 Year</strong>
                                                                        <div id="selling-chart">
                                                                            <div id="selling-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="customer">
                                                                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}

                                                                        <table  class="display table table-striped" id="customer_table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>
                                                                                        Company Name
                                                                                    </th>
                                                                                    <th>
                                                                                        Administrator Name
                                                                                    </th>
                                                                                    <th>
                                                                                        Area
                                                                                        <a id="AreaFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                                                                    </th>
                                                                                    <th>
                                                                                        Level
                                                                                        <a id="LevelFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                                                                    </th>
                                                                                    <th>
                                                                                        Tempo
                                                                                        <a id="TempoFilter" style="text-decoration: none;color: #dddddd"  class="fas fa-filter pull-right"></a>
                                                                                    </th>
                                                                                    <th>
                                                                                        Limit
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="ProfileCustomerList"></tbody>
                                                                            
                                                                                
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>Company Name</th>
                                                                                    <th>Administrator Name</th>
                                                                                    <th>Area</th>
                                                                                    <th>Level</th>
                                                                                    <th>Tempo</th>
                                                                                    <th>Limit</th>

                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
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
                                                                                    <th>
                                                                                        Sub Total
                                                                                    </th>
                                                                                    <th>
                                                                                        Total
                                                                                    </th>
                                                                                    <!-- <th>
                                                                                        Total Payment
                                                                                    </th>
                                                                                    <th>
                                                                                        Payment Paid
                                                                                    </th> -->
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="ProfileTransactionList"></tbody>
                                                                    
                                                                        </table>
                                                                    </div>
                                                                    <div class="tab-pane" id="todo">
                                                                        <ul class="to-do-list" id="sortable-todo">
                                                                            
                                                                        </ul>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <form role="form" id="ToDoForm" name="ToDoForm">
                                                                                    <div class="form-group todo-entry">
                                                                                        <input type="text" placeholder="Enter Sales To Do List" class="form-control" name="message" style="width: 100%">
                                                                                    </div>
                                                                                    <button class="btn btn-primary pull-right" type="submit">+</button>
                                                                                </form>
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
                                    <div class="modal-footer">
                                        <button type="button" id="sus_button" class="btn btn-danger">Suspend Sales</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" role="dialog"  id="EditPhotoModal" class="modal fade">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="EditPhotoForm" name="EditPhotoForm">

                                        <div class="modal-header" style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="EditPhotoModalTitle">Change Sales Photo</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" id="photo_id">
                                            <div class="form-group" id="icon_current">
                                                <label class="control-label">Current Photo</label>
                                                <div class="profile-pic" style="max-width: 200px; max-height: 150px; line-height: 20px;margin-bottom: 0px">
                                                    <img id="icon_cur" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" style="max-height: 148px" alt="" />
                                                </div>
                                                <br/>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">New Profile Photo</label>
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" style="max-height: 150px" alt="" />
                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div style="margin-left: 5px">
                                                        <span class="btn btn-default btn-file">
                                                           <span class="fileupload-new"><i class="fas fa-paperclip"></i> Select image</span>
                                                           <span class="fileupload-exists"><i class="fas fa-undo"></i> Change</span>
                                                           <input id="changePhoto" name="photo" type="file" class="default" />
                                                        </span>
                                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fas fa-trash"></i> Remove</a>
                                                    </div>
                                                </div>
                                                <br/>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
                                        
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" role="dialog"  id="EditSalesModal" class="modal fade">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="EditSalesForm" name="EditSalesForm">

                                        <input type="hidden" name="id" id="edit_id">
                                        <div class="modal-header" style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="EditSalesModalTitle">Form Title</h4>
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
                                                                            <div class="title">Name</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="edit_name" name="name" placeholder="Enter Sales Name">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Gender</div>
                                                                            <select class="desk form-control" id="edit_gender"style="color: black;" name="gender" >
                                                                                <option value="male">Male</option>
                                                                                <option value="female">Female</option>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Email</div>
                                                                            <input type="textEmail" class="form-control desk" style="color: black;" id="edit_email" name="email" placeholder="Enter Email">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Phone</div>
                                                                            <input type="phone" class="form-control desk" id="edit_phone" style="color: black;" name="phone" placeholder="Enter Phone Number">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Area</div>
                                                                            <select class="desk form-control" id="edit_id_area"style="color: black;" name="id_area" >
                                                                                <?php foreach ($arealist as $areas):?>
                                                                                <option value="{{$areas->id}}">{{$areas->name}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Address</div>
                                                                            <textarea rows="4" class="form-control desk" id="edit_address" style="color: black;" name="address" placeholder="Enter Address"></textarea>
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
                        <div aria-hidden="true" role="dialog"  id="PasswordModal" class="modal fade ">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="PasswordForm" name="PasswordForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header " style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PasswordModalTitle">Change Password</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <ul class="p-info"> 
                                                            <li>
                                                                <div class="title">Current Password</div>
                                                                <div class="desk" id="ProfilePassword"></div>
                                                            </li>
                                                            <li>
                                                                <div class="title">Password</div>
                                                                <input type="password" class="form-control desk" id="password" style="color: black;" name="password_change" placeholder="Enter Password">
                                                            </li>
                                                            <li>
                                                                <div class="title">Confirm Password</div>
                                                                <input type="password" class="form-control desk" id="confirm_password" style="color: black;" name="confirm_password_change" placeholder="Enter Password Again">
                                                            </li>


                                                        </ul>
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
                        
                    </div>
                </section>
            </div>
        </div>
    </div>
    @section('script')

        <script>

            window.onclick = function(event) {
                if (!event.target.matches('#AreaHeader, #AreaHeader *') ) {
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
                    case "area":
                        document.getElementById("areaDropdown").classList.toggle("show");
                        break;
                }
            }

            function clearSelection(type) {
                switch(type) {
                    case "area":
                        $.each($("input[name='area']"), function(){     
                            $(this).prop("checked",false);
                        });
                        checkFilter();
                        break;
                }
            }
            function allSelection(type) {
                switch(type) {
                    case "area":
                        $.each($("input[name='area']"), function(){     
                            $(this).prop("checked",true);
                        });
                        checkFilter();
                        break;
                }
            }

            function searchFilter(type) {
                switch(type) {
                    case "area":
                        $("#AreaFilterList div").filter(function() {
                            var value=$(this).text().toLowerCase();
                            var elm=this;

                            var searchtext=$("#areaSearch").val().toLowerCase();
                            var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                            $(this).toggle(search);
                        });
                        break;
                }

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

                $("input[type='checkbox']").click(function() {
                    checkFilter();
                });
            });

            function getTables() {
                @if (!empty($area))
                    var url="{{ url('/dashboard/employee/list/'.$area->id) }}";
                @else
                    var url="{{ url('/dashboard/employee/list') }}";
                @endif
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        $('#salestable').html(res.data);


                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();
                

                $("#salestable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;

                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    var area=false;
                    $.each($("input[name='area']:checked"), function(){     
                        area=( $(elm).children().eq(5).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||area;
                    });

                    $(this).toggle(search && area);
                });
            }


            function editSales() {

                var id = $('#idSales').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/employee/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#edit_id').val(res.id);
                        $('#edit_name').val(res.name);
                        $('#edit_gender').val(res.gender);
                        $('#edit_email').val(res.email);
                        $('#edit_phone').val(res.phone);
                        $('#edit_address').val(res.address);
                        $('#edit_id_area').val(res.area['id']);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/employee/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#SalesDetailModalTitle').html("Sales Details");
                        $('#SalesDetailModal').modal('show');

                        $('#idSales').val(res.id);

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
                        $('#sortable-todo').html(res.todolist);
                        $('#ProfilePassword').html(res.password_unhash);



                        var transaction=[];
                        var selling=[];
                        $.each(res.chart, function(){     
                            transaction.push([gd(this.year,this.month),this.transaction]);
                            selling.push([gd(this.year,this.month),this.selling]);
                        });
                        transactionChart(transaction);
                        sellingChart(selling);


                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }
            function editPhoto() {

                var id = $('#idSales').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/employee/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#photo_id').val(res.id);
                        $('#icon_cur').attr('src',res.photo_url);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            $(document).on('click', '.remove-todo', function () {
                var elem=this;
                var id=$(this).parents('.todo-actionlist').parents('li').children('.todo-check').children('#id_todo').val();
                console.log(id);
                if (confirm("Delete Sales To Do?") == true) {
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/employee/todo/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            $(elem).closest("li").remove();
                            return false;
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }

            }); 

            function add(){
                $('#SalesForm').trigger("reset");
                $('#SalesModalTitle').html("Add Sales");
                $('#id').val('');
            };

            $('#SalesForm').submit(function(e) {

                e.preventDefault();
                if($('#password').val()!=$('#confirm_password').val()){
                    alert('Password Didnt Match!');
                }else{
                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/employee/store')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#SalesModal").modal('hide');
                            getTables();
                            $("#btn-save").html('Submit');
                            $("#btn-save").attr("disabled", false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 
                }
               
            });
            $('#EditSalesForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/employee/edit')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#EditSalesModal").modal('hide');
                        $("#SalesDetailModal").modal('hide');
                        getTables();
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });
            $('#EditPhotoForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/employee/photo')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#EditPhotoModal").modal('hide');
                        $("#SalesDetailModal").modal('hide');
                        getTables();
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });

            $('#ToDoForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("id_sales", $('#idSales').val());

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/employee/todo/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#ToDoForm').trigger("reset");
                        getToDo(data.id_sales);
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });
            $('#PasswordForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("id_sales", $('#idSales').val());

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/employee/password')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#PasswordForm').trigger("reset");
                        $('#PasswordModal').modal('hide');
                        console.log(data);
                        $('#ProfilePassword').html(data.password_unhash);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });
            function getToDo(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/employee/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#sortable-todo').html(res.todolist);
                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                
            }

            $('#sus_button').click(function (e) {
                e.preventDefault();
                var id=$('#idSales').val();

                if (confirm("Suspend This Sales?") == true) {
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/employee/suspend') }}",
                        data: { id: id },
                        dataType: 'json',
                        success:  function(res){ 
                            $("#SalesDetailModal").modal('hide');
                            getTables();
                            $("#btn-save").html('Submit');
                            $("#btn-save").attr("disabled", false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 
                }
            
            })

            
            

            function transactionChart(x) {
                var past = new Date();
                past.setMonth(past.getMonth()-11);

                $.plot($("#transaction-chart #transaction-container"), [
                    {
                        data: x,
                        label: "Transaction Complete",
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
                            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            mode: "time",
                            tickSize: [1, "month"],
                            min: past,
                            max: new Date().getTime(),
                            timeformat: "%b %Y",
                        }
                    }
                );
            }

            function sellingChart(x) {
                var past = new Date();
                past.setMonth(past.getMonth()-11);

                $.plot($("#selling-chart #selling-container"), [
                    {
                        data: x,
                        label: "Selling",
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
                            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
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
                return new Date(year, month - 1).getTime();
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
                }).appendTo("#SalesDetailModal").fadeIn(200);
            }

            $("#transaction-container").on("plothover", function (event, pos, item) {
                if (item) {
                    if ( previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
                        $("#tooltip").remove();

                        var x = item.datapoint[0];
                        var y = item.datapoint[1];

                        var color = item.series.color;

                        showTooltip(item.pageX,
                        item.pageY,
                        color,
                            "<strong>" + y + " Transaction Complete</strong> ");
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

            $("#selling-container").on("plothover", function (event, pos, item) {
                if (item) {
                    if ( previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
                        $("#tooltip").remove();

                        var x = item.datapoint[0];
                        var y = item.datapoint[1];

                        var color = item.series.color;

                        showTooltip(item.pageX,
                        item.pageY,
                        color,
                            "<strong>" + y + " Selling on This Month</strong> ");
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
            
            function addcustomer(id) {
                $('#AddCustomerForm').trigger("reset");
                $('#id_sales').val(id);
            }

            $(function() {
                $('#AddCustomerForm').stepy({
                    backLabel: 'Back',
                    nextLabel: 'Next',
                    errorImage: true,
                    block: true,
                    description: true,
                    legend: false,
                    titleClick: true,
                    titleTarget: '#top_tabby',
                    validate: true
                });
                $('#AddCustomerForm').validate({
                    errorPlacement: function(error, element) {
                        $('#AddCustomerForm div.stepy-error').append(error);
                    },
                    rules: {
                        'company_name': 'required',
                        'company_address': 'required',
                        'id_area': 'required',
                        'administrator_name': 'required',
                        'administrator_id': 'required',
                        'administrator_phone': 'required'
                    },
                    messages: {
                        'company_name': {
                            required: 'Company Name field is required!'
                        },
                        'company_address': {
                            required: 'Company Address field is required!'
                        },
                        'administrator_name': {
                            required: 'Administrator Name field is required!'
                        },
                        'administrator_id': {
                            required: 'Administrator KTP field is required!'
                        },
                        'administrator_phone': {
                            required: 'Administrator Phone field is required!'
                        },
                    }
                });

                $('#AddCustomerForm').submit(function(e) {

                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/employee/addcustomer')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#SalesModal").modal('hide');
                            var oTable = $('#sales_table').dataTable();
                            oTable.fnDraw(false);
                            $("#btn-save").html('Submit');
                            $("#btn-save").attr("disabled", false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 
                
                   
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
