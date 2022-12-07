<div class="table-responsive">
    <table class="table table-bordered" id="dataTable">
        <thead style="background-color: #024604; color: white;">
        <tr>
            <th>#</th>
            <th>Raw material</th>
            <th>Supplier</th>
            <th>Qty</th>
            <th>Total price</th>
            <th>Amount Paid</th>
            <th>Balance Owed</th>
            <th>Date of Supply</th>
            <th>Staff</th>

        </tr>
        </thead>

        <tbody>
        @if($data)
            @foreach($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->rawmaterial->name }}</td>
                    <td>{{ $d->suppliers->name }}</td>
                    <td>{{ $d->qty }}</td>
                    <td>{{ number_format($d->total_price, 2) }}</td>
                    <td>{{ number_format($d->amount_paid, 2)}}</td>
                    @if($d->balance > 0)
                        <td style="background-color: #f74646; color: white">{{ number_format($d->balance, 2)}}</td>
                    @else
                        <td>{{ number_format($d->balance, 2)}}</td>
                    @endif
                    <td>{{ $d->date_of_supply }}</td>
                    <td>{{ $d->users->name }}</td>

                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot style="background-color: #023054; color:white;">
        <tr>

            <th colspan="4"style="text-align: right;">Total Supply</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>


        </tr>
        </tfoot>
    </table>
</div>
