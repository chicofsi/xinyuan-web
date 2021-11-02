
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
            Manage Company
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Manage Company</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Company
                        <span class="pull-right">
                            <a href="#CompanyModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Company <i class="fa fa-plus"></i></a>
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table  class="display table  table-striped" id="company_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company Code</th>
                                        <th>Company Name</th>
                                        <th>Transaction</th>
                                        <th class="no-sort">Edit</th>

                                    </tr>
                                </thead>
                                    
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company Code</th>
                                        <th>Company Name</th>
                                        <th>Transaction</th>
                                        <th class="no-sort">Edit</th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="CompanyModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="CompanyModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" id="CompanyForm" name="CompanyForm">
                                            <input type="hidden" name="id" id="id">

                                            <div class="form-group">
                                                <label for="name">Company Code</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Company Code">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Company Name</label>
                                                <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Enter Company Name">
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
                $('#company_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('/dashboard/company') }}",
                    columns: [
                        { data: 'id', name: 'id'},
                        { data: 'name', name: 'name'},
                        { data: 'display_name', name: 'display_name'},
                        { data: 'transaction_count', name: 'transaction_count'},
                        { data: 'action', name: 'action', orderable: false},
                    ],
                    order: [[0, 'asc']],
                });
                

                
                
            });
            function add(){
                $('#CompanyForm').trigger("reset");
                $('#CompanyModalTitle').html("Add Company");
                $('#id').val('');
            };
            
            function editFunc(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/company/edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#CompanyForm').trigger("reset");
                        $('#CompanyModalTitle').html("Edit Company");
                        $('#CompanyModal').modal('show');
                        $('#id').val(res.id);
                        $('#name').val(res.name);                        
                        $('#display_name').val(res.display_name);                        
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }; 
            function toggle(id){
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/company/toggle') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#company_table').dataTable();
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
                        url: "{{ url('/dashboard/company/delete') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            var oTable = $('#company_table').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            }
            $('#CompanyForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/company/store')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#CompanyModal").modal('hide');
                        var oTable = $('#company_table').dataTable();
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
