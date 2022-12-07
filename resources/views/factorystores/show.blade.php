@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Raw Materials Supply
                    <a href="{{ url()->previous() }}" class="float-right btn btn-success btn-sm"> << Back</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th>Raw material</th>
                                <td>{{ $data->rawmaterial->name }}</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $data->suppliers->name }}</td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td>{{ $data->qty }}</td>
                            </tr>
                            <tr>
                                <th>Unit Price</th>
                                <td>{{ number_format($data->unit_price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>{{ number_format($data->total_price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Date of Supply</th>
                                <td>{{ $data->date_of_supply }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td>{{ $data->paymentstatus->status }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>{{ $data->paymentmethod->method }}</td>
                            </tr>
                            <tr>
                                <th>Amount Paid</th>
                                <td>{{ number_format($data->amount_paid, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Balance</th>
                                <td>{{ number_format($data->balance, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Attendant</th>
                                <td>{{ $data->users->name }}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>{{ $data->remarks }}</td>
                            </tr>

                        </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@include('layouts/footer')
<!-- Bootstrap core JavaScript-->

