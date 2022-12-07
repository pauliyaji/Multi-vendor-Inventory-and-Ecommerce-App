<div class="table-responsive">
    <table class="table table-bordered" id="dataTable">
        <thead style="background-color: #4e73df; color: white;">
        <tr>
            <th>#</th>
            <th>Shop</th>
            <th>Transaction No.</th>
            <th>Order No.</th>
            <th>Total Amount</th>
            <th>Amount Paid</th>
            <th>Balance</th>
            <th>Transaction Type</th>
            <th>Staff</th>

        </tr>
        </thead>

        <tbody>
        @if($data)
            @foreach($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->shops->shop_no }}</td>
                    <th>{{ $d->trx_no }}</th>
                    <td>{{ $d->order_id }}</td>
                    <th>{{ number_format($d->total_amount, 2) }}</th>
                    <td>{{ number_format($d->amount_paid, 2) }}</td>
                    @if($d->balance > 0)
                        <th style="background-color: #f74646; color: white">{{ number_format($d->balance, 2) }}</th>
                    @else
                        <th>{{ number_format($d->balance, 2) }}</th>
                    @endif
                    @if($d->trxtype_id == 1)
                        <th style="color: green;">{{ $d->trxtypes->type }}</th>
                    @elseif($d->trxtype_id == 2)
                        <th style="color: red;">{{ $d->trxtypes->type }}</th>
                    @endif
                    <td>
                        {{ $d->users->name }}
                    </td>

                </tr>
            @endforeach
        @endif
        </tbody>

        <tfoot style="background-color: #023054; color:white;">

        <tr >

            <th colspan="4" style="text-align: right;">TOTAL</th>
            <th style="text-align:center"></th>
            <th style="text-align:center"></th>
            <th style="text-align:center"></th>
            <th colspan="2"></th>


        </tr>
        </tfoot>
    </table>
</div>
