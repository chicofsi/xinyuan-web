<x-app-layout>
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Dashboard
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li class="active"> My Dashboard </li>
        </ul>
       {{--  <div class="state-info">
            <section class="panel">
                <div class="panel-body">
                    <div class="summary">
                        <span>yearly expense</span>
                        <h3 class="red-txt">$ 45,600</h3>
                    </div>
                    <div id="income" class="chart-bar"></div>
                </div>
            </section>
            <section class="panel">
                <div class="panel-body">
                    <div class="summary">
                        <span>yearly  income</span>
                        <h3 class="green-txt">$ 45,600</h3>
                    </div>
                    <div id="expense" class="chart-bar"></div>
                </div>
            </section>
        </div> --}}
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-md-6">
                <!--statistics start-->
                <div class="row state-overview">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel purple">
                            <div class="symbol">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">{{$datacount['transactionmonthly']}}</div>
                                <div class="title">Monthly Transaction</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel red">
                            <div class="symbol">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">{{$datacount['customermonthly']}}</div>
                                <div class="title">New Customer </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row state-overview">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel blue">
                            <div class="symbol">
                                <i class="fas fa-money"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">{{$datacount['incomemonthly']}}</div>
                                <div class="title"> Total Income This Month </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel green">
                            <div class="symbol">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">{{$datacount['accountsreceivablemonthly']}}</div>
                                <div class="title"> Total Receivable This Month</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row state-overview">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel red">
                            <div class="symbol">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">{{$datacount['salescount']}}</div>
                                <div class="title"> Total Sales</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel purple">
                            <div class="symbol">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">{{$datacount['accountsreceivable']}}</div>
                                <div class="title"> Total Receivable </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--statistics end-->
            </div>
            <div class="col-md-6">
                <!--more statistics box start-->
                <div class="panel">
                    <header class="panel-heading">
                        Selling Chart 
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div id="selling-chart">
                                <div id="selling-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--more statistics box end-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    <header class="panel-heading">
                        Factory Data
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        <select class="pull-right" id="nice_level"  style="margin-right:20px">
                            <option value="2">
                                All Customer
                            </option>
                            <option value="1">
                                Nice Customer
                            </option>
                            <option value="0">
                                Bad Customer
                            </option>
                        </select>
                    </header>
                    <div class="panel-body">
                        <table  class="display table table-striped table-bordered" id="sales_table">
                            <thead>
                                <tr style="background: #6a8abe;color: #ffffff">
                                    <th>Area</th>
                                    <th>Factory</th>
                                    <th>Total Receivable</th>
                                    <th>Matured Funds</th>
                                    <th>Today's Bills</th>
                                    <th>Today's Selling</th>
                                    <th>Total Bills</th>
                                    <th>Total Selling</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="factorytable"></tbody>
                                
                            <tfoot>
                                <tr style="background: #6a8abe;color: #ffffff">
                                    <th colspan="2" class="text-center">Total</th>
                                    <th class="text-right" id="receivableall"></th>
                                    <th class="text-right" id="maturedall"></th>
                                    <th class="text-right" id="todaybillall"></th>
                                    <th class="text-right" id="todaysellingall"></th>
                                    <th class="text-right" id="billall"></th>
                                    <th class="text-right" id="sellall"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <header class="panel-heading">
                        goal progress
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <ul class="goal-progress">
                            
                        </ul>
                        @if(Auth::guard('web')->check())
                        <div class="text-center"><a href="{{ url('dashboard/sales/target') }}">View all Goals</a></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body extra-pad">
                        <h4 class="pros-title">prospective <span>leads</span></h4>
                        <div class="row">
                            <div class="col-sm-4 col-xs-4">
                                <div id="p-lead-1"></div>
                                <p class="p-chart-title">Laptop</p>
                            </div>
                            <div class="col-sm-4 col-xs-4">
                                <div id="p-lead-2"></div>
                                <p class="p-chart-title">iPhone</p>
                            </div>
                            <div class="col-sm-4 col-xs-4">
                                <div id="p-lead-3"></div>
                                <p class="p-chart-title">iPad</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body extra-pad">
                        <div class="col-sm-6 col-xs-6">
                            <div class="v-title">Visits</div>
                            <div class="v-value">10,090</div>
                            <div id="visit-1"></div>
                            <div class="v-info">Pages/Visit</div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="v-title">Unique Visitors</div>
                            <div class="v-value">8,173</div>
                            <div id="visit-2"></div>
                            <div class="v-info">Avg. Visit Duration</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="panel green-box">
                    <div class="panel-body extra-pad">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <div class="knob">
                                    <span class="chart" data-percent="79">
                                        <span class="percent">79% <span class="sm">New Visit</span></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="knob">
                                    <span class="chart" data-percent="56">
                                        <span class="percent">56% <span class="sm">Bounce rate</span></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body">
                        <div class="calendar-block ">
                            <div class="cal1">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <header class="panel-heading">
                        Todo List
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <ul class="to-do-list" id="sortable-todo">
                            

                        </ul>

                        @if(Auth::guard('web')->check())
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" id="ToDoForm" name="ToDoForm">
                                    <div class="form-group todo-entry">
                                        <input type="text" placeholder="Enter To Do List" class="form-control" name="message" style="width: 100%">
                                    </div>
                                    <button class="btn btn-primary pull-right" type="submit">+</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="panel blue-box twt-info" style="height:190px">
                    <div class="panel-body">

                        @if(Auth::guard('web')->check())
                        <span class="tools pull-right">
                            <a class="fas fa-edit" onclick="announcement()" ></a>
                         </span>
                         @endif
                        <br></br>
                        <h3>{{date("F j, Y")}}</h3>
                        <p id="announcementMessage">{{$announcement->message}}</p>
                    </div>
                </div> 
                <div class="panel">
                    <div class="panel-body" style="height:180px">
                        <div class="media usr-info">
                        <br></br>
                            <a href="#" class="pull-left">
                                <img class="thumb" src="{{asset('img/logo_icon.png')}}" alt=""/>
                            </a>
                            <div class="media-body" style="height:180px">
                                <h4 class="media-heading">DIAMONDS</h4>
                                <br>回忆过去的一年，继续发力未来，不负韶华!</br>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="panel-footer custom-trq-footer">
                        <ul class="user-states">
                            <li>
                                <i class="fa fa-heart"></i> 127
                            </li>
                            <li>
                                <i class="fa fa-eye"></i> 853
                            </li>
                            <li>
                                <i class="fa fa-user"></i> 311
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
        @if(Auth::guard('web')->check())
        <div aria-hidden="true" role="dialog"  id="AnnouncementModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title"  id="AnnouncementModalTitle">Form Title</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="AnnouncementForm" name="AnnouncementForm">
                            <input type="hidden" value="1" name="id" id="id">
                            <div class="form-group">
                                <label for="name">Announcement Message</label>
                                <input type="text" class="form-control" id="message" name="message" placeholder="Enter Announcement Message">
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @section('script')
        <script type="text/javascript">
            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                getTables();
                getToDo();
                
                
            });
            $(document).on('click', '.remove-todo', function (e) {
                e.preventDefault();
                var elem=this;
                var id=$(this).parents('.todo-actionlist').parents('li').children('.todo-check').children('#id_todo').val();
                console.log(id);
                if (confirm("Delete To Do?") == true) {
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/admin/todo/delete') }}",
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
            $('#nice_level').change(function() {
                getTables();
            });


            $('#ToDoForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("id_sales", $('#idSales').val());

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/admin/todo/store')}}",
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

            function getToDo() {
                @if(Auth::guard('web')->check())
                    var url="{{ url('/dashboard/admin/todo/list') }}";
                @else
                    var url="{{ url('/dashboard/sales/todo/list') }}";
                @endif
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        $('#sortable-todo').html(res);
                        $('.todo-check label').click(function () {

                            var id=$(this).parents('li').children('.todo-check').children('#id_todo').val();
                            toggleToDo(id);
                        });
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            function toggleToDo(id) {
                @if(Auth::guard('web')->check())
                    var url="{{ url('/dashboard/admin/todo/toggle') }}";
                @else
                    var url="{{ url('/dashboard/sales/todo/toggle') }}";
                @endif
                var id = id;
                console.log(id);

                $.ajax({
                    type:'POST',
                    url: url,
                    data: { id: id },
                    success: (data) => {
                        getToDo();
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            }

            function announcement(){
                var id=$('#id').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/announcement/show') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#AnnouncementForm').trigger("reset");
                        $('#AnnouncementModalTitle').html("Edit Announcement");
                        $('#AnnouncementModal').modal('show');
                        $('#id').val(res.id);
                        $('#message').val(res.message);                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }; 
            $('#AnnouncementForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/announcement/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#AnnouncementModal").modal('hide');
                        $("#announcementMessage").html(data.message);
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
            function getTables() {

                var nice=$('#nice_level').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/data') }}",
                    data: { nice: nice },
                    dataType: 'json',
                    success: function(res){
                        $('.goal-progress').html(res.goal);
                        $('#factorytable').html(res.table);
                        $('#receivableall').html(res.receivableall);
                        $('#maturedall').html(res.maturedall);
                        $('#todaybillall').html(res.todaybillall);
                        $('#todaysellingall').html(res.todaysellingall);
                        $('#billall').html(res.billall);
                        $('#sellall').html(res.sellall);

                        var selling=[];
                        $.each(res.chart, function(){     
                            selling.push([gd(this.year,this.month),this.selling]);
                        });
                        sellingChart(selling);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });

            }
            function gd(year, month) {
                return new Date(year, month - 1).getTime();
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
        </script>
        <script src="{{asset('js/flot-chart/jquery.flot.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.tooltip.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.pie.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.selection.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.time.js')}}"></script>
        <script src="{{asset('js/morris-chart/morris.js')}}"></script>
        <script src="{{asset('js/morris-chart/raphael-min.js')}}"></script>

    @endsection
    <!--body wrapper end-->
</x-app-layout>
