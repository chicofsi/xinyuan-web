
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
            Manage Logo
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Logo</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Logo
                        <span class="pull-right">
                            <a href="#LogoModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Logo <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table  class="display table  table-striped" id="logo_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Logo Name</th>
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
                                        <th>Logo Name</th>
                                        <th >Edit</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="LogoModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="LogoModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" id="LogoForm" name="LogoForm">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="height">Logo Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Logo Name">
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
                $('#logo_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('/dashboard/product/logo') }}",
                    columns: [
                        { data: 'id', name: 'id'},
                        { data: 'name', name: 'name'},
                        { data: 'action', name: 'action', orderable: false},
                    ],
                    order: [[0, 'asc']],
                });
                
            });
            function add(){
                $('#LogoForm').trigger("reset");
                $('#LogoModalTitle').html("Add Logo");
                $('#id').val('');
            };
            
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/product/logo/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#LogoForm').trigger("reset");
                        $('#LogoModalTitle').html("Edit Logo");
                        $('#LogoModal').modal('show');
                        $('#id').val(res.id);
                        $('#name').val(res.name);                        
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
                        url: "{{ url('/dashboard/product/logo/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var oTable = $('#logo_table').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            }
            $('#LogoForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/product/logo/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#LogoModal").modal('hide');
                        var oTable = $('#logo_table').dataTable();
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
