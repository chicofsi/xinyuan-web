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
        @if ($errors->any())
            <div class="alert alert-block alert-danger fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <strong>Oh snap!</strong> {{$errors->first()}}
            </div>
        @endif
        <form method="post" action="{{ url('dashboard/finance/banktransfer') }}">
            @csrf <!-- {{ csrf_field() }} -->
            <div class="panel">
                
                <div class="panel-body invoice">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h2 class="invoice-title" id="title">Create Bank Transfer</h2>
                        </div>
                        {{-- <div class="col-md-4 col-sm-4" style="padding-top: 15px">
                            <h1 class="t-due">Total Amount </h1>
                            <h2 class="amnt-value" id="Total_amount"></h2>
                        </div> --}}
                    </div>
                    <div class="invoice-address">
                        <div class="row" style="background-color: #424F63; padding-top: 20px;padding-bottom: 20px">
                            <div class="col-md-3 col-sm-4">
                                <h4 class="inv-to" style="color: #ffffff">Transfer From</h4>
                                <h2 class="corporate-id" >
                                    <select class="selectpicker  form-control" data-live-search="true" id="from" style="color: black;" name="from" >
                                        @foreach ($cash->accounts  as $val)
                                            <option value="{{$val->id}}" @if (isset($_GET['from']))
                                                @if ($_GET['from']==$val->id)
                                                    selected 
                                                @endif
                                            @endif>{{$val->number." ".$val->name}}</option>
                                        @endforeach
                                        @foreach ($credit->accounts  as $val)
                                            <option value="{{$val->id}}" @if (isset($_GET['from']))
                                                @if ($_GET['from']==$val->id)
                                                    selected 
                                                @endif
                                            @endif>{{$val->number." ".$val->name}}</option>
                                        @endforeach
                                    </select>
                                </h2>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <h4 class="inv-to" style="color: #ffffff">Deposit To</h4>
                                <h2 class="corporate-id" >
                                    <select class="selectpicker  form-control" data-live-search="true" id="to" style="color: black;" name="to" >
                                        @foreach ($cash->accounts  as $val)
                                            <option value="{{$val->id}}"@if (isset($_GET['to']))
                                                @if ($_GET['to']==$val->id)
                                                    selected 
                                                @endif
                                            @endif>{{$val->number." ".$val->name}}</option>
                                        @endforeach
                                        @foreach ($credit->accounts  as $val)
                                            <option value="{{$val->id}}"@if (isset($_GET['to']))
                                                @if ($_GET['to']==$val->id)
                                                    selected 
                                                @endif
                                            @endif>{{$val->number." ".$val->name}}</option>
                                        @endforeach
                                    </select>
                                </h2>
                            </div>

                            <div class="col-md-3 col-sm-4">
                                <h4 class="inv-to" style="color: #ffffff">Amount </h4>
                                <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter Transfer Amount" min="0">
                            </div>
                        </div>
                        <div class="row" style="padding-top: 20px">
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to"  style="color: black">Memo</h4>
                                <textarea rows="3" id="memo" name="memo" class="form-control"></textarea>
                                
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to"  style="color: black">Tags</h4>
                                <input type="text" name="tags" class="form-control" id="tags" >
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to"  style="color: black">Transaction No </h4>
                                <input type="text" class="form-control" id="transaction_no" placeholder="[Auto]">
                                <h4 class="inv-to"  style="color: black">Transaction Date</h4>
                                <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="transaction_date" id="transaction_date" type="text" value="{{date('m/d/Y')}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right " style="padding-right: 50px">
                                            
                <button type="submit"  type='button' class='btn btn-success'>
                    Create Transfer
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

            });
            Date.prototype.addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }
            $('#transaction_date').datepicker({ dateFormat: 'mm/dd/yyyy' });

            
            
            

            

            
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

            $('#AddAccountForm').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/finance/account')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#AddAccountModal").modal('hide');
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




