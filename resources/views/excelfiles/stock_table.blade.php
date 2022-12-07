<div class="table-responsive">
    <table class="table table-bordered" id="dataTable">
        <thead style="background-color: #024604; color: white;">
        <tr>
            <th>#</th>
            <th>Transaction No.</th>
            <th>Shop No.</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Total Price</th>
            <th>Date of Transaction</th>
            <th>Transaction Type</th>
            <th>Staff</th>


        </tr>
        </thead>

        <tbody>
        @if($data)
            @foreach($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->trx_no}}</td>
                    <td>{{ $d->shops->shop_no }}</td>
                    <td>{{ $d->products->name }}</td>
                    <td>{{ $d->qty }}</td>
                    @if($d->total_price == null)
                        <th>{{ number_format(0, 2) }}</th>
                    @else
                        <th>{{ number_format($d->total_price, 2) }}</th>
                    @endif
                    <td>{{ $d->date_of_trx }}</td>
                    <td>
                        @if($d->trxtype_id == 1)
                            <span class="text-success text-left">{{ $d->trxtypes->type }}</span>
                        @else
                            <span class="text-danger text-left">{{ $d->trxtypes->type }}</span>
                        @endif
                    </td>
                    <td>{{ $d->user->name }}</td>

                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot style="background-color: #023054; color:white;">
        <tr>
            <th colspan="5" style="text-align: right;">Total Item Cost</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>


        </tr>
        </tfoot>
    </table>
</div>
