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
            Customer Summary
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Customer Summary </li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Customer Summary
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="row">
                                <div class="col-md-8" style="padding: 10px">
                                    <div class="col-md-4">
                                        <label class="control-label">Customer Area
                                            <select class="form-control" id="id_area" style="padding: 0px 10px;" name="id_area" >
                                                <option value="0">All Area</option>
                                                <?php foreach ($arealist as $areas):?>
                                                <option value="{{$areas->id}}">{{$areas->name}}</option>
                                                <?php endforeach?>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="control-label">Customer Status
                                            <select class="form-control" id="nice_level" style="padding: 0px 10px;" name="nice_level" >
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
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        
                                        <button type="submit" id="btn-search" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 10px">
                                    <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="customer_table">
                                <thead>
                                    <tr>
                                        <th class="sortable sorting">
                                            Company Name
                                        </th>
                                        <th class="sortable sorting">
                                            Sales Name
                                        </th>
                                        <th class="sortable sorting">
                                            Payment Due Date
                                        </th>
                                        <th class="sortable sorting">
                                            Latest Payment
                                        </th>
                                        <th class="sortable sorting">
                                            Selling This Month
                                        </th>
                                        <th class="sortable sorting">
                                            Total Debt
                                        </th>
                                        <th class="sortable sorting">
                                            Total Debt Passed Due Date
                                        </th>
                                        <th class="sortable sorting">
                                            Today's Bills
                                        </th>
                                        <th class="sortable sorting">
                                            Bills This Months
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="customertable"></tbody>
                            </table>



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
                $('#btn-search').click(function () {
                    getTables();
                })

            });
            function getTables() {
                var nice=$('#nice_level').val();
                var area=$('#id_area').val();
                var url="{{ url('/dashboard/customer/summary/list') }}";
                $.ajax({
                    type:"POST",
                    url: url,
                    data: { area: area, nice: nice },
                    dataType: 'json',
                    success: function(res){
                        $('#customertable').html(res.data);
                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            $('.sortable').click(function(){
                $('.sortable').removeClass('sorting_asc sorting_desc');
                $('.sortable').addClass('sorting');
                var table = $(this).parents('table').eq(0)
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
                this.asc = !this.asc
                if (!this.asc){
                    rows = rows.reverse();
                    $(this).removeClass('sorting_asc');
                    $(this).addClass('sorting_desc');
                }else{
                    $(this).removeClass('sorting_desc');
                    $(this).addClass('sorting_asc');
                }
                for (var i = 0; i < rows.length; i++){table.append(rows[i])}
            })
            function comparer(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index), valB = getCellValue(b, index)
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
                }
            }
            function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
            

            

        
            

        </script>
    @endsection
        <!--body wrapper end-->
</x-app-layout>
