<table>
    <thead>
        <tr>
            <th><b>Company</b></th>
            <th><b>Invoice Number</b></th>
            <th><b>Customer</b></th>
            <th><b>Sales Name</b></th>
            <th><b>Date</b></th>
            <th><b>Product</b></th>
            <th><b>Product Quantity</b></th>
            <th><b>Product Price</b></th>
            <th><b>SubTotal</b></th>
            <th><b>Total</b></th>
            <th><b>Payment Paid</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction as $data)
            <tr style="word-wrap:break-word">
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->company->display_name }}</td>
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->invoice_number }}</td>
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->customer->company_name }}</td>
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->sales->name }}</td>
                <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->date }}</td>
                @foreach ($data->transactiondetails as $details)
                    @if($details != $data->transactiondetails->first())
                    <tr>
                    @endif
                    <td>{{$details->product_name}}</td>
                    <td>{{$details->quantity}}</td>
                    <td>{{$details->price}}</td>
                    <td>{{$details->total}}</td>
                    @if($details == $data->transactiondetails->first())
                        <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->total_payment }}</td>
                        <td rowspan="{{$data->transactiondetails->count()}}">{{ $data->paid }}</td>
                    @endif
                    </tr>
                @endforeach
        @endforeach
    </tbody>
</table>
