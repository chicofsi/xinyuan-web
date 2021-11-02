
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
            Manage GrossWeight
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage GrossWeight</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage GrossWeight
                        <span class="pull-right">
                            <a href="#GrossWeightModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add GrossWeight <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table  class="display table  table-striped" id="grossweight_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>GrossWeight</th>
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
                                        <th>GrossWeight</th>
                                        <th >Edit</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="GrossWeightModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="GrossWeightModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" id="GrossWeightForm" name="GrossWeightForm">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="grossweight">GrossWeight </label>
                                                <input type="text" class="form-control" id="grossweight" name="grossweight" placeholder="Enter GrossWeight ">
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
                $('#grossweight_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('/dashboard/product/grossweight') }}",
                    columns: [
                        { data: 'id', name: 'id'},
                        { data: 'gross_weight', name: 'gross_weight'},
                        { data: 'action', name: 'action', orderable: false},
                    ],
                    order: [[0, 'asc']],
                });
                
            });
            function add(){
                $('#GrossWeightForm').trigger("reset");
                $('#GrossWeightModalTitle').html("Add GrossWeight");
                $('#id').val('');
            };
            
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/product/grossweight/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#GrossWeightForm').trigger("reset");
                        $('#GrossWeightModalTitle').html("Edit GrossWeight");
                        $('#GrossWeightModal').modal('show');
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
                        url: "{{ url('/dashboard/product/grossweight/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var oTable = $('#grossweight_table').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            }
            $('#GrossWeightForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/product/grossweight/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#GrossWeightModal").modal('hide');
                        var oTable = $('#grossweight_table').dataTable();
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
