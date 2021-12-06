<table>
    <thead>
        <tr>
            <th><b>Company</b></th>
            <th><b>Invoice Number</b></th>
            <th><b>Customer</b></th>
            <th><b>Sales Name</b></th>
            <th><b>Date</b></th>
            <th><b>Payment Account</b></th>
            <th><b>Payment Paid</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payment as $data)
            <tr style="word-wrap:break-word">
                <td>{{ $data->transaction->company->display_name }}</td>
                <td>{{ $data->transaction->invoice_number }}</td>
                <td>{{ $data->transaction->customer->company_name }}</td>
                <td>{{ $data->transaction->sales->name }}</td>
                <td>{{ $data->date }}</td>
                <td>{{ $data->paymentaccount->bank->name." - ".$data->paymentaccount->account_name." - ".$data->paymentaccount->account_number }}</td>
                <td>{{$data->paid}}</td>
        @endforeach
    </tbody>
</table>
