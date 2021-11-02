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
            Fixed Assets
        </h3>
        <h2>
            Record New Asset
        </h2>
        
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <form method="POST">
            @csrf
            <div action="/record_new" class="form-group mt-3">
                <h4 class="fw-bolder">Asset Details</h4>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Asset Name*</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Acquisition Date*</label>
                    </div>
                    <div class="col-sm-4">
                        <input data-date-format="mm/dd/yyyy" type="text" class="form-control default-date-picker" value="{{date('m/d/Y')}}" name="acquisition_date" id="acquisition_date" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Asset Number*</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="asset_number" id="asset_number" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Acquisition Cost*</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="acquisition_cost" id="acquisition_cost" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Fixed Asset Account*</label>
                    </div>
                    <div class="col-sm-4">
                        <select id="fixed_asset" class="form-select form-select-lg" name="fixed_asset" required>
                            @foreach($fixedaccounts as $account)
                                    <option value="{{ $account['name'] }}">{{ $account['number'] . " " . $account['name'] }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Account Credited</label>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-select form-select-lg" id="account_credited" name="account_credited">
                            @foreach($accounts as $account)
                                <option value="{{ $account['name'] }}">{{ $account['number'] . " " . $account['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Description</label>
                    </div>
                    <div class="col-sm-4">
                        <textarea id="desc" name="desc">
                            
                        </textarea>
                    </div>
                    <div class="col-sm-2">
                        <label>Tags</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tags" name="tags">
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <h4 class="fw-bolder">Depreciation</h4>
                <div class="row">
                    <div class="col-sm-2">
                        <label for="not_depre"> Non Depreciable</label>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" id="not_depre" name="not_depre" value="not_depre" checked="true">
                    </div>
                    <div class="col-sm-4" id="depre_msg" hidden>
                        <b class="text-danger">Please fill all the depreciation data below</b>
                    </div>
                </div>
                <fieldset id="depre_field" disabled>
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Method</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select form-select-lg" id="method" name="method">
                                <option value="straight_line">Straight Line</option>
                                <option value="reducing_balance">Reducing Balance</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Depreciation Account</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select form-select-lg" id="depre_account" name="depre_account">
                                @foreach($accounts as $account)
                                    <option value="{{ $account['name'] }}">{{ $account['number'] . " " . $account['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Useful Life</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="numeric" class="form-control" id="life" name="life">
                        </div>
                        <div class="col-sm-1">
                            Years
                        </div>
                        <div class="col-sm-2">
                            <label>Accumulated Depreciation Account</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select form-select-lg" id="accdep_account" name="accdep_account">
                                @foreach($accdep_accounts as $account)
                                    <option value="{{ $account['name'] }}">{{ $account['number'] . " " . $account['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Rate/Year</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="rate" name="rate">
                        </div>
                        <div class="col-sm-1">
                            %
                        </div>
                        <div class="col-sm-2">
                            <label>Accumulated Depreciation</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="acc_depre" name="acc_depre">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-2">
                            <label>As at Date</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="as_date" id="as_date">
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-group mt-5">
                <div class="row mt-2">
                    <div class="col-sm-8">
                    </div>
                    <div class="col-sm-2 ">
                        <button type="button" id="btn_cancel" class="btn btn-danger btn-lg">Cancel</button>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="btn_submit" class="btn btn-success btn-lg">Create Asset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--body wrapper end-->

    @section('script')
    <script>
        
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $("#not_depre").change(function() {
                if($("#not_depre").prop("checked")){
                    $("#depre_field").prop('disabled', true);
                    //
                    $("#account_credited").removeProp('required');
                    $("#method").removeProp('required');
                    $("#depre_account").removeProp('required');
                    $("#life").removeProp('required');
                    $("#rate").removeProp('required');
                    $("#acc_depre").removeProp('required');
                    $("#as_date").removeProp('required');

                    $("#depre_msg").hide();
                    
                }
                else{
                    $("#depre_field").removeProp('disabled');
                    //
                    $("#account_credited").prop('required', true);
                    $("#method").prop('required', true);
                    $("#depre_account").prop('required', true);
                    $("#life").prop('required', true);
                    $("#rate").prop('required', true);
                    $("#acc_depre").prop('required', true);
                    $("#as_date").prop('required', true);

                    $("#depre_msg").show();
                }
            });

            $("#btn_submit").click( function(){
                var url = "{{ url('/dashboard/finance/asset/record/') }}";

                var name = $("#name").val();
                var acquisition_date = $("#acquisition_date").val();
                var asset_number = $("#asset_number").val();
                var acquisition_cost = $("#acquisition_cost").val();
                var asset_account_name = $("#fixed_asset :selected").val();
                var credited_account_name = $("#account_credited :selected").val();
                var desc = $("#desc").val(); //opt
                var tags = $("#tags").val(); //opt
                var non_depreceable = $("#not_depre").prop("checked");

                var depreciation_method = $("#method :selected").val();
                var depreciation_account_name =$("#depre_account :selected").val();
                var useful_life = $("#life").val();
                var rate = $("#rate").val();
                var depreciation_and_amortization_account_name= $("#accdep_account").val(); //opt
                var initial_depreciation = $("#acc_depre").val();
                var initial_depreciation_asset_date = $("#as_date").val();

                if($("#not_depre").prop("checked")){
                    console.log("masok");

                    $.ajax({
                        type: "POST",
                        url: url,
                        contentType: 'application/json',
                        data: {
                           "name": name,
                           "asset_number": asset_number,
                           "description": desc,
                           "acquisition_date": acquisition_date,
                           "acquisition_cost": acquisition_cost,
                           "asset_account_name": asset_account_name,
                           "credited_account_name": credited_account_name,
                           "tags": [tags],
                           "non_depreceable": true

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
                else{
                    console.log("depreceable");
                    $.ajax({
                        type: "POST",
                        url: url,
                        contentType: 'application/json',
                        data: {
                           "name": name,
                           "asset_number": asset_number,
                           //"description": desc,
                           "acquisition_date": acquisition_date,
                           "acquisition_cost": acquisition_cost,
                           "asset_account_name": asset_account_name,
                           "credited_account_name": credited_account_name,
                           //"tags": [tags],
                           "non_depreceable": false,
                           "depreciation_method": depreciation_method,
                           "depreciation_account_name": depreciation_account_name,
                           "useful_life": useful_life,
                           "rate": rate,
                           "depreciation_and_amortization_account_name": depreciation_and_amortization_account_name,
                           "initial_depreciation": initial_depreciation,
                           "initial_depreciation_asset_date": initial_depreciation_asset_date

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

                console.log("cek =" + asset_account_name);
            });

            $("#btn_cancel").click( function(){
                var url = "{{ url('/dashboard/finance/asset/') }}";

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response)
                    {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                   }
                });

                //console.log("name asset =" + name);
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

</x-app-layout>