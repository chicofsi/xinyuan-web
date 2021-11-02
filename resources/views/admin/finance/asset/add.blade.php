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

    <!--body wrapper start-->
    <div class="wrapper">

        <form id="formAsset">
            <div class="panel">
                <div class="panel-body invoice">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h2 class="invoice-title" id="title"> @if (isset($asset))
                                Edit
                                @else
                                Record
                            @endif New Asset</h2>
                        </div>
                    </div>
                    <div class="invoice-address">
                        <div class="panel">
                            <div class="panel-heading">
                                Asset Details
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <h4 class="inv-to" id="receiver">Asset Name</h4>
                                        <input class="form-control " style="color: black;" name="asset_name" id="asset_name" type="text" @if (isset($asset))value="{{$asset->name}}" @endif  />
                                        <h4 class="inv-to" id="receiver">Asset Number</h4>
                                        <input class="form-control " style="color: black;" name="asset_number" id="asset_number" type="text"  @if (isset($asset))value="{{$asset->asset_number}}" @endif />
                                        <h4 class="inv-to">Fixed Asset Account</h4>
                                        <select class="selectpicker  form-control" data-live-search="true" id="fixed_asset" style="color: black;" name="fixed_asset" >
                                             @foreach ($fixedaccounts->accounts  as $val)

                                                <option value="{{$val->name}}" 
                                                     @if (isset($asset))
                                                         @if ($asset->asset_account->id==$val->id)
                                                            selected
                                                         @endif
                                                     @endif
                                                    >{{"(".$val->number.") ".$val->name}}</option>
                                             @endforeach
                                        </select>
                                        <h4 class="inv-to" >Description</h4>
                                        <textarea rows="3" id="description" class="form-control"> @if (isset($asset)){{$asset->description}} @endif</textarea>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <h4 class="inv-to" id="receiver">Acquisition Date</h4>
                                        <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="acquisition_date" id="acquisition_date" type="text" value=@if (isset($asset))"{{$asset->acquisition_date}}" @else {{date('m/d/Y')}} @endif />
                                        <h4 class="inv-to" id="receiver">Acquisition Cost</h4>
                                        <input type="number" min="0" class="form-control desk" style="color: black;" id="cost" name="cost" value=@if (isset($asset))"{{$asset->acquisition_cost}}" @else 0 @endif>
                                        <h4 class="inv-to">Account Credited</h4>
                                        <select class="selectpicker  form-control" data-live-search="true" id="account_credited" style="color: black;" name="account_credited" >
                                             @foreach ($accounts->accounts  as $val)
                                                <option value="{{$val->id}}" 
                                                     @if (isset($asset))
                                                         @if ($asset->credited_account->id==$val->id)
                                                            selected
                                                         @endif
                                                     @endif
                                                    >{{"(".$val->number.") ".$val->name}}</option>
                                             @endforeach
                                        </select>
                                        <h4 class="inv-to" id="receiver">Tags</h4>
                                        <input class="form-control " style="color: black;" name="tags" id="tags" type="text"  />
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading">
                                Depreciation
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <h4 class="inv-to">Non-depreciable Asset</h4>
                                        <select class="selectpicker  form-control" data-live-search="true" id="depreciation" style="color: black;" name="depreciation" >
                                            <option value="0" 
                                                     @if (isset($asset))
                                                         @if ($asset->depreceable==false)
                                                            selected
                                                         @endif
                                                     @endif>Not Depreciable</option>
                                            <option value="1" 
                                                     @if (isset($asset))
                                                         @if ($asset->depreceable==true)
                                                            selected
                                                         @endif
                                                     @endif>Depreciable</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="depreciation_row" 
                                @if (isset($asset))
                                     @if ($asset->depreceable==true)
                                     style="display: block"
                                     @else
                                     style="display: none"

                                     @endif
                                @endif>
                                    <div class="col-md-6 col-sm-12">
                                        <h4 class="inv-to">Method</h4>
                                        <select class="selectpicker  form-control" data-live-search="true" id="method" style="color: black;" name="method" >
                                            <option value="straight_line"
                                                     @if (isset($asset))
                                                         @if ($asset->depreceable==true)
                                                             @if ($asset->depreciation_method=="Straight line")
                                                                selected
                                                             @endif
                                                         @endif
                                                     @endif>Straight line</option>
                                            <option value="reducing_balance"
                                                     @if (isset($asset))
                                                         @if ($asset->depreceable==true)
                                                             @if ($asset->depreciation_method=="Reducing balance")
                                                                selected
                                                             @endif
                                                         @endif
                                                     @endif>Reducing balance</option>
                                        </select>
                                        <h4 class="inv-to">Useful Life</h4>
                                        <div class="input-group m-bot15">
                                            <input type="number" name="years" id="years" class="form-control" value= @if (isset($asset)) @if ($asset->depreceable==true)"{{$asset->useful_life}}" @else 4 @endif @else 4 @endif >
                                            <span class="input-group-addon">Years</span>
                                        </div>
                                        <h4 class="inv-to">Rate/Year</h4>
                                        <div class="input-group m-bot15">
                                            <input type="number" name="rate" id="rate" class="form-control" value= @if (isset($asset)) @if ($asset->depreceable==true)"{{$asset->rate_value}}" @else 25 @endif @else 25 @endif>
                                            <span class="input-group-addon">Percent</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <h4 class="inv-to">Depreciation Account</h4>
                                        <select class="selectpicker  form-control" data-live-search="true" id="dep_account" style="color: black;" name="dep_account" >
                                             @foreach ($expenses->accounts  as $val)
                                                 @if ($val->is_parent==false)
                                                    <option value="{{$val->id}}"
                                                         @if (isset($asset))
                                                             @if ($asset->depreceable==true)
                                                                 @if ($asset->depreciation_account->id==$val->id)
                                                                    selected
                                                                 @endif
                                                             @endif
                                                         @endif
                                                    >{{"(".$val->number.") ".$val->name}}</option>
                                                 @endif
                                                
                                             @endforeach
                                             @foreach ($otherexpenses->accounts  as $val)
                                                 @if ($val->is_parent==false)
                                                    <option value="{{$val->id}}"
                                                         @if (isset($asset))
                                                             @if ($asset->depreceable==true)
                                                                 @if ($asset->depreciation_account->id==$val->id)
                                                                    selected
                                                                 @endif
                                                             @endif
                                                         @endif
                                                    >{{"(".$val->number.") ".$val->name}}</option>
                                                 @endif
                                             @endforeach
                                             @foreach ($costofsales->accounts  as $val)
                                                 @if ($val->is_parent==false)
                                                    <option value="{{$val->id}}"
                                                         @if (isset($asset))
                                                             @if ($asset->depreceable==true)
                                                                 @if ($asset->depreciation_account->id==$val->id)
                                                                    selected
                                                                 @endif
                                                             @endif
                                                         @endif
                                                    >{{"(".$val->number.") ".$val->name}}</option>
                                                 @endif
                                             @endforeach
                                        </select>
                                        <h4 class="inv-to">Accumulated Depreciation Account</h4>
                                        <select class="selectpicker  form-control" data-live-search="true" id="acc_dep_account" style="color: black;" name="acc_dep_account" >
                                             @foreach ($accdep_accounts->accounts  as $val)
                                                <option value="{{$val->id}}"
                                                     @if (isset($asset))
                                                             @if ($asset->depreceable==true)
                                                                 @if ($asset->depreciation_and_amortization_account->id==$val->id)
                                                                    selected
                                                                 @endif
                                                             @endif
                                                         @endif
                                                    >{{"(".$val->number.") ".$val->name}}</option>
                                             @endforeach
                                        </select>
                                        <h4 class="inv-to" id="receiver">Accumulated Depreciation</h4>
                                        <input type="number" min="0" class="form-control desk" style="color: black;" id="acc_dep" name="acc_dep" value= @if (isset($asset)) @if ($asset->depreceable==true)"{{$asset->accumulated_depreciation}}" @else 0 @endif @else 0 @endif>
                                        <h4 class="inv-to" id="receiver">As at Date</h4>
                                        <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="as_at_date" id="as_at_date" type="text" value=@if (isset($asset))  @if ($asset->depreceable==true)"{{$asset->last_applied_depreciation_date}}"  @else{{date('m/d/Y')}}  @endif  @else{{date('m/d/Y')}}  @endif />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right " style="padding-right: 50px">
                                            
                <button type="submit"  type='button' class='btn btn-success'>
                    Create 
                </button>
            </div>
        </form>
    </div>
    @section('script')
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
                $('body').append('<div class="loading"></div>');
                $('.loading').css("display",'none');
                checkDepreciation();
                $('#depreciation').change(function() {
                    checkDepreciation();
                })
            });

            function checkDepreciation() {
                if($('#depreciation').val()==0){
                    $('#depreciation_row').css('display','none');
                }else{
                    $('#depreciation_row').css('display','block');

                }
            }

            Date.prototype.addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }

            $('#formAsset').submit(function(e) {
                e.preventDefault();
                $('.loading').css("display",'block');

                var form=new FormData();

                form.append('asset_name', $('#asset_name').val());
                form.append('asset_number', $('#asset_number').val());
                form.append('fixed_asset', $('#fixed_asset').val());
                form.append('description', $('#description').val());
                form.append('acquisition_date', $('#acquisition_date').val());
                form.append('cost', $('#cost').val());
                form.append('account_credited', $('#account_credited').val());
                form.append('tags', $('#tags').val());
                    
                if($('#depreciation').val()==0){
                    form.append('depreciation',false);
                }else{
                    form.append('depreciation',true);
                }
                form.append('method', $('#method').val());
                form.append('years', $('#years').val());
                form.append('rate', $('#rate').val());
                form.append('dep_account', $('#dep_account').val());
                form.append('acc_dep_account', $('#acc_dep_account').val());
                form.append('acc_dep', $('#acc_dep').val());
                form.append('as_at_date', $('#as_at_date').val());
                @if (isset($asset))
                    form.append('id', {{$asset->id}});
                    var url="{{ url('/dashboard/asset/edit/')}}";
                @else
                    var url="{{ url('/dashboard/asset/record/')}}";
                @endif
                $.ajax({
                    type:'POST',
                    url: url,
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        console.log(data);
                        window.location.href = "{{ url('dashboard/finance/asset') }}";
                        $('.loading').css("display",'none');

                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            })

            function addData() {
                $('#expense_table').append('<tr><td><select class="desk form-control expenselist" id="expense" style="color: black;" name="expense" ></select></td><td><textarea rows="1" id="description" class="form-control"></textarea></td><td><select class="desk form-control" id="tax" style="color: black;" name="tax" ></select></td><td><input type="number" class="form-control" id="amount" name="amount" min="0"></td><td><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="detail" class="btn btn-danger btn-delete btn-sm"><i class="fas fa-trash"></i></a></td></tr>');
                $(".btn-delete").click(function() {
                    var elm=this;
                    var a=$(elm).parent().parent().remove();
                });
                $("select, input[type='number']").change(function () {
                    checkTotal();
                });

                elm=$('#expense_table tr:last-child #expense');

                $(elm).parent().parent().find('#expense').html('');
                $('.loading').css("display",'block');

                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/finance/account/expense/') }}",
                    success: function(res){

                        $.each(res.cost.accounts,function (i,v) {
                            $(elm).parent().parent().find('#expense').append('<option value="'+v.name+'">('+v.number+') '+v.name+'</option>');
                            
                        })

                        $.each(res.expense.accounts,function (i,v) {
                            $(elm).parent().parent().find('#expense').append('<option value="'+v.name+'">('+v.number+') '+v.name+'</option>');
                            
                        })
                        $.each(res.other.accounts,function (i,v) {
                            $(elm).parent().parent().find('#expense').append('<option value='+v.name+'">('+v.number+') '+v.name+'</option>');
                            
                        })
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                $(elm).parent().parent().find('#tax').html('<option rate="0.0" value=0>no Tax</option>');
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/finance/taxes/list/') }}",
                    success: function(res){
                        $.each(res.company_taxes,function(i,v) {
                            $(elm).parent().parent().find('#tax').append('<option rate='+v.rate+' value='+v.id+'>'+v.name+'</option>');
                        });                        
                        $('.loading').css("display",'none');

                    },
                    error: function(data){
                        console.log(data);
                    }
                });

            }
            
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split           = number_string.split(','),
                sisa            = split[0].length % 3,
                rupiah          = split[0].substr(0, sisa),
                ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
     
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
     
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '') +",00";
            }

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




