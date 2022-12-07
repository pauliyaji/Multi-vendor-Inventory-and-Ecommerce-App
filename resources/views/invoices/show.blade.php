
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Receipt No. {{ $invoice_no->trx_no }}
                    <a href="{{ url()->previous() }}" class="float-right btn btn-primary btn-sm" style="margin-left:10px;"><< Back</a>

                    <a href="{{ route('invoices.receipt', $invoice_no->order_id) }}" class="float-right btn btn-success btn-sm">Print Invoice</a>
                </h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background-color: #4e73df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Discount(%)</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right;">Total Amount</th>
                            <th>{{ number_format($transaction->total_amount, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Amount Paid</th>
                            <th>{{ number_format($transaction->amount_paid, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Balance</th>
                            <th>{{ number_format($transaction->balance, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Transaction Type</th>
                            <th>
                                @if($transaction->trxtype_id == 1)
                                    <button class="btn btn-success btn-sm">{{ $transaction->trxtypes->type }}</button>
                                @else
                                    <button class="btn btn-danger btn-sm">{{ $transaction->trxtypes->type }}</button>
                                    @endif
                            </th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if($order_receipt)
                            @foreach($order_receipt as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->products->name }}</td>
                                    <td>{{ $d->qty }}</td>
                                    <td>{{ number_format($d->unitprice,2) }}</td>
                                    @if($d->discount == '')
                                        <td>0</td>
                                    @else
                                    <td>{{ $d->discount }}</td>
                                    @endif
                                        <td>{{ number_format($d->amount,2) }}</td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>

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

