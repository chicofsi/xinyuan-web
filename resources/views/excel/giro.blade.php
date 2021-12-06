<table>
    <thead>
        <tr>
            <th><b>Date</b></th>
            <th><b>Bank</b></th>
            <th><b>Giro Number</b></th>
            <th><b>Balance</b></th>
            <th><b>Customer</b></th>
            <th><b>Invoice Number</b></th>
            <th><b>Status</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($giro as $data)
            <tr style="word-wrap:break-word">
                <td>{{ $data->date }}</td>
                <td>{{ $data->bank->name }}</td>
                <td>{{ $data->giro_number }}</td>
                <td>{{ $data->balance }}</td>
                <td>{{ $data->customer->company_name }}</td>
                <td>{{ $data->transaction->invoice_number }}</td>
                <td>{{ $data->status }}</td>
        @endforeach
    </tbody>
</table>
