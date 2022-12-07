@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add User
                    <a href="{{ route('users.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text" class="form-control" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" class="form-control" name="email" id="email"/></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" class="form-control" name="phone" id="phone"/></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input type="password" class="form-control" name="password" id="password"/></td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>
                                    <select class="form-control"
                                            name="state_id" required>
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}"
                                                {{$state->state}}>{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="text-danger text-left">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Photo</th>
                                <td><input type="file" name="photo" id="photo" /></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control" name="address" id="address"/></td>
                            </tr>
                            <tr>
                                <th>Next of Kin</th>
                                <td><input type="text" class="form-control" placeholder="Full Name" name="nok_name" id="nok_name"/></td>
                            </tr>
                            <tr>
                                <th>NOK Phone</th>
                                <td><input type="text" class="form-control" name="nok_phone" id="nok_phone"/></td>
                            </tr>
                            <tr>
                                <th>NOK Address</th>
                                <td><input type="text" class="form-control" name="nok_address" id="nok_address"/></td>
                            </tr>
                            <tr>
                                <th>CV</th>
                                <td>
                                <textarea class="form-control" name="cv" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Salary</th>
                                <td><input type="text" class="form-control" name="salary" id="salary"/></td>
                            </tr>
                            <tr>
                                <th>Date of Engagement</th>
                                <td><input type="date" class="form-control" name="date_of_engagement" id="date_of_engagement" required/></td>
                            </tr>
                            <tr>
                                <th>Health Info</th>
                                <td><input type="text" class="form-control" name="health_info" id="health_info"/></td>
                            </tr>
                            <tr>
                                <th>Coverage Area</th>
                                <td><input type="text" class="form-control" name="coverage_area" id="coverage_area" required/></td>
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

