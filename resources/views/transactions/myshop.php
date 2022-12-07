
@extends('layouts/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Transactions
            </h6>
        </div>
        <div class="card-body">

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
                        <th>Action</th>

                    </tr>
                    </thead>
                    {{-- <tfoot style="background-color: #023054; color:white;">
                    <tr>
                        <th style="text-align: right;"></th>

                        <th>Total Amount: {{ number_format($data->sum('total_amount'), 2) }}</th>
                        <th>Total Amount Paid: {{ number_format($data->sum('amount_paid'), 2) }}</th>
                        <th>Total Remaining Balance: {{ number_format($data->sum('balance'), 2) }}</th>
                        <th colspan="4" style="text-align:right">Total:</th>
                        <th></th>


                    </tr>
                    </tfoot>--}}
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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: #0606a4;">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('invoices.show', $d->order_id) }}"><i class="fa fa-eye"></i> View</a></li>
                                    <li><a class="dropdown-item" href="{{ route('invoices.receipt', $d->order_id) }}"><i class="fa fa-list"></i> Receipt</a></li>
                                    @if($d->trxtype_id == 1)
                                    <li><a class="dropdown-item" href="{{ route('pos.edit', $d->id) }}"><i class="fa fa-eye"></i> Click to Return</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transactions.returns') }}"><i class="fa fa-undo"></i> Sales Return</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="#"><i class="fa fa-trash"></i> Delete</a></li>
                                </ul>
                            </div>
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
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="import" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

@include('layouts/footer')


<!-- Bootstrap core JavaScript-->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total1 = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                total2 = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                total3 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                pageTotal2 = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                pageTotal3 = api
                    .column(6, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                // Update footer
                $(api.column(4).footer()).html('₦' + parseFloat(pageTotal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $(api.column(5).footer()).html('₦' + parseFloat(pageTotal2, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $(api.column(6).footer()).html('₦' + parseFloat(pageTotal3, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());


            },
        });
    });
</script>
