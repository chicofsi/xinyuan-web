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
            ({{$response->account->number}}) {{$response->account->name}}
        </h3>
        <div class="state-info">
            @if ($response->account->category->id==3)
                <a href="#TransactionModal" data-toggle="modal" onclick="add()" class=" btn btn-primary ">Transfer Funds<i class="fa fa-plus"></i></a>
            @endif
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
                                <a href="#jurnaltransaction" data-toggle="tab">Jurnal Transaction</a>
                            </li>
                            {{-- <li class="">
                                <a href="#bankstatement" data-toggle="tab">Bank Statement</a>
                            </li>
                            <li class="">
                                <a href="#reconcile" data-toggle="tab">Reconcile</a>
                            </li>
                            <li class="">
                                <a href="#cashmapping" data-toggle="tab">Cash Mapping</a>
                            </li> --}}
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="jurnaltransaction">
                                <div class="adv-table">
                                    <table  class="display table table-hover " id="customer_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Date
                                                </th>
                                                <th>
                                                    Person
                                                </th>
                                                <th>
                                                    Description
                                                </th>
                                                <th style="text-align: right;">
                                                    Received
                                                </th>
                                                <th style="text-align: right;">
                                                    Spent
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($response->account->transactions as $val)
                                                <tr>
                                                    <td>
                                                        {{$val->date}}
                                                    </td>
                                                    <td>
                                                        {{$val->person->name}}
                                                    </td>
                                                    <td>
                                                        {{$val->transaction->transaction_type}} #{{$val->transaction->transaction_no}}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->debit}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->credit}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            {{-- <div class="tab-pane" id="bankstatement">
                                <div class="adv-table">
                                    <table  class="display table table-hover " id="customer_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Date
                                                </th>
                                                <th>
                                                    Person
                                                </th>
                                                <th>
                                                    Description
                                                </th>
                                                <th style="text-align: right;">
                                                    Received
                                                </th>
                                                <th style="text-align: right;">
                                                    Spent
                                                </th>
                                                <th style="text-align: right;">
                                                    Balance
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($response->account->transactions as $val)
                                                <tr>
                                                    <td>
                                                        {{$val->date}}
                                                    </td>
                                                    <td>
                                                        {{$val->person->name}}
                                                    </td>
                                                    <td>
                                                        {{$val->transaction->transaction_type}} #{{$val->transaction->transaction_no}}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->debit}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->credit}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->balance}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            
                            </div>
                            <div class="tab-pane" id="reconcile">
                                Reconcile
                            </div>
                            <div class="tab-pane" id="cashmapping">CashMapping</div> --}}
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
                                    $row+="<td><a href='javascript:void(0)' onClick=detail("+value.id+") ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+"</td>"+
                                    "<td style='text-align: center;'>"+
                                    "</td>"+
                                    "</tr>";
                                }else{
                                    $row+="<td>"+value.number+"</td>";
                                    $balance=value.balance;
                                    $row+="<td><a href='javascript:void(0)' onClick=detail("+value.id+") ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+$balance+"</td>"+
                                    "<td style='text-align: center;'>"+
                                        "<div class='btn-group'>"+
                                            "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                "Action <span class='caret'></span>"+
                                            "</button>"+
                                            "<ul role='menu' class='dropdown-menu'>"+
                                                "<li><a href='#'>Transfer Funds</a></li>"+
                                                "<li><a href='#'>Receive Money</a></li>"+
                                                "<li><a href='#'>Pay Money</a></li>"+
                                                "<li class='divider'></li>"+
                                                "<li><a href='#'>Import Bank Statement</a></li>"+
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

                                        $row+="<td style='padding-left:30px !important'><a href='javascript:void(0)' onClick=detail("+val.account.id+") ><button class='btn btn-link'>"+val.account.name+"</button></a></td>"+
                                            "<td style='padding-left:30px !important; text-align: right;'>"+formatRupiah(String(parseFloat(val.account.balance)),"Rp. ")+"</td>"+
                                            "<td style='text-align: center;'>"+
                                                "<div class='btn-group'>"+
                                                    "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                        "Action <span class='caret'></span>"+
                                                    "</button>"+
                                                    "<ul role='menu' class='dropdown-menu'>"+
                                                        "<li><a href='#'>Transfer Funds</a></li>"+
                                                        "<li><a href='#'>Receive Money</a></li>"+
                                                        "<li><a href='#'>Pay Money</a></li>"+
                                                        "<li class='divider'></li>"+
                                                        "<li><a href='#'>Import Bank Statement</a></li>"+
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
                                    $row+="<td><a href='javascript:void(0)' onClick=detail("+value.id+") ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+"</td>"+
                                    "<td style='text-align: center;'>"+
                                    "</td>"+
                                    "</tr>";
                                }else{
                                    $row+="<td>"+value.number+"</td>";
                                    $balance=value.balance;
                                    $row+="<td><a href='javascript:void(0)' onClick=detail("+value.id+") ><button class='btn btn-link'>"+value.name+"</button></a></td>"+
                                    "<td  style='text-align: right;'>"+$balance+"</td>"+
                                    "<td style='text-align: center;'>"+
                                        "<div class='btn-group'>"+
                                            "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                "Action <span class='caret'></span>"+
                                            "</button>"+
                                            "<ul role='menu' class='dropdown-menu'>"+
                                                "<li><a href='#'>Transfer Funds</a></li>"+
                                                "<li><a href='#'>Receive Money</a></li>"+
                                                "<li><a href='#'>Pay Money</a></li>"+
                                                "<li class='divider'></li>"+
                                                "<li><a href='#'>Import Bank Statement</a></li>"+
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

                                        $row+="<td style='padding-left:30px !important'><a href='javascript:void(0)' onClick=detail("+val.account.id+") ><button class='btn btn-link'>"+val.account.name+"</button></a></td>"+
                                            "<td style='padding-left:30px !important; text-align: right;'>"+formatRupiah(String(parseFloat(val.account.balance)),"Rp. ")+"</td>"+
                                            "<td style='text-align: center;'>"+
                                                "<div class='btn-group'>"+
                                                    "<button data-toggle='dropdown' type='button' class='btn btn-default btn-sm dropdown-toggle'>"+
                                                        "Action <span class='caret'></span>"+
                                                    "</button>"+
                                                    "<ul role='menu' class='dropdown-menu'>"+
                                                        "<li><a href='#'>Transfer Funds</a></li>"+
                                                        "<li><a href='#'>Receive Money</a></li>"+
                                                        "<li><a href='#'>Pay Money</a></li>"+
                                                        "<li class='divider'></li>"+
                                                        "<li><a href='#'>Import Bank Statement</a></li>"+
                                                    "</ul>"+
                                                "</div>"+
                                            "</td>"+
                                            "</tr>";
                                        $('#customertable').append($row);
                                    })

                                }
                            }

                        });

                        $('#total_balance').append(formatRupiah(String(total),"Rp. "));
                        $('#account_count').append(res.cash.total_count+res.credit.total_count);

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



