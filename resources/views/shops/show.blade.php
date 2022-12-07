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
                        <h6 class="m-0 font-weight-bold text-primary">Shop No. {{ $data->shop_no }}
                            <a href="{{ route('shops.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                        </h6>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                        @endif
                        <div class="table-responsive">
                            <form method="post" action="{{ route('shops.index') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    @csrf
                                    <tr>
                                        <th>Shop No.</th>
                                        <td>{{ $data->shop_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Staff</th>
                                        <td>{{ $data->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $data->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Coverage Area</th>
                                        <td>{{ $data->coverage_area }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Engagement</th>
                                        <td>{{ $data->date_of_engagement }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shop Status</th>
                                        @if($data->status == '1')
                                            <td><button type="button" class="btn btn-success btn-sm">{{ $data->statuses->status }}</button></td>
                                        @else
                                            <td><button type="button" class="btn btn-danger btn-sm">{{ $data->statuses->status }}</button></td>
                                        @endif
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
