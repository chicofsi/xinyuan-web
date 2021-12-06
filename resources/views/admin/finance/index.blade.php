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
            Manage Cash & Bank
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active">Manage Cash & Bank</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Manage Cash & Bank
                        <span class="pull-right"> 
                            <a href="#AddAccountModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add New Account <i class="fa fa-plus"></i></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table  class="display table table-hover " id="customer_table">
                                <thead>
                                    <tr>
                                        <th>
                                            Account Code
                                        </th>
                                        <th>
                                            Account Name
                                        </th>
                                        <th style="text-align: right;">
                                            Balance
                                        </th>
                                        <th class="no-sort" style="min-width: 100px; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customertable"></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" id="account_count">
                                            Account Count : 
                                        </th>
                                        <th id="total_balance"  style="text-align: right;">
                                            
                                        </th>
                                        <th style="text-align: right;">
                                            
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                        <div aria-hidden="true" role="dialog"  id="AddAccountModal" class="modal fade">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <form role="form" id="AddAccountForm" name="AddAccountForm">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"  id="AddAccountModalTitle">Form Title</h4>
                                        </div>
                                        <div class="modal-body" style="background-color: #eff0f4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">Account Detail</div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Account Name</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="name" name="name" placeholder="Enter Account Name">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Number</div>

                                                                            <input type="text" class="form-control desk" style="color: black;" id="number" name="number" placeholder="Enter Account Number">
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Category Name</div>
                                                                            <select class="desk form-control" id="category_name"style="color: black;" name="category_name" >
                                                                                <option value="Cash & Bank">Cash & Bank</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                            </select>
                                                                        </li>
                                                                        <li>
                                                                            <div class="title">Description</div>
                                                                            <input type="text" class="form-control desk" style="color: black;" id="description" name="description" placeholder="Enter Account Description">
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                {{-- <div class="col-md-6">
                                                                    <ul class="p-info">
                                                                        <li>
                                                                            <div class="title">Payment Method</div>
                                                                            <select class="desk form-control" id="payment" style="color: black;" name="payment" >
                                                                                <option value="cash">cash</option>
                                                                                <option value="postpaid">postpaid</option>
                                                                            </select>
                                                                        </li>
                                                                        <li id="payment_account_input">
                                                                            <div class="title">Payment Account</div>
                                                                            <select class="desk form-control" id="id_payment_account" style="color: black;" name="id_payment_account" >
                                                                                <?php foreach ($accounts as $account):?>
                                                                                    <option value="{{$account->id}}">{{$account->bank->name}} - {{$account->account_name}} {{$account->account_number}}</option>
                                                                                <?php endforeach?>
                                                                            </select>
                                                                        </li>
                                                                        <li id="tempo_input" style="display: none">
                                                                            <div class="title">Tempo</div>
                                                                            <select class="desk form-control" id="tempo"style="color: black;" name="tempo" >
                                                                                <option value="0">0 Days</option>
                                                                                <option value="15">15 Days</option>
                                                                                <option value="30">30 Days</option>
                                                                                <option value="45">45 Days</option>
                                                                                <option value="60">60 Days</option>
                                                                                <option value="75">75 Days</option>
                                                                                <option value="90">90 Days</option>
                                                                            </select>
                                                                        </li>

                                                                    </ul>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                    
                                            </div>
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="btn-save" class="btn btn-success">Submit</button>
                                        </div>

                                    </form>
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
                $('body').append('<div class="loading"></div>');

                getTables();
                $("#searchbar").on("keyup", function() {
                    checkFilter();
                });
            });
            function getTables() {
                var url="{{ url('/dashboard/finance/account') }}";
                
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){

                        $('#customertable').html("");
                        var total=0;
                        $('#customertable').append("<tr><th colspan='4' style='padding-left:50px'>Cash & Bank</th></tr>");

                        $.each(res.cash.accounts,function (key, value) {

                            if(value.parent_id==null){

                                total+=value.balance_amount;
                                $row="<tr>";

                                if(value.is_parent){
                                    $row+="<td><strong>"+value.number+"</strong></td>";
                                    $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+"</td>"+
                                    "<td style='text-align: center;'>"+
                                    "</td>"+
                                    "</tr>";
                                }else{
                                    $row+="<td>"+value.number+"</td>";
                                    $balance=value.balance;
                                    $row+="<td><a href='{{ url('/dashboard/finance/account') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+$balance+"</td>"+
                                    "<td style='text-align: center;'>"+
                                        "<div class='btn-group'>"+
                                            "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                "Action <span class='caret'></span>"+
                                            "</button>"+
                                            "<ul role='menu' class='dropdown-menu'>"+
                                                "<li><a href='{{ url('dashboard/finance/banktransfer') }}?from="+value.id+"'>Transfer Funds</a></li>"+
                                                "<li><a href='{{ url('dashboard/finance/receivemoney') }}?from="+value.id+"'>Receive Money</a></li>"+
                                                "<li><a href='#'>Pay Money</a></li>"+
                                            "</ul>"+
                                        "</div>"+
                                    "</td>";
                                }
                                
                                $('#customertable').append($row);

                                if(value.is_parent){
                                    $.each(value.children,function (key, val) {
                                        $row="<tr >";

                                        if(val.account.is_parent !=0){
                                            $row+="<td style='padding-left:30px !important'><strong>"+val.account.number+"</strong></td>";
                                        }else{
                                            $row+="<td style='padding-left:30px !important'>"+val.account.number+"</td>";
                                        }

                                        $row+="<td style='padding-left:30px !important'><a href='{{ url('/dashboard/finance/account') }}/"+val.account.id+"'' ><button class='btn btn-link'>"+val.account.name+"</button></a></td>"+
                                            "<td style='padding-left:30px !important; text-align: right;'>"+formatRupiah(String(parseFloat(val.account.balance)),"Rp. ")+"</td>"+
                                            "<td style='text-align: center;'>"+
                                                "<div class='btn-group'>"+
                                                    "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                        "Action <span class='caret'></span>"+
                                                    "</button>"+
                                                    "<ul role='menu' class='dropdown-menu'>"+
                                                        "<li><a href='{{ url('dashboard/finance/banktransfer') }}?from="+val.account.id+"'>Transfer Funds</a></li>"+
                                                        "<li><a href='{{ url('dashboard/finance/receivemoney') }}?from="+val.account.id+"'>Receive Money</a></li>"+
                                                        "<li><a href='#'>Pay Money</a></li>"+
                                                    "</ul>"+
                                                "</div>"+
                                            "</td>"+
                                            "</tr>";
                                        $('#customertable').append($row);
                                    })

                                }
                            }
                        });
                        $('#customertable').append("<tr><th colspan='4' style='padding-left:50px'>Credit Card</th></tr>");

                        $.each(res.credit.accounts,function (key, value) {

                            if(value.parent_id==null){

                                total+=value.balance_amount;
                                $row="<tr>";

                                if(value.is_parent){
                                    $row+="<td><strong>"+value.number+"</strong></td>";
                                    $row+="<td><a href='{{ url('/dashboard/finance/account/') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+"</td>"+
                                    "<td style='text-align: center;'>"+
                                    "</td>"+
                                    "</tr>";
                                }else{
                                    $row+="<td>"+value.number+"</td>";
                                    $balance=value.balance;
                                    $row+="<td><a href='{{ url('/dashboard/finance/account/') }}/"+value.id+"'' ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+$balance+"</td>"+
                                    "<td style='text-align: center;'>"+
                                        "<div class='btn-group'>"+
                                            "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                "Action <span class='caret'></span>"+
                                            "</button>"+
                                            "<ul role='menu' class='dropdown-menu'>"+
                                                "<li><a href='{{ url('dashboard/finance/banktransfer') }}?from="+value.id+"'>Transfer Funds</a></li>"+
                                                "<li><a href='{{ url('dashboard/finance/receivemoney') }}?from="+value.id+"'>Receive Money</a></li>"+
                                                "<li><a href='#'>Pay Money</a></li>"+
                                            "</ul>"+
                                        "</div>"+
                                    "</td>";
                                }

                                
                                $('#customertable').append($row);

                                if(value.is_parent){
                                    $.each(value.children,function (key, val) {
                                        $row="<tr >";

                                        if(val.account.is_parent !=0){
                                            $row+="<td style='padding-left:30px !important'><strong>"+val.account.number+"</strong></td>";
                                        }else{
                                            $row+="<td style='padding-left:30px !important'>"+val.account.number+"</td>";
                                        }

                                        $row+="<td style='padding-left:30px !important'><a href='{{ url('/dashboard/finance/account') }}/"+val.account.id+"'' ><button class='btn btn-link'>"+val.account.name+"</button></a></td>"+
                                            "<td style='padding-left:30px !important; text-align: right;'>"+formatRupiah(String(parseFloat(val.account.balance)),"Rp. ")+"</td>"+
                                            "<td style='text-align: center;'>"+
                                                "<div class='btn-group'>"+
                                                    "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                        "Action <span class='caret'></span>"+
                                                    "</button>"+
                                                    "<ul role='menu' class='dropdown-menu'>"+
                                                        "<li><a href='{{ url('dashboard/finance/banktransfer') }}?from="+val.account.id+"'>Transfer Funds</a></li>"+
                                                        "<li><a href='{{ url('dashboard/finance/receivemoney') }}?from="+val.account.id+"'>Receive Money</a></li>"+
                                                        "<li><a href='#'>Pay Money</a></li>"+
                                                    "</ul>"+
                                                "</div>"+
                                            "</td>"+
                                            "</tr>";
                                        $('#customertable').append($row);
                                    })

                                }
                            }

                        });

                        $('#total_balance').html(formatRupiah(String(total),"Rp. "));
                                            
                        $('#account_count').html("Account Count : "+(res.cash.total_count+res.credit.total_count));
                        $('.loading').css("display",'none');

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

            function add(){
                $('#AddAccountForm').trigger("reset");
                $('#AddAccountModalTitle').html("Add Account");
                $('#id').val('');
            };

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/customer/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#AccountDetailModalTitle').html("Account Details");
                        $('#AccountDetailModal').modal('show');
                        $('#idAccount').val(res.id);
                        $('#id_level_change').val(res.customerlevel.id);

                        $('#AccountCompanyName').html(res.company_name);
                        $('#AccountAdministratorName').html(res.administrator_name);
                        $('#AccountArea').html(res.area.name);
                        $('#AccountTempo').html(res.customerlevel.tempo_limit);
                        $('#AccountLoanLimit').html(res.customerlevel.loan_limit);
                        $('#AccountInvitedBy').html(res.sales.name);
                        $('#AccountLevel').html(res.customerlevel.level);
                        var join=new Date(res.created_at);
                        $('#AccountJoined').html("Joined Since "+(join.getDate())+"/"+join.getMonth()+1+"/"+join.getFullYear());
                        $('#AccountTotalTransaction').html(res.transactioncount+' Transaction');
                        if(res.unpaid){
                            $('#AccountTotalUnpaid').html(res.unpaid);
                        }else{
                            $('#AccountTotalUnpaid').html(0);
                        }

                        $('#AccountCompanyAddress').html(res.company_address);
                        $('#AccountCompanyPhone').html(res.company_phone);
                        $('#AccountCompanyNPWP').html(res.company_npwp);
                        $('#AccountAdministratorID').html(res.administrator_id);
                        $('#AccountAdministratorBirthdate').html(res.administrator_birthdate);
                        $('#AccountAdministratorNPWP').html(res.administrator_npwp);
                        $('#AccountAdministratorPhone').html(res.administrator_phone);
                        $('#AccountAdministratorAddress').html(res.administrator_address);

                        var data=[];
                        $.each(res.chart, function(){     
                            data.push([gd(this.year,this.month),this.transaction]);
                        });
                        transactionChart(data);

                        $('#AccountPhoto').html(res.gallery);


                        $('#TransactionList').html(res.transactionlist);

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            

            



            

            $('#AddAccountForm').submit(function(e) {
                $('.loading').css("display",'block');

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
                        $('.loading').css("display",'none');
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
