<table>
    <thead>
        <tr>
            <th><b>Factory</b></th>
            <th><b>Invoice Number</b></th>
            <th><b>Date</b></th>
            <th><b>Product</b></th>
            <th><b>Product Quantity</b></th>
            <th><b>Product Price</b></th>
            <th><b>SubTotal</b></th>
            <th><b>Rates</b></th>
            <th><b>SubTotal in IDR</b></th>
            <th><b>Total Payment in IDR</b></th>
            <th><b>Payment Paid</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchase as $data)
            <tr style="word-wrap:break-word">
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->factories->name }}</td>
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->invoice_number }}</td>
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->date }}</td>
                @foreach ($data->transactiondetails as $details)
                    @if($details != $data->transactiondetails->first())
                    <tr>
                    @endif
                    <td>{{$details->product_name}}</td>
                    <td>{{$details->quantity}}</td>
                    <td>{{$details->price}}</td>
                    <td>{{$details->total}}</td>
                    <td>{{$details->rates}}</td>
                    <td>{{$details->total_idr}}</td>
                    @if($details == $data->transactiondetails->first())
                        <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->total_payment_idr }}</td>
                        <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->paid_idr }}</td>
                    @endif
                    </tr>
                @endforeach
        @endforeach
    </tbody>
</table>
