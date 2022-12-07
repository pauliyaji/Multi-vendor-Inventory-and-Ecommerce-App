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
                        <h6 class="m-0 font-weight-bold text-primary">Stock View
                            <a href="{{ route('stocks.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                        </h6>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                        @endif
                        <div class="table-responsive">
                            <form method="post" action="{{ route('stocks.index') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    @csrf
                                    <tr>
                                        <th>Product Name</th>
                                        <td>{{ $data->products->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Quantity</th>
                                        <td>{{ $data->qty }}</td>
                                    </tr>
                                    <tr>
                                        <th>SKU</th>
                                        <td>  <div class="card">
                                                <p class="name">Hope Bassey Water Company</p>
                                                {!! DNS1D::getBarcodeHTML($data->products->name, "C128",1.4,22) !!}
                                                <p class="pid">{{$data->sku }}</p>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <th>Cost Price</th>
                                        <td>{{ $data->cost_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Selling Price</th>
                                        <td>{{ $data->selling_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alert Quantity</th>
                                        <td>{{ $data->alert_qty }}</td>
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
