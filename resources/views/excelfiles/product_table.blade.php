<div class="table-responsive">
    <table class="table table-bordered" id="dataTable">
        <thead style="background-color: #024604; color: white;">
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Total Qty Produced</th>
            <th>Total Cost of production</th>
            <th>Date of Production</th>
            <th>Remarks</th>
            <th>Staff</th>
        </tr>
        </thead>
        <tbody>
        @if($data)
            @foreach($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->products->name }}</td>
                    <td>{{ $d->sum('total_qty') }}</td>
                    <td>{{ number_format($d->sum('total_price'), 2) }}</td>
                    <td>{{ $d->date_of_ptn }}</td>
                    <td>{{ $d->remarks }}</td>
                    <td>{{ $d->users->name }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot style="background-color: #023054; color:white;">
        <tr>
            <th colspan="3" style="text-align: right;">Total Production Cost</th>
            <th> </th>
            <th></th>
            <th></th>
            <th></th>

        </tr>
        </tfoot>
    </table>
</div>
