@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add User
                    <a href="{{ route('roles.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('roles.update', $role->id) }}">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @method('patch')
                            @csrf
                            <tr>
                                <th>Name</th>
                                <td><input type="text" class="form-control" value="{{ $role->name }}" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Assign Permissions</th>
                                <td>
                                <table class="table table-striped">
                                    <thead>
                                    <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                                    <th scope="col" width="20%">Name</th>
                                    <th scope="col" width="1%">Guard</th>
                                    </thead>

                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox"
                                                       name="permission[{{ $permission->name }}]"
                                                       value="{{ $permission->name }}"
                                                       class='permission'
                                                    {{ in_array($permission->name, $rolePermissions)
                                                        ? 'checked'
                                                        : '' }}>
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" class="btn btn-primary btn-sm" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@include('layouts/footer')
<!-- Bootstrap core JavaScript-->

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });
        });
    </script>
@endsection
