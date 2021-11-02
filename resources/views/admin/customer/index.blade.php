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
            Manage Customer @isset ($area)
                {{$area->name}}
            @endisset
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Customer </li>
            @isset ($area)
                <li class="active"> Manage Customer {{$area->name}}</li>
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
                        Manage Customer @isset ($area)
                            {{$area->name}}
                        @endisset
                        <span class="pull-right">
                            <a href="#CustomerModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Customer <i class="fa fa-plus"></i></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
                                    <label style="float: right; width: 40%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="customer_table">
                                <thead>
                                    <tr>
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
                                        <th class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customertable"></tbody>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="CustomerModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="CustomerModalTitle">Add Customer</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="fw-title">Add Customer</h4>
                                                <div class="box-widget">
                                                    <div class="widget-head clearfix">
                                                        <div id="top_tabby" class="block-tabby pull-left">
                                                        </div>
                                                    </div>
                                                    <div class="widget-container">
                                                        <div class="widget-block">
                                                            <div class="widget-content box-padding">
                                                                <form id="CustomerForm"  class=" form-horizontal left-align form-well">
                                                                    <fieldset title="Step 1">
                                                                        <legend>Company Data</legend>
                                                                        <input class="form-control" name="id_sales" id="id_sales" placeholder="Enter Company Name" type="hidden"/>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Company Name</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input class="form-control" name="company_name" placeholder="Enter Company Name" type="text"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Company Address</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <textarea rows="4" class="form-control " style="padding: 10px 10px;" name="company_address" placeholder="Enter Company Address"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Company Phone Number</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input class="form-control" name="company_phone" placeholder="Enter Company Phone" type="phone"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Company NPWP</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input class="form-control" name="company_npwp" placeholder="Enter Company NPWP" type="text"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Company Area</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <select class=" form-control" id="id_area"style="padding: 0px 10px;" name="id_area" >
                                                                                    <?php foreach ($arealist as $areas):?>
                                                                                    <option value="{{$areas->id}}">{{$areas->name}}</option>
                                                                                    <?php endforeach?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset title="Step 2">
                                                                        <legend>Administrator Data</legend>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Name</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input type="text" placeholder="Administrator Name" name="administrator_name" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">KTP Number</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input type="text" placeholder="Administrator KTP Number" name="administrator_id" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Birthdate</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input type="text" placeholder="Administrator Birthdate" name="administrator_birthdate" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Phone Number</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input type="phone" placeholder="Administrator Phone Number" name="administrator_phone" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Address</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <textarea rows="4" class="form-control desk" style="color: black;" name="administrator_address" placeholder="Enter Administrator Address"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">NPWP</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <input type="text" placeholder="Administrator NPWP" name="administrator_npwp" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset title="Step 3">
                                                                        <legend>Customer Details</legend>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Sales</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <select class=" form-control" id="id_sales"style="padding: 0px 10px;" name="id_sales" >
                                                                                    <?php foreach ($sales as $list):?>
                                                                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                                                                    <?php endforeach?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                    
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 control-label">Level</label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <select class=" form-control" id="id_level" style="padding: 0px 10px;" name="id_level" >
                                                                                    <?php foreach ($levels as $level):?>
                                                                                    <option value="{{$level->id}}">{{$level->level}} - {{$level->tempo_limit}} days with loan limit {{$level->loan_limit}}</option>
                                                                                    <?php endforeach?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <button type="submit" class="finish btn btn-info btn-extend"> Finish!</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div aria-hidden="true" role="dialog"  id="CustomerDetailModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="CustomerDetailModalTitle">Customer Details</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">

                                        <input type="hidden" id="idCustomer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="profile-desk">
                                                                    <h1 id="CustomerCompanyName"></h1>
                                                                    <span id="CustomerAdministratorName" style="margin-bottom: 10px"></span>
                                                                    <br>
                                                                    <span id="CustomerJoined" style="margin-bottom: 10px"></span>
                                                                    
                                                                    <a href="#EditCustomerModal" data-toggle="modal" data-original-title='editcustomer' onclick="editCustomer()" class='btn btn-default btn-sm pull-right'>Edit Data</a>

                                                                    <a href="#LevelModal" data-toggle="modal" data-original-title='changelevel' class='btn btn-default btn-sm pull-right'>Change Level</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="panel">
                                                                    <div class="panel-body">
                                                                        <ul class="p-info">
                                                                            <li>
                                                                                <div class="title">Level</div>
                                                                                <div class="desk" id="CustomerLevel"></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="title">Tempo</div>
                                                                                <div class="desk" id="CustomerTempo"></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="title">Loan Limit</div>
                                                                                <div class="desk" id="CustomerLoanLimit"></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="title">Invited By</div>
                                                                                <div class="desk" id="CustomerInvitedBy"></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="title">Area</div>
                                                                                <div class="desk" id="CustomerArea"></div>
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
                                                                            <span>Transaction</span>
                                                                            <h3><div id="CustomerTotalTransaction"></div></h3>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="panel">
                                                                    <div class="panel-body p-states">
                                                                        <div class="summary pull-left">
                                                                            <h4>Total</h4>
                                                                            <span>Unpaid Debt </span>
                                                                            <h3><div id="CustomerTotalUnpaid"></div></h3>
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
                                                                    <header class="panel-heading custom-tab ">
                                                                        <ul class="nav nav-tabs">
                                                                            <li class="active">
                                                                                <a href="#statistic" data-toggle="tab"><i class="fas fa-chart-bar"></i> Statistic</a>
                                                                            </li>
                                                                            <li class="">
                                                                                <a href="#detail" data-toggle="tab"><i class="fas fa-user"></i> Detail</a>
                                                                            </li>
                                                                            <li class="">
                                                                                <a href="#photos" data-toggle="tab"><i class="fas fa-user"></i> Photos</a>
                                                                            </li>
                                                                            <li class="">
                                                                                <a href="#transaction" data-toggle="tab"><i class="fas fa-cash-register"></i> Transaction</a>
                                                                            </li>
                                                                        </ul>
                                                                    </header>
                                                                    <div class="panel-body">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="statistic">
                                                                                Transaction Success Past 1 Year
                                                                                <div id="transaction-chart">
                                                                                    <div id="transaction-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane" id="detail">
                                                                                <ul class="p-info">
                                                                                    <li>
                                                                                        <div class="title">Company Address</div>
                                                                                        <div class="desk" id="CustomerCompanyAddress"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Company Phone Number</div>
                                                                                        <div class="desk" id="CustomerCompanyPhone"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Company NPWP</div>
                                                                                        <div class="desk" id="CustomerCompanyNPWP"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Administrator ID</div>
                                                                                        <div class="desk" id="CustomerAdministratorID"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Administrator Birthdate</div>
                                                                                        <div class="desk" id="CustomerAdministratorBirthdate"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Administrator NPWP</div>
                                                                                        <div class="desk" id="CustomerAdministratorNPWP"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Administrator Phone Number</div>
                                                                                        <div class="desk" id="CustomerAdministratorPhone"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="title">Administrator Address</div>
                                                                                        <div class="desk" id="CustomerAdministratorAddress"></div>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>

                                                                            <div class="tab-pane" id="photos">
                                                                                <div class="btn-group pull-right">
                                                                                    <a  href="#PhotoModal" data-toggle="modal">
                                                                                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-folder-open"></i> Add New</button>
                                                                                    </a>
                                                                                </div>
                                                                                <div id="CustomerPhoto" class="media-gal">
                                                                            
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
                                                                                                Total Payment
                                                                                            </th>
                                                                                            <!-- <th>
                                                                                                Payment Paid
                                                                                            </th>
                                                                                            <th>
                                                                                                Product Count
                                                                                            </th> -->
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="TransactionList"></tbody>
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
                                    <div class="modal-footer">
                                        <button type="button" id="sus_button" class="btn btn-danger">Suspend Customer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" role="dialog"  id="EditCustomerModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="EditCustomerModalTitle">Edit Customer</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="box-widget">
                                                            <div class="widget-head clearfix">
                                                                <div id="top_tabby" class="block-tabby pull-left">
                                                                </div>
                                                            </div>
                                                            <div class="widget-container">
                                                                <div class="widget-block">
                                                                    <div class="widget-content box-padding">
                                                                        <form id="EditCustomerForm"  class=" form-horizontal left-align form-well">
                                                                            <input type="hidden" name="id" id="edit_id">
                                                                            <fieldset title="Step 1">
                                                                                <legend>Company Data</legend>
                                                                                <input class="form-control" name="id_sales" id="edit_id_sales" placeholder="Enter Company Name" type="hidden"/>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Company Name</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input class="form-control" id="edit_company_name" name="company_name" placeholder="Enter Company Name" type="text"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Company Address</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <textarea rows="4" class="form-control " style="padding: 10px 10px;"  id="edit_company_address" name="company_address" placeholder="Enter Company Address"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Company Phone Number</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input class="form-control" id="edit_company_phone" name="company_phone" placeholder="Enter Company Phone" type="phone"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Company NPWP</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input class="form-control" id="edit_company_npwp" name="company_npwp" placeholder="Enter Company NPWP" type="text"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Company Area</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <select class=" form-control" id="edit_id_area"style="padding: 0px 10px;" name="id_area" >
                                                                                            <?php foreach ($arealist as $areas):?>
                                                                                            <option value="{{$areas->id}}">{{$areas->name}}</option>
                                                                                            <?php endforeach?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                            <fieldset title="Step 2">
                                                                                <legend>Administrator Data</legend>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Name</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input type="text" placeholder="Administrator Name" name="administrator_name"  id="edit_administrator_name" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">KTP Number</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input type="text" id="edit_administrator_id" placeholder="Administrator KTP Number" name="administrator_id" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Birthdate</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input type="text" id="edit_administrator_birthdate" placeholder="Administrator Birthdate" name="administrator_birthdate" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Phone Number</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input type="phone" id="edit_administrator_phone" placeholder="Administrator Phone Number" name="administrator_phone" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Address</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <textarea rows="4" class="form-control desk" style="color: black;" id="edit_administrator_address" name="administrator_address" placeholder="Enter Administrator Address"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">NPWP</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <input type="text" id="edit_administrator_npwp" placeholder="Administrator NPWP" name="administrator_npwp" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                            <fieldset title="Step 3">
                                                                                <legend>Customer Details</legend>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Sales</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <select class=" form-control" id="edit_id_sales"style="padding: 0px 10px;" name="id_sales" >
                                                                                            <?php foreach ($sales as $list):?>
                                                                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                                                                            <?php endforeach?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                            
                                                                                
                                                                                <div class="form-group">
                                                                                    <label class="col-md-2 col-sm-2 control-label">Level</label>
                                                                                    <div class="col-md-6 col-sm-6">
                                                                                        <select class=" form-control" id="edit_id_level" style="padding: 0px 10px;" name="id_level" >
                                                                                            <?php foreach ($levels as $level):?>
                                                                                            <option value="{{$level->id}}">{{$level->level}} - {{$level->tempo_limit}} days with loan limit {{$level->loan_limit}}</option>
                                                                                            <?php endforeach?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                            <button type="submit" class="finish btn btn-info btn-extend"> Finish!</button>
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
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" role="dialog"  id="PhotoModal" class="modal fade ">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="PhotoForm" name="PhotoForm">

                                        <div class="modal-header " style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PhotoModalTitle">Add Customer Photo</h4>
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
                                        <input type="hidden" name="id_customer_photo" id="id_customer_photo">

                                        <div class="modal-header " style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="PhotoDeleteModalTitle">Customer Photo</h4>
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
                        
                        <div aria-hidden="true" role="dialog"  id="LevelModal" class="modal fade ">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="LevelForm" name="LevelForm">

                                        <input type="hidden" name="id" id="id">
                                        <div class="modal-header " style="background: #46B8DA">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="LevelModalTitle">Change Level</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <ul class="p-info"> 
                                                            <li>
                                                                <div class="title">Level</div>
                                                                <select class=" form-control" id="id_level_change" style="padding: 0px 10px;" name="id_level" >
                                                                    <?php foreach ($levels as $level):?>
                                                                    <option value="{{$level->id}}">{{$level->level}} - {{$level->tempo_limit}} days with loan limit {{$level->loan_limit}} 
                                                                        @if($level->nice==1)
                                                                        Nice Customer
                                                                        @else
                                                                        Bad Customer
                                                                        @endif
                                                                    </option>
                                                                    <?php endforeach?>
                                                                </select>
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
            $('#LevelForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("id_customer", $('#idCustomer').val());

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/customer/level/change')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#LevelForm').trigger("reset");
                        $('#LevelModal').modal('hide');
                        getTables();

                        $('#CustomerTempo').html(data.customerlevel.tempo_limit);
                        $('#CustomerLoanLimit').html(data.customerlevel.loan_limit);
                        $('#CustomerLevel').html(data.customerlevel.level);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });
            function getTables() {
                @if (!empty($area))
                    var url="{{ url('/dashboard/customer/list/'.$area->id) }}";
                @else
                    var url="{{ url('/dashboard/customer/list') }}";
                @endif
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        console.log(res);
                        $('#customertable').html(res.data);

                        showFilter($("thead tr th:eq( 3 )"),
                            "areafilter",
                            "<div class='form-group '></div>");

                        $.each(res.area,function (key, value) {
                            $('#areafilter .form-group').append(value);
                        })
                        $('#AreaFilter').click(function() {
                            toggleFilter("areafilter");
                        });

                        showFilter($("thead tr th:eq( 4 )"),
                            "levelfilter",
                            "<div class='form-group '></div>");

                        $.each(res.level,function (key, value) {
                            $('#levelfilter .form-group').append(value);
                        })
                        $('#LevelFilter').click(function() {
                            toggleFilter("levelfilter");
                        });

                        showFilter($("thead tr th:eq( 5 )"),
                            "tempofilter",
                            "<div class='form-group '></div>");

                        $.each(res.tempo,function (key, value) {
                            $('#tempofilter .form-group').append(value);
                        })
                        $('#TempoFilter').click(function() {
                            toggleFilter("tempofilter");
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
            $('#EditCustomerForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/customer/edit')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#EditCustomerModal").modal('hide');
                        $("#CustomerDetailModal").modal('hide');
                        getTables();
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
               
            });

            function editCustomer() {
                
                var id = $('#idCustomer').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#edit_id').val(res.id);
                        $('#edit_company_name').val(res.company_name);
                        $('#edit_company_address').val(res.company_address);
                        $('#edit_company_phone').val(res.company_phone);
                        $('#edit_company_npwp').val(res.company_npwp);
                        $('#edit_id_area').val(res.area.id);
                        $('#edit_administrator_name').val(res.administrator_name);
                        $('#edit_administrator_id').val(res.administrator_id);
                        $('#edit_administrator_birthdate').val(res.administrator_birthdate);
                        $('#edit_administrator_npwp').val(res.administrator_npwp);
                        $('#edit_administrator_phone').val(res.administrator_phone);
                        $('#edit_administrator_address').val(res.administrator_address);
                        $('#edit_id_sales').val(res.sales.id);
                        $('#edit_id_level').val(res.customerlevel.id);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function add(){
                $('#CustomerForm').trigger("reset");
                $('#CustomerModalTitle').html("Add Customer");
                $('#id').val('');
            };

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#CustomerDetailModalTitle').html("Customer Details");
                        $('#CustomerDetailModal').modal('show');
                        $('#idCustomer').val(res.id);
                        $('#id_level_change').val(res.customerlevel.id);

                        $('#CustomerCompanyName').html(res.company_name);
                        $('#CustomerAdministratorName').html(res.administrator_name);
                        $('#CustomerArea').html(res.area.name);
                        $('#CustomerTempo').html(res.customerlevel.tempo_limit);
                        $('#CustomerLoanLimit').html(res.customerlevel.loan_limit);
                        $('#CustomerInvitedBy').html(res.sales.name);
                        $('#CustomerLevel').html(res.customerlevel.level);
                        var join=new Date(res.created_at);
                        $('#CustomerJoined').html("Joined Since "+(join.getDate())+"/"+join.getMonth()+1+"/"+join.getFullYear());
                        $('#CustomerTotalTransaction').html(res.transactioncount+' Transaction');
                        if(res.unpaid){
                            $('#CustomerTotalUnpaid').html(res.unpaid);
                        }else{
                            $('#CustomerTotalUnpaid').html(0);
                        }

                        $('#CustomerCompanyAddress').html(res.company_address);
                        $('#CustomerCompanyPhone').html(res.company_phone);
                        $('#CustomerCompanyNPWP').html(res.company_npwp);
                        $('#CustomerAdministratorID').html(res.administrator_id);
                        $('#CustomerAdministratorBirthdate').html(res.administrator_birthdate);
                        $('#CustomerAdministratorNPWP').html(res.administrator_npwp);
                        $('#CustomerAdministratorPhone').html(res.administrator_phone);
                        $('#CustomerAdministratorAddress').html(res.administrator_address);

                        var data=[];
                        $.each(res.chart, function(){     
                            data.push([gd(this.year,this.month),this.transaction]);
                        });
                        transactionChart(data);

                        $('#CustomerPhoto').html(res.gallery);


                        $('#TransactionList').html(res.transactionlist);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function imgdetail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/photo/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#PhotoDeleteForm').trigger("reset");
                        $('#PhotoDeleteModal').modal('show');
                        $('#id_customer_photo').val(id);
                        $('#icon_cur').attr('src',res.photo_url);



                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            };
            function getPhoto(id) {
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#CustomerPhoto').html(res.gallery);
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
                var idCustomer=$('#idCustomer').val();
                formData.append("id_customer", $('#idCustomer').val());
                formData.append("id_photo_category", 1);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/customer/photo')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#PhotoModal").modal('hide');
                        getPhoto(idCustomer);
                        $('#PhotoForm').trigger('reset');
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
            })

            $('#PhotoDeleteForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var idCustomer=$('#idCustomer').val()

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/customer/photo/delete')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#PhotoDeleteModal").modal('hide');
                        getPhoto(idCustomer);
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            
            })

            function transactionChart(x) {
                var past = new Date();
                past.setMonth(past.getMonth()-11);

                $.plot($("#transaction-chart #transaction-container"), [
                    {
                        data: x,
                        label: "Transaction Success",
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
                }).appendTo("#CustomerDetailModal").fadeIn(200);
            }


            $("#transaction-container").on("plothover", function (event, pos, item) {
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
                            "<strong>" + y + " Transaction Success</strong>");
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#customertable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;


                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    var area=false;
                    $.each($("input[name='area']:checked"), function(){     
                        area=( $(elm).children().eq(3).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||area;
                    });
 
                    var level=false;
                    $.each($("input[name='level']:checked"), function(){     
                        level=( $(elm).children().eq(4).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||level;
                    });

                    var tempo=false;
                    $.each($("input[name='tempo']:checked"), function(){     
                        tempo=( $(elm).children().eq(5).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1 )||tempo;
                    });


                    $(this).toggle(search && area && level && tempo);
                });
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



            $(function() {
                $('#CustomerForm').stepy({
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
                $('#CustomerForm').validate({
                    errorPlacement: function(error, element) {
                        $('#CustomerForm div.stepy-error').append(error);
                    },
                    rules: {
                        'company_name': 'required',
                        'company_address': 'required',
                        'id_area': 'required',
                        'administrator_name': 'required',
                        'administrator_id': 'required',
                        'administrator_phone': 'required',
                        'level': 'required',
                        'tempo': 'required',
                        'loan_limit': 'required',
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
                        'level': {
                            required: 'Level field is required!'
                        },
                        'tempo': {
                            required: 'Tempo field is required!'
                        },
                        'Loan Limit': {
                            required: 'Loan Limit field is required!'
                        },
                    }
                });

                $('#CustomerForm').submit(function(e) {

                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/customer/store')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#CustomerModal").modal('hide');
                            getTables();
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
