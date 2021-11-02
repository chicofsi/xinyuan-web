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
            Reports 
        </h3>
        <div class="state-info">
            
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
                            <li class="active">
                                <a href="#overview" data-toggle="tab">Business Overview</a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="overview">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Balance Sheet</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    Lists what you own (assets), what your debts are (liabilities), and what you've invested in your company (equity).
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>{{-- 
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Cash Flow</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    This report measures the cash generated or used by a company and shows how it has moved in a given period.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Statement of Change in Equity</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    Lists changes or movement in owner's equity occurred during a specific period.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Profit Loss Budgeting</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    This allows the company to compare actual financial againts budget.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Profit & Loss</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    Lists the individual transactions and totals for money you earned (income) and money you spent (expenses).
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>{{-- 
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">General Ledger</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    This report lists all the transactions that occurred within a period of time. The report is useful if you need a straight chronological listing of all the transactions your company made.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Journal</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    lists all journal entry per transaction that occurred within a period of time. It is useful to track where your transaction goes into each account
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Trial Balance</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    Display balance of each accounts, including opening balance, movement, and ending balance for selected period.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Executive Summary</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    A summary of financial statement and its insight.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div>
                                        <div class="panel ">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Budget Management</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    Tools for manage budgeting company income and expense.
                                                </p>
                                                <button class="btn btn-primary" type="button">View Report</button>
                                            </div>
                                        </div> --}}
                                    </div>
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

            });
            
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



