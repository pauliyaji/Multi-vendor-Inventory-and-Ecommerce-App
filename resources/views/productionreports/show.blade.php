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
                        <h6 class="m-0 font-weight-bold text-primary">Production No. {{ $data->barcodes->ptn_no }}
                            <a href="{{ route('productionreports.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                        </h6>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                        @endif
                        <div class="table-responsive">
                            <form method="post" action="{{ route('productionreports.index') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    @csrf
                                    <tr>
                                        <th>Batch No.</th>
                                        <td>{{ $data->barcodes->ptn_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product</th>
                                        <td>{{ $data->products->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Qty</th>
                                        <td>{{ $data->total_qty }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Price</th>
                                        <td>{{ number_format($data->total_price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Production</th>
                                        <td>{{ $data->date_of_ptn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Attendant</th>
                                        <td>{{ $data->users->name }}</td>
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
