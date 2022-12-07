@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $data->trx_no }}
                            <a href="{{ url()->previous() }}" class="float-right btn btn-success btn-sm">View All</a>

                        </h6>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                        @endif
                        <div class="table-responsive">
                            <form method="post" action="{{ route('storetrxs.index') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    @csrf
                                    <tr>
                                        <th>Transaction Number</th>
                                        <td>{{ $data->trx_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Raw Material</th>
                                        <td>{{ $data->rawmaterials->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Quantity</th>
                                        <td>{{ $data->qty }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit Price</th>
                                        <td>{{ $data->unit_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Price</th>
                                        <td>{{ $data->total_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Transaction</th>
                                        <td>{{ $data->date_of_trx }}</td>
                                    </tr>
                                    <tr>
                                        <th>Production No.</th>
                                        <td>{{ $data->barcodes->ptn_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approval Status</th>
                                        <td>{{ $data->approvalstatuses->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>{{ $data->remarks }}</td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@include('layouts/footer')
