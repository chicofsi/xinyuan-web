<table>
    <thead>
        <tr>
            <th><b>Invoice Number</b></th>
            <th><b>Date Returned</b></th>
            <th><b>Cashback</b></th>
            <th><b>Product</b></th>
            <th><b>Product Quantity</b></th>
            <th><b>Product Cashback</b></th>
            <th><b>Total Cashback</b></th>
            <th><b>Note</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($refund as $data)
            <tr style="word-wrap:break-word">
                <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->invoice_number }}</td>
                <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->date }}</td>
                <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->cashback }}</td>
                @if(!isset($data->transactionreturn))
                    <td colspan="3">No Product Returned</td>
                    <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->total_cashback }}</td>
                    <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->note }}</td>
                    </tr>
                @else
                    @foreach ($data->transactionreturn as $details)
                        @if($details != $data->transactionreturn->first())
                        <tr>
                        @endif
                        <td>{{$details->product_name}}</td>
                        <td>{{$details->qty}}</td>
                        <td>{{$details->total_refund}}</td>
                        @if($details == $data->transactionreturn->first())
                            <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->total_cashback }}</td>
                            <td rowspan="{{$data->transactionreturn->count()}}">{{ $data->note }}</td>
                        @endif
                        </tr>
                    @endforeach
                @endif
        @endforeach
    </tbody>
</table>
