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
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datepicker/css/datepicker-custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-timepicker/css/timepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-colorpicker/css/colorpicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datetimepicker/css/datetimepicker-custom.css')}}" />
    @endsection
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Fixed Assets
        </h3>
        <div class="state-info">

            <a href="{{ url('dashboard/asset/add') }}" class=" btn btn-primary ">Record Asset <i class="fa fa-plus"></i></a>
        </div>
    </div>
    <!-- page heading end-->


    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading custom-tab dark-tab ">
                        <ul class="nav nav-tabs">
                            {{-- <li class="active">
                                <a href="#pending" data-toggle="tab">Pending Assets</a>
                            </li> --}}
                            <li class="active">
                                <a href="#active" data-toggle="tab">Active Assets</a>
                            </li>
                            <li>
                                <a href="#sold" data-toggle="tab">Sold/Disposed</a>
                            </li>
                            <li>
                                <a href="#depreciation" data-toggle="tab">Depreciation</a>
                            </li>
                        </ul>
                    </header>

                    <div class="panel-body">
                        <div class="tab-content">
                            {{-- <div class="tab-pane active" id="pending">

                                <h2>Purchased Assets Not Recorded Yet</h2>
                                <table class="display table table-hover " id="pending_assets_table">
                                    <thead>
                                        <tr>
                                            <th>
                                                Acquisition Date
                                            </th>
                                            <th>
                                                Item
                                            </th>
                                            <th>
                                                Invoice #
                                            </th>
                                            <th>
                                                Acquisition Cost
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assets as $asset)
                                        <tr>
                                            <td id="pending_asset_date">
                                                {{ $asset['acquisition_date'] }}
                                            </td>
                                            <td id="pending_asset_name">
                                                {{ $asset['name'] }}
                                            </td>
                                            <td>
                                                <a href="{{ url('dashboard/finance/purchase/invoice/'. $asset['invoice']['id']) }}">{{ $asset['invoice']['type_and_number'] }}</a>
                                            </td>
                                            <td id="pending_asset_cost">
                                                {{ $asset['acquisition_cost'] }}
                                            </td>
                                            <td>
                                                <select class="form-select" id="pending_action">
                                                    @foreach($asset['action_list'] as $val)
                                                        <option value="$val['action']">{{ ucfirst($val['action']) }}</option>
                                                    @endforeach
                                                </select>

                                                <button class="btn btn-primary btn_pending_act" assetid="{{$asset['id']}}">Go</button>
                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>

                                </table>
                            </div> --}}

                            <div class="tab-pane active" id="active">
                                <h2>List of Active Assets</h2>

                                <table class="display table table-hover " id="active_assets_table">
                                    <thead>
                                        <tr>
                                            <th>
                                                Acquisition Date
                                            </th>
                                            <th>
                                                Asset Detail
                                            </th>
                                            <th>
                                                Asset Account
                                            </th>
                                            <th>
                                                Acquisition Cost (in IDR)
                                            </th>
                                            <th>
                                                Book Value (in IDR)
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeassets as $activeasset)
                                        <tr>
                                            <td>
                                                {{ $activeasset['acquisition_date'] }}
                                            </td>
                                            <td id="activeassetname">
                                                <a href="#">{{ $activeasset['name'] }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ url('dashboard/finance/account/'.$activeasset['asset_account']['id']) }}">{{ $activeasset['asset_account']['name_and_code']}}</a>
                                            </td>
                                            <td>
                                                {{ $activeasset['acquisition_cost_currency_format'] }}
                                            </td>
                                            <td>
                                                {{ $activeasset['book_value_currency_format'] }}
                                            </td>
                                            <td>
                                                <select class="form-select" id="active_action">
                                                    @foreach($activeasset['action_list'] as $val)
                                                        <option value="$val['action']">{{ ucfirst($val['action']) }}</option>
                                                    @endforeach
                                                </select>

                                                <button class="btn btn-primary btn_active_act" assetid="{{$activeasset['id']}}">Go</button>
                                            </td>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <div class="tab-pane" id="sold">

                                <h2>List of Sold Assets</h2>
                                <table class="display table table-hover " id="sold_assets_table">
                                    <thead>
                                        <tr>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Asset Detail
                                            </th>
                                            <th>
                                                Transaction No
                                            </th>
                                            <th>
                                                Sale Price (in IDR)
                                            </th>
                                            <th>
                                                Gain Loss (in IDR)
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($soldassets as $soldasset)
                                            <tr>
                                                <td>
                                                    {{ $soldasset['disposal_date'] }}
                                                </td>
                                                <td>
                                                    {{ $soldasset['name'] }}
                                                </td>
                                                <td>
                                                    Journal Entry #{{ $soldasset['transaction']['transaction_no'] }}
                                                </td>
                                                <td>
                                                    {{ $soldasset['sale_price'] }}
                                                </td>
                                                <td>
                                                    {{ $soldasset['gain_loss_currency_format'] }}
                                                </td>
                                                <td>
                                                    <select class="form-select" id="sold_action">
                                                    @foreach($soldasset['action_list'] as $val)
                                                        <option value="$val['action']">{{ ucfirst($val['action']) }}</option>
                                                    @endforeach
                                                    </select>

                                                    <button class="btn btn-primary btn_sold_act" assetid="{{$soldasset['id']}}">Go</button>
                                                    </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>

                            <div class="tab-pane" id="depreciation">
                                <h2>Depreciation Schedule</h2>
                                <table class="display table table-hover " id="active_assets_table">
                                    <thead>
                                        <tr>
                                            <th>
                                                Asset Detail
                                            </th>
                                            <th>
                                                Period
                                            </th>
                                            <th>
                                                Rate
                                            </th>
                                            <th>
                                                Method
                                            </th>
                                            <th>
                                                Depreciation Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($depreciationassets as $depreciationasset)
                                        <tr>
                                            <td>
                                                {{ $depreciationasset['name'] }}
                                            </td>
                                            <td>
                                                {{ $depreciationasset['period'] }}
                                            </td>
                                            <td>
                                                {{ $depreciationasset['rate'] }}
                                            </td>
                                            <td>
                                                {{ $depreciationasset['depreciation_method'] }}
                                            </td>
                                            <td>
                                                {{ $depreciationasset['depreciation_amount'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>        
                                </table>
                            </div>
                    </table>
                    <div aria-hidden="true" role="dialog"  id="DisposeModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form role="form" id="DisposeForm" name="DisposeForm">

                                    <input type="hidden" name="id" id="IdAsset">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="DisposeModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">Dispose</div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="p-info">
                                                            <li>
                                                                <div class="title">Transaction Date</div>
                                                                <input class="form-control desk default-date-picker" style="color: black;" name="date" id="date" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                            </li>
                                                            <li>
                                                                <div class="title">Sale Price</div>
                                                                <input type="number" min="1" class="form-control desk" style="color: black;text-align: right;" id="sale_price" name="sale_price" value="0">
                                                            </li>
                                                            <li>
                                                                <div class="title">Payment Account</div>
                                                                <select class="desk form-control" id="account" style="color: black;" name="account" >
                                                                    <?php foreach ($accounts as $account):?>
                                                                        <option value="{{$account->jurnal_id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                    <?php endforeach?>
                                                                </select>
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
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('js/jquery.stepy.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-multi-select/js/jquery.quicksearch.js')}}"></script>
        <script src="{{asset('js/multi-select-init.js')}}"></script>
        <script src="{{asset('js/pickers-init.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>

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

                $(".btn_pending_act").click( function(e){
                    //console.log("click");
                    e.preventDefault();

                    var elem = $(this).parent().parent();

                    var action = $(elem).find("#pending_action :selected").text();

                    var getcost = $(elem).find("#pending_asset_cost").text().trim();
                    var cost = getcost.substring(4, (getcost.length - 3));

                    while(cost.includes(".")){
                        cost = cost.replace(".", "");
                    }

                    var name = $(elem).find("#pending_asset_name").text().trim();
                    var idasset = $(this).attr("assetid");
                    var date = $(elem).find("#pending_asset_date").text().trim();

                    console.log($(elem).find("#pending_asset_name").text().trim());
                    console.log(date);

                    if(action == "Record"){
                        var url = "{{ url('/dashboard/asset/add/') }}";
                        
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                               name: name,
                               acquisition_date: date,
                               acquisition_cost: parseInt(cost),
                               asset_account_id: 39910522,
                               credited_account_id: 39910510, 
                               non_depreceable: true
                            },
                            success: function (response)
                            {
                                console.log(response);
                                // location.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                           }
                        });
                    }
                    else if(action == "Delete"){
                        var url = "{{ url('/dashboard/asset/delete/') }}/" + idasset;

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                "id": idasset
                            },
                            success: function (response)
                            {
                                console.log(response);
                                location.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                           }
                        });
                    }

                });

                $(".btn_active_act").click( function(e){
                    e.preventDefault();

                    var elem = $(this).parent().parent();

                    var action = $(elem).find("#active_action :selected").text();
                    var idasset = $(this).attr("assetid");

                    if(action == "Edit"){
                        var url = "{{ url('/dashboard/asset/edit/') }}/" + idasset;
                        window.location.href =url;
                    }
                    else if(action == "Sell/Dispose"){
                        $('#DisposeForm').trigger("reset");
                        $('#DisposeModalTitle').html("Disposal Details");
                        $('#DisposeModal').modal('show');
                        $('#IdAsset').val(idasset);
                    }
                    else if(action == "Delete"){
                        var url = "{{ url('/dashboard/asset/delete/') }}/" + idasset;

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                "id": idasset
                            },
                            success: function (response)
                            {
                                console.log(response);
                                location.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                           }
                        });
                    
                    }

                });

                $(".btn_sold_act").click( function(e){
                    e.preventDefault();

                    var elem = $(this).parent().parent();

                    var action = $(elem).find("#sold_action :selected").text();
                    var idasset = $(this).attr("assetid");

                    if(action == "Revert Depreciation"){
                        var url = "{{ url('/dashboard/asset/revert_depreciation/') }}/" + idasset;

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                "id": idasset
                            },
                            success: function (response)
                            {
                                console.log(response);
                                location.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                           }
                        });
                    }
                    else if(action == "Delete"){
                        var url = "{{ url('/dashboard/asset/delete/') }}/" + idasset;

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                "id": idasset
                            },
                            success: function (response)
                            {
                                console.log(response);
                                location.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                           }
                        });
                    }

                });
                
            });
            $('#DisposeForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/asset/dispose/')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        location.reload();
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            })

            function getTables() {
                var url="{{ url('/dashboard/asset/') }}";
                
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        console.log(res.assets);
                        


                        $.each(res.assets, function(key, value){

                                
                                $row="<tr>";
                                $row+="<td>" + value.acquisition_date + "</td>";
                                $row+="<td>" + value.name + "</td>";
                                $row+="<td>" + value.invoice.type_and_number + "</td>";
                                $row+="<td>" + value.acquisition_cost.toLocaleString('id', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + "</td>";
                                $row+="<td>" + "" + "</td></tr>";

                                $('#pending_assets_table').append($row);

                        });
                        
                    },
                    error: function(error){
                        console.log("error gan");
                    }
                });


            }
                
        </script>

    @endsection
<!--body wrapper end-->
</x-app-layout>ayout>
