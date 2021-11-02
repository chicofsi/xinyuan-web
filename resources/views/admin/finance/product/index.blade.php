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
            Products
        </h3>
        <div class="state-info">

            <a href="#AddProductModal" data-toggle="modal" onclick="add()" class=" btn btn-primary ">Create New Product <i class="fa fa-plus"></i></a>
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
                                <a href="#products" data-toggle="tab">Products</a>
                            </li>
                            <li class="">
                                <a href="#warehouses" data-toggle="tab">Warehouses</a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="products">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="product">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Product Code
                                                </th>
                                                <th>
                                                    Product Name
                                                </th>
                                                <th>
                                                    Qty
                                                </th>
                                                <th>
                                                    Unit
                                                </th>
                                                <th style="text-align: right;">
                                                    Last Buy Price
                                                </th>
                                                <th style="text-align: right;">
                                                    Buy Price
                                                </th>
                                                <th style="text-align: right;">
                                                    Sell Price
                                                </th>
                                                <th>
                                                    Category
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (empty($products->products))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($products->products as $val)
                                                <tr>
                                                    <td>
                                                        {{$val->product_code}}
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('dashboard/finance/product/')."/".$val->id }}">{{$val->name}}</a>
                                                    </td>
                                                    <td>
                                                        {{$val->quantity}} 
                                                    </td>
                                                    <td>
                                                        {{$val->unit->name}} 
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{$val->last_buy_price_currency_format}} 
                                                    </td>                                                    
                                                    <td style="text-align: right;">
                                                        {{$val->buy_price_per_unit_currency_format}} 
                                                    </td>                                  
                                                    <td style="text-align: right;">
                                                        {{$val->sell_price_per_unit_currency_format}} 
                                                    </td>                                  
                                                    <td>
                                                        {{$val->product_categories}} 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            
                            <div class="tab-pane" id="warehouses">
                                <div class="adv-table">
                                    <div class="row">
                                        <div class="col-md-8" style="padding: 10px">
                                        </div>
                                        <div class="col-md-4" style="padding: 10px">
                                            <label style="float: right; width: 100%">Search: <input id="searchbar" type="text" class="form-control" name=""></label>
                                        </div>
                                    </div>
                                    <table  class="display table table-hover " id="warehouse">
                                        <thead>
                                            <tr>
                                                <th>
                                                    code
                                                </th>
                                                <th>
                                                    Product Name
                                                </th>
                                                <th>
                                                    Address
                                                </th>
                                                <th>
                                                    Description
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (empty($warehouses->warehouses))
                                                <tr>
                                                    <td colspan="6">
                                                        No Items
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($warehouses->warehouses as $val)
                                                <tr>
                                                    <td>
                                                        {{$val->code}}
                                                    </td>
                                                    <td>
                                                        {{$val->name}}
                                                    </td>
                                                    <td>
                                                        {{$val->address}} 
                                                    </td>
                                                    <td>
                                                        {{$val->description}} 
                                                    </td>  
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </div>

                        </div>
                    </div>
                    <div aria-hidden="true" role="dialog"  id="AddProductModal" class="modal fade">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form role="form" id="AddProductForm" name="AddProductForm">

                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"  id="AddProductModalTitle">Form Title</h4>
                                    </div>
                                    <div class="modal-body" style="background-color: #eff0f4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">Product Info</div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="p-info">
                                                            <li>
                                                                <div class="title">Name*</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="name" name="name" placeholder="Product Name">
                                                            </li>
                                                            <li>
                                                                <div class="title">Code / SKU</div>
                                                                <input type="text" class="form-control desk" style="color: black;" id="code" name="code" >
                                                            </li>
                                                            <li>
                                                                <div class="title">Unit</div>
                                                                
                                                                <select class="desk form-control" id="unit" style="color: black;" name="unit" >
                                                                    @foreach ($units->product_units as $val)
                                                                        <option value="{{$val->name}}">{{$val->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <div class="title">Description</div>
                                                                
                                                                <textarea class="desk form-control" id="description" name="description" rows="3"></textarea>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">Price & Setting</div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="panel">
                                                            <div class="panel-heading">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="buy" > I Buy This Item
                                                                </label>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <h5>Buy Unit Price</h5>
                                                                        <input type="number" class="form-control desk" style="color: black;" id="buy_price" name="buy_price"  value="0" min="0">
                                                                        
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h5>Buy Account</h5>
                                                                        <select class="desk form-control" id="buyaccount" style="color: black;" name="buyaccount" >
                                                                            @foreach ($buyaccountcost->accounts as $val)
                                                                                <option value="{{$val->number}}">{{"(".$val->number.") ".$val->name}}</option>
                                                                            @endforeach
                                                                            @foreach ($buyaccountfix->accounts as $val)
                                                                                <option value="{{$val->number}}">{{"(".$val->number.") ".$val->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h5>Default Tax</h5>
                                                                        <select class="desk form-control" id="buytaxes" style="color: black;" name="buytaxes" >
                                                                            <option value=""></option>
                                                                            @foreach ($taxes->company_taxes as $val)
                                                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="panel">
                                                            <div class="panel-heading">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="sell" > I Sell This Item
                                                                </label>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <h5>Sell Unit Price</h5>
                                                                        <input type="number" class="form-control desk" style="color: black;" id="sell_price" name="sell_price" value="0" min="0">
                                                                        
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h5>Sell Account</h5>
                                                                        <select class="desk form-control" id="sellaccount" style="color: black;" name="sellaccount" >
                                                                            @foreach ($sellaccountincome->accounts as $val)
                                                                                <option value="{{$val->number}}">{{"(".$val->number.") ".$val->name}}</option>
                                                                            @endforeach
                                                                            @foreach ($sellaccountother->accounts as $val)
                                                                                <option value="{{$val->number}}">{{"(".$val->number.") ".$val->name}}</option>
                                                                            @endforeach
                                                                            @foreach ($sellaccountar->accounts as $val)
                                                                                <option value="{{$val->number}}">{{"(".$val->number.") ".$val->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h5>Default Tax</h5>
                                                                        <select class="desk form-control" id="selltaxes" style="color: black;" name="selltaxes" >
                                                                            <option value=""></option>

                                                                            @foreach ($taxes->company_taxes as $val)
                                                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-submit" class="btn btn-success " style="display: inline !important;">Add</button>
                                    </div>

                                </form>
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

            });
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

            $('#AddProductForm').submit(function(e) {

                e.preventDefault();
                isBuy=$('#buy').is(":checked");
                isSell=$('#sell').is(":checked");

                if(!$('#name').val()){
                    alert("Insert Name!");
                }else{
                    var form=new FormData();


                    form.append("name",$("#name").val());
                    form.append("description",$("#description").val());
                    form.append("is_bought",isBuy);
                    form.append("is_sold",isSell);
                    form.append("product_code",$("#code").val());
                    form.append("sell_price_per_unit",$("#sell_price").val());
                    form.append("buy_price_per_unit",$("#buy_price").val());
                    form.append("sell_tax_id",$("#selltaxes").val());
                    form.append("buy_tax_id",$("#buytaxes").val());
                    form.append("unit_name",$("#unit").val());
                    form.append("buy_account_number",$("#buyaccount").val());
                    form.append("sell_account_number",$("#sellaccount").val());

                    $.ajax({
                        type:'POST',
                        url: "{{ url('/dashboard/finance/product')}}",
                        data: form,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            location.reload();
                            $("#AddContactModal").modal('hide');
                        },
                        error: function(data){
                            console.log(data);
                        }
                    }); 
                }
            
               
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



