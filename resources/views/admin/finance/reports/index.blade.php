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
    <link rel="stylesheet" type="text/css" href="{{asset('js/jquery-multi-select/css/multi-select.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datepicker/css/datepicker-custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-timepicker/css/timepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-colorpicker/css/colorpicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datetimepicker/css/datetimepicker-custom.css')}}" />
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
                                                <button href="#BalanceSheetModal" onclick="getBalanceSheet()" data-toggle="modal"  class="btn btn-primary" type="button">View Report</button>
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
                                                <button href="#ProfitAndLossModal" onclick="getProfitAndLoss()" data-toggle="modal"  class="btn btn-primary" type="button">View Report</button>
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


                        <div aria-hidden="true" role="dialog"  id="ProfitAndLossModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="ProfitAndLossTitle">Profit & Loss</h4>
                                    </div>
                                    <div class="modal-body"  style="background-color: #eff0f4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        Date Range
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="control-label">
                                                                        <div class="col-md-12 input-group input-large custom-date-range"  data-date-format="mm/dd/yyyy">
                                                                            <input id="from" type="text" class="form-control dpd1" name="from"  value="{{date('m/d/Y',strtotime("-7 days"))}}">
                                                                            <span class="input-group-addon">To</span>
                                                                            <input id="to" type="text" class="form-control dpd2" name="to" value="{{date('m/d/Y')}}">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="submit" onclick="getProfitAndLoss()" id="btn-search" class="btn btn-info">Search</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            
                                                            <div class="panel-heading">
                                                                <div class="panel-title">Profit & Loss</div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                         <table  class="display table table-hover" id="product_table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="2"></th>
                                                                                    <th style="text-align: right;">
                                                                                        {{date('m/d/Y',strtotime("-7 days"))." - ".date('m/d/Y')}}
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="profit_and_loss_table"></tbody>
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
                        </div>

                        <div aria-hidden="true" role="dialog"  id="BalanceSheetModal" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="BalanceSheetTitle">Balance Sheet</h4>
                                    </div>
                                    <div class="modal-body"  style="background-color: #eff0f4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        As Of
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="control-label">
                                                                        <input data-date-format="mm/dd/yyyy" class="form-control desk default-date-picker" style="color: black;" name="date" id="balance_sheet_date" size="16" type="text" value="{{date('m/d/Y')}}" />
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="submit" onclick="getBalanceSheet()" id="btn-search" class="btn btn-info">Search</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel">
                                                            
                                                            <div class="panel-heading">
                                                                <div class="panel-title">Balance Sheet</div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                         <table  class="display table table-hover" id="product_table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="2"></th>
                                                                                    <th style="text-align: right;">
                                                                                        {{date('m/d/Y')}}
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="balance_sheet_table"></tbody>
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
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @section('script')

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
            function getProfitAndLoss() {
                var from=$('#from').val();
                var to=$('#to').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/finance/reports/profit_and_loss') }}",
                    data: { start_date: from, end_date: to},
                    dataType: 'json',
                    success: function(res){
                        $('#profit_and_loss_table').html("");
                        $('#profit_and_loss_table').append("<tr><th colspan='3'>Primary Income</th></tr>");

                        $.each(res.profit_and_loss.primary_income.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:30px !important'><strong>"+value.number+"</strong></td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#profit_and_loss_table').append($row);
                        });
                        $primary_income = "<tr><td style='padding-left:30px !important' colspan='2'>Total Primary Income</td>";
                        $.each(res.profit_and_loss.primary_income.total, function(k,val) {
                            $primary_income+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $primary_income += "</tr>";

                        $('#profit_and_loss_table').append($primary_income);


                        $('#profit_and_loss_table').append("<tr><th colspan='3'>Cost of Sales</th></tr>");

                        $.each(res.profit_and_loss.cost_of_good_sold.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:30px !important'><strong>"+value.number+"</strong></td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#profit_and_loss_table').append($row);
                        });
                        $cost_of_good_sold = "<tr><td style='padding-left:30px !important' colspan='2'>Total Cost of Sales</td>";
                        $.each(res.profit_and_loss.cost_of_good_sold.total, function(k,val) {
                            $cost_of_good_sold+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $cost_of_good_sold += "</tr>";

                        $cost_of_good_sold += "<tr><td colspan='2'>Gross Profits</td>";
                        $.each(res.profit_and_loss.cost_of_good_sold.gross_profit, function(k,val) {
                            $cost_of_good_sold+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $cost_of_good_sold += "</tr>";

                        $('#profit_and_loss_table').append($cost_of_good_sold);
                        $('#profit_and_loss_table').append("<tr><td colspan='3'></td></tr>");

                        
                        $('#profit_and_loss_table').append("<tr><th colspan='3'>Operational Expense</th></tr>");

                        $.each(res.profit_and_loss.expense.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:30px !important'><strong>"+value.number+"</strong></td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#profit_and_loss_table').append($row);
                        });
                        $expense = "<tr><td style='padding-left:30px !important' colspan='2'>Total Operational Expenses</td>";
                        $.each(res.profit_and_loss.expense.total, function(k,val) {
                            $expense+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $expense += "</tr>";

                        $('#profit_and_loss_table').append($expense);

                        $net_operating_income = "<tr><td colspan='2'>Net Operating Income</td>";
                        $.each(res.profit_and_loss.header.net_operating_income, function(k,val) {
                            $net_operating_income+="<td style='text-align: right;'>"+val.income+"</td>";
                        });
                        $net_operating_income += "</tr>";

                        $('#profit_and_loss_table').append($net_operating_income);

                        $('#profit_and_loss_table').append("<tr><td colspan='3'></td></tr>");

                        $('#profit_and_loss_table').append("<tr><th colspan='3'>Other Income</th></tr>");

                        $.each(res.profit_and_loss.other_income.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:30px !important'><strong>"+value.number+"</strong></td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#profit_and_loss_table').append($row);
                        });
                        $other_income = "<tr><td style='padding-left:30px !important' colspan='2'>Total Other Income</td>";
                        $.each(res.profit_and_loss.other_income.total, function(k,val) {
                            $other_income+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $other_income += "</tr>";

                        $('#profit_and_loss_table').append($other_income);


                        $('#profit_and_loss_table').append("<tr><th colspan='3'>Other Expense</th></tr>");

                        $.each(res.profit_and_loss.other_expense.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:30px !important'><strong>"+value.number+"</strong></td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#profit_and_loss_table').append($row);
                        });
                        $other_expense = "<tr><td style='padding-left:30px !important' colspan='2'>Total Other Expenses</td>";
                        $.each(res.profit_and_loss.other_expense.total, function(k,val) {
                            $other_expense+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $other_expense += "</tr>";

                        $('#profit_and_loss_table').append($other_expense);

                        $net_income = "<tr><td colspan='2'>Net Income</td>";
                        $.each(res.profit_and_loss.header.net_income, function(k,val) {
                            $net_income+="<td style='text-align: right;'>"+val.income+"</td>";
                        });
                        $net_income += "</tr>";

                        $('#profit_and_loss_table').append($net_income);

                        $('#profit_and_loss_table').append("<tr><td colspan='3'></td></tr>");


                        $('#profit_and_loss_table').append("<tr><th colspan='3'>Other Comprehensive Income/Loss</th></tr>");

                        $.each(res.profit_and_loss.other_comprehensive_income_loss.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:30px !important'><strong>"+value.number+"</strong></td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#profit_and_loss_table').append($row);
                        });
                        $other_comprehensive_income_loss = "<tr><td style='padding-left:30px !important' colspan='2'>Total Other Comprehensive Income/Loss</td>";
                        $.each(res.profit_and_loss.other_comprehensive_income_loss.total, function(k,val) {
                            $other_comprehensive_income_loss+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $other_comprehensive_income_loss += "</tr>";

                        $('#profit_and_loss_table').append($other_comprehensive_income_loss);

                        $total_comprehensive_income = "<tr><td colspan='2'>Total Comprehensive Income for the period</td>";
                        $.each(res.profit_and_loss.header.total_comprehensive_income, function(k,val) {
                            $total_comprehensive_income+="<td style='text-align: right;'>"+val.income+"</td>";
                        });
                        $total_comprehensive_income += "</tr>";

                        $('#profit_and_loss_table').append($total_comprehensive_income);
                        
                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function getBalanceSheet() {
                var date=$('#balance_sheet_date').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/finance/reports/balance_sheet') }}",
                    data: { end_date: date},
                    dataType: 'json',
                    success: function(res){
                        $('#balance_sheet_table').html("");
                        $('#balance_sheet_table').append("<tr><th colspan='3'>Assets</th></tr>");

                        $('#balance_sheet_table').append("<tr><th style='padding-left:30px !important' colspan='3'>Current Assets</th></tr>");

                        $.each(res.balance_sheet.current_assets.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:"+(value.indent+2)*30+"px !important'>"+value.number+"</td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#balance_sheet_table').append($row);
                        });
                        $current_assets = "<tr><th style='padding-left:30px !important' colspan='2'>Total Current Assets</th>";
                        $.each(res.balance_sheet.current_assets.total, function(k,val) {
                            $current_assets+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $current_assets += "</tr>";

                        $('#balance_sheet_table').append($current_assets);


                        $('#balance_sheet_table').append("<tr><th style='padding-left:30px !important' colspan='3'>Fixed Assets</th></tr>");

                        $.each(res.balance_sheet.fixed_assets.accounts.array,function (key, value) {
                            $row="<tr>";

                            $row+="<td style='padding-left:"+(value.indent+2)*30+"px !important'>"+value.number+"</td>";
                            
                            $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                            $.each(value.data, function(k,val) {
                                $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                            });
                            $row+="</tr>";

                            $('#balance_sheet_table').append($row);
                        });
                        $fixed_assets = "<tr><th style='padding-left:30px !important' colspan='2'>Total Fixed Assets</th>";
                        $.each(res.balance_sheet.fixed_assets.total, function(k,val) {
                            $fixed_assets+="<td style='text-align: right;'>"+val.total+"</td>";
                        });
                        $fixed_assets += "</tr>";

                        $('#balance_sheet_table').append($fixed_assets);

                        if(res.balance_sheet.fixed_assets.accounts.length > 0){


                            $('#balance_sheet_table').append("<tr><th style='padding-left:30px !important' colspan='3'>Fixed Assets</th></tr>");

                            $.each(res.balance_sheet.fixed_assets.accounts.array,function (key, value) {
                                $row="<tr>";

                                $row+="<td style='padding-left:"+(value.indent+2)*30+"px !important'>"+value.number+"</td>";
                                
                                $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                                $.each(value.data, function(k,val) {
                                    $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                                });
                                $row+="</tr>";

                                $('#balance_sheet_table').append($row);
                            });
                            $fixed_assets = "<tr><th style='padding-left:30px !important' colspan='2'>Total Fixed Assets</th>";
                            $.each(res.balance_sheet.fixed_assets.total, function(k,val) {
                                $fixed_assets+="<td style='text-align: right;'>"+val.total+"</td>";
                            });
                            $fixed_assets += "</tr>";

                            $('#balance_sheet_table').append($fixed_assets);
                        }

                        if(res.balance_sheet.other_assets.accounts.length > 0){

                            $('#balance_sheet_table').append("<tr><th style='padding-left:30px !important' colspan='3'>Other Assets</th></tr>");

                            $.each(res.balance_sheet.other_assets.accounts.array,function (key, value) {
                                $row="<tr>";

                                $row+="<td style='padding-left:"+(value.indent+2)*30+"px !important'>"+value.number+"</td>";
                                
                                $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                                $.each(value.data, function(k,val) {
                                    $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                                });
                                $row+="</tr>";

                                $('#balance_sheet_table').append($row);
                            });
                            $fixed_assets = "<tr><th style='padding-left:30px !important' colspan='2'>Total Other Assets</th>";
                            $.each(res.balance_sheet.other_assets.total, function(k,val) {
                                $fixed_assets+="<td style='text-align: right;'>"+val.total+"</td>";
                            });
                            $fixed_assets += "</tr>";

                            $('#balance_sheet_table').append($fixed_assets);

                        }

                        if(res.balance_sheet.depreciations.accounts.length > 0){

                            $('#balance_sheet_table').append("<tr><th style='padding-left:30px !important' colspan='3'>Depreciation</th></tr>");

                            $.each(res.balance_sheet.depreciations.accounts.array,function (key, value) {
                                $row="<tr>";

                                $row+="<td style='padding-left:"+(value.indent+2)*30+"px !important'>"+value.number+"</td>";
                                
                                $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>";

                                $.each(value.data, function(k,val) {
                                    $row+="<td  style='text-align: right;'>"+val.balance+"</td>";
                                });
                                $row+="</tr>";

                                $('#balance_sheet_table').append($row);
                            });
                            $fixed_assets = "<tr><th style='padding-left:30px !important' colspan='2'>Total Depreciation</th>";
                            $.each(res.balance_sheet.depreciations.total, function(k,val) {
                                $fixed_assets+="<td style='text-align: right;'>"+val.total+"</td>";
                            });
                            $fixed_assets += "</tr>";

                            $('#balance_sheet_table').append($fixed_assets);

                        }

                        $total_assets = "<tr><th colspan='2'>Total Assets</th>";
                        $.each(res.balance_sheet.header.total_assets, function(k,val) {
                            $total_assets+="<td style='text-align: right;'>"+val.income+"</td>";
                        });
                        $total_assets += "</tr>";

                        $('#balance_sheet_table').append($total_assets);

                        


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



