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
                        <h6 class="m-0 font-weight-bold text-primary">{{ $data->name }}
                            <a href="{{ route('users.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                        </h6>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                        @endif
                        <div class="table-responsive">
                            <form method="post" action="{{ route('users.index') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    @csrf
                                    <tr>
                                        <th>Photo</th>
                                        <td><img src="{{ asset('/storage/app/public/imgs/'.$data->photo) }}" height="200px" weight="200px"></td>
                                    </tr>
                                    <tr>
                                        <th>Full Name</th>
                                        <td>{{ $data->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $data->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $data->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>State of Origin</th>
                                        <td>{{ $data->states->state }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $data->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>CV</th>
                                        <td>{{ $data->cv }}</td>
                                    </tr>
                                    <tr>
                                        <th>Salary</th>
                                        <td>{{ $data->salary }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Engagement</th>
                                        <td>{{ $data->date_of_engagement }}</td>
                                    </tr>
                                    <tr>
                                        <th>Next of Kin</th>
                                        <td>{{ $data->nok_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Relationship with Next of Kin</th>
                                        <td>{{ $data->nok_rel }}</td>
                                    </tr>
                                    <tr>
                                        <th>Next of Kin Phone</th>
                                        <td>{{ $data->nok_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Coverage Area</th>
                                        <td>{{ $data->coverage_area }}</td>
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
