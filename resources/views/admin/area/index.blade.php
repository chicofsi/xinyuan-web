
<x-app-layout>
    @section('style')
    <style type="text/css">
        .img-row{
            max-height: 50px; 
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-fileupload.min.css')}}" />
    @endsection
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Manage Area
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Area</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Area
                        <span class="pull-right">
                            <a href="#AreaModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Area <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table  class="display table  table-striped" id="area_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Area Name</th>
                                        <th>Sales Count</th>
                                        <th>Customer Count</th>
                                        <th class="no-sort">Edit</th>

                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    <?php foreach ($menu_list as $menu):?>
                                    @csrf
                                    <tr>
                                        <td>{{$menu->id}}</td>
                                        <td><strong>{{$menu->menu_name}}</strong></td>
                                        <td>{{$menu->route}}</td>
                                        <td> @if($menu->active == '1')
                                                <span class="label label-success">Active</span>
                                             @else
                                                <span class="label label-warning">Unactive</span>
                                            @endif
                                        </td>
                                        <td> @if($menu->admin_access == '1')
                                                <span class="label label-success">Accessable</span>
                                             @else
                                                <span class="label label-warning">Unactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            
                                            <a href="#myModal" data-toggle="modal">
                                                <button type="button" class="btn btn-success" data-action="expand-all">Edit</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach?>
                                  --}}   
                                    
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Area Name</th>
                                        <th>Sales Count</th>
                                        <th>Customer Count</th>
                                        <th >Edit</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="AreaModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="AreaModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" id="AreaForm" name="AreaForm">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="name">Area Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Area Name">
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
                                        </form>
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
                $('#area_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('/dashboard/area') }}",
                    columns: [
                        { data: 'id', name: 'id'},
                        { data: 'name', name: 'name'},
                        { data: 'area_sales_count', name: 'area_sales_count'},
                        { data: 'area_customer_count', name: 'area_customer_count'},
                        { data: 'action', name: 'action', orderable: false},
                    ],
                    order: [[0, 'asc']],
                });
                

                
                
            });
            function add(){
                $('#AreaForm').trigger("reset");
                $('#AreaModalTitle').html("Add Area");
                $('#id').val('');
            };
            
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/area/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#AreaForm').trigger("reset");
                        $('#AreaModalTitle').html("Edit Area");
                        $('#AreaModal').modal('show');
                        $('#id').val(res.id);
                        $('#name').val(res.name);                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }; 
            function toggleDashboard(id){
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/area/dashboard') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#area_table').dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            
            }
            function deleteFunc(id){
                if (confirm("Delete Record?") == true) {
                    var id = id;
                    // ajax
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/area/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var oTable = $('#area_table').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            }
            $('#AreaForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/area/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#AreaModal").modal('hide');
                        var oTable = $('#area_table').dataTable();
                        oTable.fnDraw(false);
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });

        </script>

        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>
    @endsection
        <!--body wrapper end-->
</x-app-layout>
