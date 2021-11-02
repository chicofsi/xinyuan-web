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
    <link rel="stylesheet" type="text/css" href="{{asset('js/jquery-multi-select/css/multi-select.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datepicker/css/datepicker-custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-timepicker/css/timepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-colorpicker/css/colorpicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datetimepicker/css/datetimepicker-custom.css')}}" />
    @endsection

    <!--body wrapper start-->
    <div class="wrapper">

        <form method="post" id="formOrder">
            <div class="panel">
                <div class="panel-body invoice">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h2 class="invoice-title" id="title">Create Purchase Order</h2>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-top: 15px">
                            <h1 class="t-due">Total Amount </h1>
                            <h2 class="amnt-value" id="total_amount">0</h2>
                        </div>
                    </div>
                    <div class="invoice-address">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Customer</h4>
                                <h2 class="corporate-id" >
                                    <select class="selectpicker  form-control" data-live-search="true" id="person_name" style="color: black;" name="person_name" >
                                        @foreach ($vendors->vendors  as $val)
                                            <option value="{{$val->display_name}}">{{$val->display_name}}</option>
                                        @endforeach
                                    </select>
                                </h2>
                                <h4 class="inv-to">Email</h4>

                                <input type="email" class="form-control" id="email" placeholder="Enter email">
                                <h4 class="inv-to" >Billing Address</h4>
                                <textarea rows="3" id="address" class="form-control"></textarea>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Transaction Date</h4>
                                <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="transaction_date" id="transaction_date" type="text" value="{{date('m/d/Y')}}" />
                                <h4 class="inv-to" >Due Date</h4>
                                <input data-date-format="mm/dd/yyyy" class="form-control default-date-picker" style="color: black;" name="due_date" id="due_date" type="text" value="{{date('m/d/Y')}}" />
                                <h4 class="inv-to">Term</h4>
                                <select class="desk form-control" id="terms" style="color: black;" name="terms" >
                                    @foreach ($terms->terms as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <h4 class="inv-to" id="receiver">Vendors Ref No </h4>
                                <input type="text" class="form-control" id="reference_no" placeholder="Enter Vendors Reference No">
                                <h4 class="inv-to" >Warehouse</h4>
                                <select class="desk form-control" id="warehouse" style="color: black;" name="warehouse" >
                                    <option value="">No Warehouse</option>
                                    @foreach ($warehouses->warehouses as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                                <h4 class="inv-to">Tags</h4>
                                <input type="text" class="form-control" id="tags" placeholder="Enter Tags">
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-invoice">
                    <thead>
                    <tr>
                        <th>Item Description</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Units</th>
                        <th class="text-center">Unit Price(in IDR)</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="product_table">
                                       

                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: left !important" colspan="6">
                                <a class="btn btn-info " onclick="addData();"><i class="fa fa-plus"></i> Add Data </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left !important">
                                <h4 class="inv-to">Memo</h4>
                                <textarea rows="3" id="memo" class="form-control"></textarea>
                                <h4 class="inv-to">Message</h4>
                                <textarea rows="3" id="message" class="form-control"></textarea>

                            </td>
                            <td class="text-right" colspan="3">
                                <p>Sub Total</p>
                                <p>Discount</p>
                                <p><strong>Total Amount</strong></p>
                            </td>
                            <td class="text-center">
                                <p id="subtotal">0</p>
                                <p id="discount_all">0</p>
                                <p><strong id="total_all">0</strong></p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-right " style="padding-right: 50px">
                                            
                <button type="submit"  type='button' class='btn btn-success'>
                    Create 
                </button>
            </div>
        </form>
    </div>
    @section('script')
        <script type="text/javascript" src="{{asset('js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-fileupload.min.js')}}"></script>
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
                $('#terms').change(function () {
                    getTerms();
                });
                getTerms();

                $('.productlist').change(function() {
                    elm=this;

                    $(this).parent().parent().find('#units').html('');
                    var url="{{ url('/dashboard/finance/product/detail/') }}/"+$(this).val();
                    $.ajax({
                        type:"GET",
                        url: url,
                        success: function(res){
                            $(elm).parent().parent().find('#units').append('<option value='+res.product.unit.id+'>'+res.product.unit.name+'</option>');
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });

                    var url="{{ url('/dashboard/finance/product/units/') }}/"+$(this).val();
                    $.ajax({
                        type:"GET",
                        url: url,
                        success: function(res){
                            $.each(res.unit_conversions, function(i, v){     
                                $(elm).parent().parent().find('#units').append('<option value='+v.unit_id+'>'+v.unit_name+'</option>');
                            })
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });


            });
            Date.prototype.addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }

            // function countTotalRowAmount() {
            //     // body...
            // }
            function getTerms() {
                var url="{{ url('/dashboard/finance/terms/') }}/"+$('#terms').val();
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        $('#due_date').val(new Date($('#transaction_date').val()).addDays(res.term.longetivity).toLocaleDateString());
                        console.log($('#due_date').val());
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            function checkTotal() {
                subtotalall=0;
                discountall=0;
                totalall=0;
                $.each($('#product_table tr'), function(i, v){     
                    total=$(this).find('#qty').val() * $(this).find('#unit_price').val();
                    discount=total * ($(this).find('#discount').val()/100);
                    total_all=total-discount;
                    $(this).find('#total').val(total_all);
                    subtotalall+=total;
                    discountall+=discount;
                    totalall+=total_all;
                });
                $('#subtotal').html(subtotalall);
                $('#discount_all').html(discountall);
                $('#total_all , #total_amount').html(totalall);


            }
            $('#formOrder').submit(function(e) {
                e.preventDefault();
                var form=new FormData();

                form.append('person_name', $('#person_name').val());
                form.append('email', $('#email').val());
                form.append('address', $('#address').val());
                form.append('transaction_date', $('#transaction_date').val());
                form.append('due_date', $('#due_date').val());
                form.append('terms', $('#terms').val());
                form.append('warehouse', $('#warehouse').val());
                form.append('reference_no', $('#reference_no').val());
                form.append('tags', $('#tags').val());
                form.append('memo', $('#memo').val());
                form.append('message', $('#message').val());
                $.each($('#product_table tr'), function(i, v){     
                    console.log('blabla');
                    form.append('detail['+i+'][product]',$(this).find('#product').val());
                    form.append('detail['+i+'][quantity]',$(this).find('#qty').val());
                    form.append('detail['+i+'][units]',$(this).find('#units').val());
                    form.append('detail['+i+'][price]',$(this).find('#unit_price').val());
                    form.append('detail['+i+'][discount]',$(this).find('#discount').val());
                    form.append('detail['+i+'][total]',$(this).find('#total').val());
                });

                $.ajax({
                    type:'POST',
                    url: "{{ url('/dashboard/finance/purchase/order/new')}}",
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        window.location.href = "{{ url('dashboard/finance/purchase') }}";
                    },
                    error: function(data){
                        console.log(data);
                    }
                }); 
            })

            function addData() {
                $('#product_table').append('<tr><td><select class="desk form-control productlist" id="product" style="color: black;" name="product" ></select><textarea rows="1" id="description" class="form-control"></textarea></td><td><input type="number" class="form-control" id="qty" placeholder="Enter Qty" min="0"></td><td><select class="desk form-control" id="units" style="color: black;" name="units" ></select></td><td><input type="number" class="form-control" id="unit_price" value="0" min="0"></td><td><input type="number" class="form-control" id="discount" value="0" min="0"></td><td><input type="number" class="form-control" id="total" value="0" min="0"></td><td><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="detail" class="btn btn-danger btn-delete btn-sm"><i class="fas fa-trash"></i></a></td></tr>');
                getProductList();
                $(".btn-delete").click(function() {
                    var elm=this;
                    var a=$(elm).parent().parent().remove();
                });
                $("select, input[type='number']").change(function () {
                    checkTotal();
                })


                $('.productlist').change(function() {
                    elm=this;

                    $(this).parent().parent().find('#units').html('');
                    var url="{{ url('/dashboard/finance/product/detail/') }}/"+$(this).val();
                    $.ajax({
                        type:"GET",
                        url: url,
                        success: function(res){
                            $(elm).parent().parent().find('#units').append('<option value='+res.product.unit.id+'>'+res.product.unit.name+'</option>');
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });

                    var url="{{ url('/dashboard/finance/product/units/') }}/"+$(this).val();
                    $.ajax({
                        type:"GET",
                        url: url,
                        success: function(res){
                            $.each(res.unit_conversions, function(i, v){     
                                $(elm).parent().parent().find('#units').append('<option value='+v.unit_id+'>'+v.unit_name+'</option>');
                            })
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });
            }
            
            function getProductList() {
                var url="{{ url('/dashboard/finance/product/list') }}";
                
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){
                        elm=$('#product_table tr:last-child .productlist');
                        $.each(res.products, function(i, v){     
                            elm.append('<option value='+v.id+'>'+v.name+'</option>');
                        });

                        $(elm).parent().parent().find('#units').html('');
                        var url="{{ url('/dashboard/finance/product/detail/') }}/"+$(elm).val();
                        $.ajax({
                            type:"GET",
                            url: url,
                            success: function(res){
                                $(elm).parent().parent().find('#units').append('<option value='+res.product.unit.id+'>'+res.product.unit.name+'</option>');
                            },
                            error: function(data){
                                console.log(data);
                            }
                        });

                        var url="{{ url('/dashboard/finance/product/units/') }}/"+$(elm).val();
                        $.ajax({
                            type:"GET",
                            url: url,
                            success: function(res){
                                $.each(res.unit_conversions, function(i, v){     
                                    $(elm).parent().parent().find('#units').append('<option value='+v.unit_id+'>'+v.unit_name+'</option>');
                                })
                            },
                            error: function(data){
                                console.log(data);
                            }
                        });
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
                        $('#AccountInvitedBy').html(res.purchase.name);
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



