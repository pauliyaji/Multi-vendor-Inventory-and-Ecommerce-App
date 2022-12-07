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
                        <h6 class="m-0 font-weight-bold text-primary">{{ $role->name }}
                            <a href="{{ route('roles.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                        </h6>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                        @endif
                        <div class="table-responsive">
                            <form method="post" action="{{ route('roles.index') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    @csrf
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $role->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Assigned permissions</th>
                                        <td>
                                        <table class="table table-striped">
                                            <thead>
                                            <th scope="col" width="20%">Name</th>
                                            <th scope="col" width="1%">Guard</th>
                                            </thead>

                                            @foreach($rolePermissions as $permission)
                                                <tr>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>{{ $permission->guard_name }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        </td>
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
