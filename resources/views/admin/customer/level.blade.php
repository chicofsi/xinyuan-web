
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
            Manage Customer Level
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Customer Level</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Customer Level
                        <span class="pull-right">
                            <a href="#LevelModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Level <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table  class="display table  table-striped" id="level_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Level</th>
                                        <th>Tempo Limit</th>
                                        <th>Loan Limit</th>
                                        <th>Status</th>
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
                                        <th>Level</th>
                                        <th>Tempo Limit</th>
                                        <th>Loan Limit</th>
                                        <th>Status</th>
                                        <th >Edit</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="LevelModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="LevelModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" id="LevelForm" name="LevelForm">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="level">Level </label>
                                                <input type="text" class="form-control" id="level" name="level" placeholder="Enter Level">
                                            </div>
                                            <div class="form-group">
                                                <label for="tempo_limit">Tempo Limit</label>
                                                <input type="text" class="form-control" id="tempo_limit" name="tempo_limit" placeholder="Enter Tempo Limit">
                                            </div>
                                            <div class="form-group">
                                                <label for="loan_limit">Loan Limit</label>
                                                <input type="text" class="form-control" id="loan_limit" name="loan_limit" placeholder="Enter Loan Limit">
                                            </div>
                                            <div class="form-group">
                                                <label for="loan_limit">Customer Status</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="nice" id="nice_customer" value="1" checked>
                                                        <span class='label label-success'>Nice Customer</span>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="nice" id="bad_customer" value="0">
                                                        <span class='label label-danger'>Bad Customer</span>
                                                    </label>
                                                </div>
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
                $('#level_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('/dashboard/customer/level') }}",
                    columns: [
                        { data: 'id', name: 'id'},
                        { data: 'level', name: 'level'},
                        { data: 'tempo_limit', name: 'tempo_limit'},
                        { data: 'loan_limit', name: 'loan_limit'},
                        { data: 'status', name: 'status'},
                        { data: 'action', name: 'action', orderable: false},
                    ],
                    order: [[0, 'asc']],
                });
                

                
                
            });
            function add(){
                $('#LevelForm').trigger("reset");
                $('#LevelModalTitle').html("Add Level");
                $('#id').val('');
            };
            
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/level/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#LevelForm').trigger("reset");
                        $('#LevelModalTitle').html("Edit Level");
                        $('#LevelModal').modal('show');
                        $('#id').val(res.id);
                        $('#level').val(res.level);
                        $('#tempo_limit').val(res.tempo_limit);
                        $('#loan_limit').val(res.loan_limit);                   
                        if(res.nice==1){
                            $('#nice_customer').attr('checked','checked');
                        }else{
                            $('#bad_customer').attr('checked','checked');
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }; 
            function deleteFunc(id){
                if (confirm("Delete Record?") == true) {
                    var id = id;
                    // ajax
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/customer/level/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var oTable = $('#level_table').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            }
            $('#LevelForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/customer/level/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#LevelModal").modal('hide');
                        var oTable = $('#level_table').dataTable();
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
