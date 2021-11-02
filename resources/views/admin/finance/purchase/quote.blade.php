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

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="panel">
            <div class="panel-body invoice">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h1 class="quote-title" id="title">Purchase Quote</h1>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h2 style="margin-top: 30px" id="status">Paid</h2>
                    </div>
                </div>
                <div class="invoice-address">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <h4 class="inv-to" id="receiver">Customer</h4>
                            <h2 class="corporate-id" id="receiver_name">Envato</h2>
                            <h4 class="inv-to" >Billing Address</h4>
                            <p id="address">
                                121 King Street, Melbourne<br>
                                Victoria 3000 Australia<br>
                            </p>
                            <h4 class="inv-to">Email</h4>
                            <p id="email">
                                Email : info@envato.com
                            </p>

                        </div>
                        <div class="col-md-4  col-sm-4">
                            <div class="inv-col"><span>Transaction Date :</span> <div id="transaction_date"> 22 March 2014</div></div>
                            <div class="inv-col"><span>Due Date :</span> <div id="due_date">22 March 2014</div> </div>
                            <div class="inv-col"><span>Term :</span><div id="term">Net 15</div> </div>
                        </div>
                        <div class="col-md-4  col-sm-4">
                            <div class="inv-col"><span>Purchase Order No </span><div id="order_no">Purchase Order #10001</div> </div>
                            <div class="inv-col"><span>Transaction No </span> <div id="transaction_no">#10004</div> </div>
                            <div class="inv-col"><span>Customer Ref No </span> <div id="ref_no"></div></div>
                            <div class="inv-col"><span>Tags </span><div id="tags"></div></div>
                            <h1 class="t-due">Total Amount </h1>
                            <h2 class="amnt-value" id="Total_amount">Rp. 1.250.000,00</h2>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-invoice">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Item Description</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Units</th>
                    <th class="text-center">Unit Price(in IDR)</th>
                    <th class="text-center">Discount</th>
                    <th class="text-center">Total</th>
                </tr>
                </thead>
                <tbody id="product_table">
                
                

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="payment-method">
                        </td>
                        <td class="text-right" colspan="2">
                            <p>Sub Total</p>
                            <p>Payment Paid</p>
                            <p><strong>Balance Due</strong></p>
                        </td>
                        <td class="text-center">
                            <p id="subtotal">Rp. 500.000,00</p>
                            <p id="payment_paid">Rp. 0,00</p>
                            <p><strong id="balance_due">Rp. 500.000,00</strong></p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center ">
            <a class="btn btn-success btn-lg"><i class="fa fa-check"></i> Submit Invoice </a>
            <a class="btn btn-primary btn-lg" target="_blank" href="quote_print.html"><i class="fa fa-print"></i> Print </a>
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
                getDetails();

            });
            
            function getDetails() {
                var url="{{ url('/dashboard/finance/purchase/quote/details/') }}"+"/"+{{$id}};
                
                $.ajax({
                    type:"GET",
                    url: url,
                    success: function(res){

                        $('#title').html("Purchase Quote #"+res.purchase_quote.transaction_no);
                        $('#status').html(res.purchase_quote.transaction_status.name);
                        $('#receiver').html("vendor");
                        $('#receiver_name').html(res.purchase_quote.person.display_name);
                        $('#address').html(res.purchase_quote.shipping_address);
                        $('#email').html(res.purchase_quote.email);
                        $('#transaction_date').html(res.purchase_quote.transaction_date);
                        $('#due_date').html(res.purchase_quote.due_date);
                        $('#term').html(res.purchase_quote.term.name);
                        if(res.purchase_quote.purchase_order){
                            $('#order_no').html(res.purchase_quote.purchase_order.transaction_no);

                        }
                        $('#transaction_no').html(res.purchase_quote.transaction_no);
                        $('#ref_no').html(res.purchase_quote.reference_no);
                        $('#tags').html(res.purchase_quote.tags);
                        $.each(res.purchase_quote.transaction_lines_attributes,function (key, value) {
                            $('#product_table').append("<tr><td>"+(key+1)+"</td><td><h4>"+value.product.name+"</h4><p>"+value.description+"</p></td><td class='text-center'><strong>"+value.quantity+"</strong></td><td class='text-center'><strong>"+value.unit.name+"</strong></td><td class='text-center'><strong>"+value.rate_currency_format+"</strong></td><td class='text-center'><strong>"+value.discount+"%</strong></td><td class='text-center'><strong>"+value.amount_currency_format+"</strong></td></tr>")
                        });
                        $('#subtotal').html(res.purchase_quote.subtotal_currency_format);
                        $('#Total_amount').html(res.purchase_quote.original_amount_currency_format);
                        $('#payment_paid').html(res.purchase_quote.payment_received_amount_currency_format);
                        $('#balance_due').html(res.purchase_quote.credit_memo_balance_currency_format);
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




