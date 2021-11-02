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
    <!-- page heading start-->
    <div class="page-heading">
        <h3>
            Product Value Management
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active"> Product Value Management</li>
        </ul>
    </div>
    <!-- page heading end-->

    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Product Value Management
                        <span class="pull-right">{{-- 
                            <a href="#PurchaseModal" data-toggle="modal" onclick="add()" class=" btn btn-primary btn-sm">Add Purchase <i class="fa fa-plus"></i></a> --}}
                            {{-- <a href="javascript:;" class="fa fa-times"></a> --}}
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="row">
                                <div class="col-md-8" style="padding: 10px">
                                    <div class="col-md-8">
                                        <label class="control-label">Date Range
                                            <div class="col-md-10 input-group input-large custom-date-range"  data-date-format="mm/dd/yyyy">
                                                <input id="from" type="text" class="form-control dpd1" name="from"  value="{{date('m/d/Y',strtotime("-7 days"))}}">
                                                <span class="input-group-addon">To</span>
                                                <input id="to" type="text" class="form-control dpd2" name="to" value="{{date('m/d/Y')}}">
                                            </div>
                                        </label>
                                        <button type="submit" id="btn-search" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 10px">
                                    <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                </div>
                            </div>
                            <table  class="display table table-striped" id="purchase_table">
                                <thead>
                                    <tr>
                                        <th>
                                            Entry Date
                                        </th>
                                        <th>
                                            Product
                                        </th>
                                        <th>
                                            Entry Price
                                        </th>
                                        <th>
                                            Entry Price (in IDR)
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Total Value
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="valuetable"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            Entry Date
                                        </th>
                                        <th>
                                            Product
                                        </th>
                                        <th>
                                            Entry Price
                                        </th>
                                        <th>
                                            Entry Price (in IDR)
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Total Value
                                        </th>

                                    </tr>
                                </tfoot>
                            </table>



                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    @section('script')

        <script src="{{asset('js/flot-chart/jquery.flot.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.tooltip.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.pie.resize.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.selection.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('js/flot-chart/jquery.flot.time.js')}}"></script>
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

                getTables();

                $("#searchbar").on("keyup", function() {
                    checkFilter();
                });



                

                $('#btn-search').click(function () {
                    getTables();
                });
                
                
            });


            function getTables() {
                var from=$('#from').val();
                var to=$('#to').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/value-management/list') }}",
                    data: { from: from, to: to},
                    dataType: 'json',
                    success: function(res){
                        $('#valuetable').html(res.data);

                        $("input[type='checkbox']").click(function() {
                            checkFilter();
                        });
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            
            function checkFilter() {
                var value = $("#searchbar").val().toLowerCase();

                $("#purchasetable tr").filter(function() {
                    var value=$(this).text().toLowerCase();
                    var elm=this;

                    var searchtext=$("#searchbar").val().toLowerCase();
                    var search=$(this).text().toLowerCase().indexOf(searchtext) > -1;

                    $(this).toggle(search);
                });
            }
            function add(){
                $('#btn-delete').css('display','none');
                $('#btn-add-return').css('display','none');
                $('#PurchaseForm').trigger("reset");
                $('#carttable').html("");
                $('#PurchaseModalTitle').html("Add Purchase");
                $('#id').val('');
                $('#purchaseproducttable').html("");
                checkTotalPayment();
            }

            function detail(id){
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#btn-add-return').css('display','inline');
                        $('#btn-delete').css('display','inline');

                        $('#id').val(res.id);
                        $('#carttable').html("");
                        $('#purchaseproducttable').html("");
                        $('#returntable').html("");

                        $('#invoice_number').val(res.invoice_number);
                        $('#id_factories').val(res.id_factories);
                        $('#id_currency').val(res.id_currency);
                        $('#payment').val(res.payment);
                        $('#tempo').val(res.tempo);
                        $('#date').val(res.date);

                        $('#PurchaseModalTitle').html("Purchase Details");
                        $('#PurchaseModal').modal('show');
                        $.each(res.purchasedetails, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getbyid') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    if($('#id_currency').val()==1){
                                        rate="display:none";
                                    }else{
                                        rate="display:block";
                                    }
                                    $('#carttable').append("<tr><td>"+v.id+'<input type="hidden" name="id" id="id_purchase_details" value="'+v.id+'">'+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' value="+v.quantity+" placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;"+rate+"' id='rates' name='rates' value="+v.rates+" placeholder='Rates' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' value="+v.price+" placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>"+v.total_idr+"</td></tr>");

                                    $('#carttable #quantity').each(function() {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#price').val() ){
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            
                                            quantity=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })
                                    
                                    $('#carttable #price').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            }

                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            price=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    $('#carttable #rates').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val() && $(this).parent().parent().parent().parent().find('#price').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            rates=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    checkTotalPayment();

                                    

                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                        });


                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                checkTotalCashback();
                
            }
            function refreshData(){
                var id=$('#id').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/dashboard/purchase/detail') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        $('#btn-add-return').css('display','inline');
                        $('#btn-delete').css('display','inline');

                        $('#id').val(res.id);
                        $('#carttable').html("");
                        $('#purchaseproducttable').html("");
                        $('#returntable').html("");

                        $('#invoice_number').val(res.invoice_number);
                        $('#id_factories').val(res.id_factories);
                        $('#id_currency').val(res.id_currency);
                        $('#payment').val(res.payment);
                        $('#tempo').val(res.tempo);
                        $('#date').val(res.date);


                        $('#PurchaseModalTitle').html("Purchase Details");
                        $('#PurchaseModal').modal('show');
                        $.each(res.purchasedetails, function(i, v){  

                            $.ajax({
                                type:"POST",
                                url: "{{ url('/dashboard/product/getbyid') }}",
                                data: { id: v.id_product },
                                dataType: 'json',
                                success: function(data){
                                    if($('#id_currency').val()==1){
                                        rate="display:none";
                                    }else{
                                        rate="display:block";
                                    }
                                    $('#carttable').append("<tr><td>"+v.id+'<input type="hidden" name="id" id="id_purchase_details" value="'+v.id+'">'+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity' value="+v.quantity+" placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;"+rate+"' id='rates' name='rates' value="+v.rates+" placeholder='Rates' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;' id='price' name='price' value="+v.price+" placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>"+v.total_idr+"</td></tr>");

                                    $('#carttable #quantity').each(function() {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#price').val() ){
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }

                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            quantity=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })
                                    
                                    $('#carttable #price').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            }

                                            if($('#id_currency').val()==1){
                                                rates=1;
                                            }else{
                                                if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                    rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                                }
                                            }
                                            price=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    $('#carttable #rates').each(function () {
                                        $(this).change(function () {
                                            var price=0;
                                            var quantity=0;
                                            var rates=0;

                                            if($(this).parent().parent().parent().parent().find('#quantity').val() && $(this).parent().parent().parent().parent().find('#price').val()){
                                                quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                                price=$(this).parent().parent().parent().parent().find('#price').val();
                                            }
                                            rates=$(this).val();
                                            $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                            checkTotalPayment();
                                        })
                                    })

                                    checkTotalPayment();

                                    

                                    
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                            
                        });

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                checkTotalCashback();

                
            }

            function addproduct(id) {

                var a=false;
                if(a){
                    $('#ProductModal').modal('hide');   
                }else{
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/dashboard/product/getbyid') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(data){
                            $('#ProductModal').modal('hide');

                            if($('#id_currency').val()==1){
                                rate="display:none";
                            }else{
                                rate="display:block";
                            }

                            $('#carttable').append("<tr><td>"+data.data.id+"</td><td><img class='img-row' src="+data.data.photo+"></span></td><td>"+data.data.type.name+"</td><td>"+data.data.size.width+"X"+data.data.size.height+"</td><td>"+data.data.weight.weight+"</td><td>"+data.data.grossweight.gross_weight+"</td><td>"+data.data.colour.name+"</td><td>"+data.data.logo.name+"</td><td>"+data.data.factories.name+"</td><td><div class='row'><div class='col-md-12' style='padding:2px'><input style='min-width:30px' type='number' class='form-control' style='color: black;' id='quantity' name='quantity'  placeholder='Qty' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><input type='number' class='form-control' style='color: black;"+rate+"' id='rates' name='rates' placeholder='Rates' min='1'><input type='number' class='form-control' style='color: black;' id='price' name='price' placeholder='Price' min='1'></div></div><div class='row'><div class='col-md-12' style='padding:2px'><a href='javascript:void(0)' onClick=deleteProduct("+data.data.id+") data-toggle='tooltip' data-original-title='detail' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a></div></div></td><td id='subtotal'>0</td></tr>");
                    
                                $('#carttable #quantity').each(function() {
                                    $(this).change(function () {
                                        var price=0;
                                        var quantity=0;
                                        var rates=0;

                                        if($(this).parent().parent().parent().parent().find('#price').val()){
                                            price=$(this).parent().parent().parent().parent().find('#price').val();
                                        }

                                        if($('#id_currency').val()==1){
                                            rates=1;
                                        }else{
                                            if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                            }
                                        }
                                        quantity=$(this).val();
                                        $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                        checkTotalPayment();
                                    })
                                })
                                
                                $('#carttable #price').each(function () {
                                    $(this).change(function () {
                                        var price=0;
                                        var quantity=0;
                                        var rates=0;

                                        if($(this).parent().parent().parent().parent().find('#quantity').val()){
                                            quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                        }
                                        if($('#id_currency').val()==1){
                                            rates=1;
                                        }else{
                                            if($(this).parent().parent().parent().parent().find('#rates').val() ){
                                                rates=$(this).parent().parent().parent().parent().find('#rates').val();
                                            }
                                        }
                                        price=$(this).val();
                                        $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                        checkTotalPayment();
                                    })
                                })

                                $('#carttable #rates').each(function () {
                                    $(this).change(function () {
                                        var price=0;
                                        var quantity=0;
                                        var rates=0;

                                        if($(this).parent().parent().parent().parent().find('#quantity').val() && $(this).parent().parent().parent().parent().find('#price').val()){
                                            quantity=$(this).parent().parent().parent().parent().find('#quantity').val();
                                            price=$(this).parent().parent().parent().parent().find('#price').val();
                                        }
                                        rates=$(this).val();
                                        $(this).parent().parent().parent().parent().find('#subtotal').html(price*quantity*rates);
                                        checkTotalPayment();
                                    })
                                })
                            
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
                
            }

            function checkTotalPayment() {
                var total_payment=0;
                $('#carttable tr').filter(function() {
                    var elm=this;

                    total_payment+= parseInt($(elm).children().eq(10).text()) ;
                    
                });
                $('#total_payment').html(total_payment);
            }

            function deleteProduct(id) {
                $("#carttable tr").filter(function() { 
                    var elm=this;

                    a=( $(elm).children().eq(0).text().toLowerCase().indexOf(id) > -1 );
                    if(a){
                        $(this).remove();
                    }
                });
            }
            $('#date').datepicker({ dateFormat: 'mm/dd/yyyy' });

            function getProduct(){
                $.ajax({
                    type:"GET",
                    url: "{{ url('/dashboard/product/addtocart') }}",
                    success: function(res){
                        $('#producttable').html(res.data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

            }


            $('#PurchaseForm').submit(function(e) {
                e.preventDefault();
                var obj=this;

                if($('#id').val()){
                    var quantityinput=true;
                    var priceinput=true;
                    $('#carttable #price').each(function () {
                        if(!$(this).val()){
                            priceinput=false;
                        }
                    })
                    $('#carttable #quantity').each(function () {
                        if(!$(this).val()){
                            quantityinput=false;
                        }
                    })
                    if(! $('#invoice_number').val()){
                        alert('Enter Invoice Number!');
                    }
                    else if($('#carttable').html()==""){
                        alert('Add Product First!');
                    }
                    else if(! quantityinput){
                        alert('Enter Quantity!');
                    }
                    else if(! priceinput){
                        alert('Enter Price!');
                    }
                    else{
                        var formData = new FormData(obj);
                        var body={};
                        formData.forEach(function(value, key){
                            body[key] = value;
                        }); 
                        body["total_payment_idr"]=$('#total_payment').html();
                        body["id"]=$('#id').val();
                        console.log($('#id').val());
                        body["details"]=[];

                        $('#carttable tr').each(function (index, element) {
                            var elm=this;
                            var product=new Array();

                            var cart={
                                'id_purchase' : $('#id').val(), 
                                'quantity': $(elm).children().eq(9).find('#quantity').val(),
                                'price': $(elm).children().eq(9).find('#price').val(),
                                'rates': $(elm).children().eq(9).find('#rates').val(),
                                'total': $(elm).children().eq(10).text()
                            };
                            cart['id_product'] = $(elm).children().eq(0).text();
                            cart["id_purchase_details"]=$(elm).children().eq(0).find('#id_purchase_details').val();
                            body.details.push(cart);
                            
                        });



                        $.ajax({
                            type:'POST',
                            url: "{{ url('/dashboard/purchase/edit')}}",
                            data: JSON.stringify(body),
                            contentType: "json",
                            processData: false,
                            cache:false,
                            success: (data) => {


                                $("#PurchaseModal").modal('hide');
                                getTables();
                                $("#btn-save").html('Submit');
                                $("#btn-save").attr("disabled", false);

                            },
                            error: function(data){
                                console.log(data);
                            }
                        }); 
                    }
                }else{
                    var quantityinput=true;
                    var priceinput=true;
                    $('#carttable #price').each(function () {
                        if(!$(this).val()){
                            priceinput=false;
                        }
                    })
                    $('#carttable #quantity').each(function () {
                        if(!$(this).val()){
                            quantityinput=false;
                        }
                    })

                    
                    if(! $('#invoice_number').val()){
                        alert('Enter Invoice Number!');
                    }
                    else if($('#carttable').html()==""){
                        alert('Add Product First!');
                    }
                    else if(! quantityinput){
                        alert('Enter Quantity!');
                    }
                    else if(! priceinput){
                        alert('Enter Price!');
                    }
                    else{
                        var formData = new FormData(this);
                        formData.append("total_payment_idr", $('#total_payment').html());




                        $.ajax({
                            type:'POST',
                            url: "{{ url('/dashboard/purchase/store')}}",
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                var id_purchase=data.id;
                                console.log(id_purchase);
                                $('#carttable tr').each(function (index, element) {
                                    var elm=this;
                                    var product=new Array();
                                    var form=new FormData();

                                    form.append('id_purchase', id_purchase);
                                    form.append('id_product', $(elm).children().eq(0).text());
                                    form.append('quantity', $(elm).children().eq(9).find('#quantity').val());
                                    form.append('price', $(elm).children().eq(9).find('#price').val());
                                    form.append('rates', $(elm).children().eq(9).find('#rates').val());
                                    form.append('total', $(elm).children().eq(10).text());
                                    $.ajax({
                                        type:'POST',
                                        url: "{{ url('/dashboard/purchase/store/product')}}",
                                        data: form,
                                        cache:false,
                                        contentType: false,
                                        processData: false,
                                        success: (data) => {
                                           
                                        },
                                        error: function(data){
                                            console.log(data);
                                        }
                                    }); 
                                });
                                $.ajax({
                                    type:'POST',
                                    url: "{{ url('/dashboard/purchase/jurnal')}}",
                                    data: { id_purchase: id_purchase },
                                    dataType: 'json',
                                    success: (data) => {
                                        
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                }); 

                                $("#PurchaseModal").modal('hide');
                                getTables();
                                $("#btn-save").html('Submit');
                                $("#btn-save").attr("disabled", false);

                            },
                            error: function(data){
                                console.log(data);
                            }
                        }); 
                    }
                }
                
            
               
            });

        </script>

    @endsection
        <!--body wrapper end-->
</x-app-layout>
