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
                    <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" class="form-control" value="{{ $user->email }}" name="email" id="email"/></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" class="form-control" value="{{ $user->phone }}" name="phone" id="phone"/></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input type="password" class="form-control" name="password" id="password"/></td>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <td><img src="{{ asset('storage/app/public/imgs/'.$user->photo) }}" height="200px" weight="200px"></td>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <td><input type="file" name="photo" id="photo" /></td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>
                                    <select class="form-control"
                                            name="state_id" required>
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option @if($user->state_id==$state->id) selected @endif
                                            value="{{ $state->id }}">{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="text-danger text-left">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control" value="{{ $user->address }}" name="address" id="address"/></td>
                            </tr>
                            <tr>
                                <th>Next of Kin (NOK)</th>
                                <td><input type="text" class="form-control" value="{{ $user->nok_name }}"  placeholder="Full Name" name="nok_name" id="nok_name"/></td>
                            </tr>
                            <tr>
                                <th>NOK Phone</th>
                                <td><input type="text" class="form-control" value="{{ $user->nok_phone }}" name="nok_phone" id="nok_phone"/></td>
                            </tr>
                            <tr>
                                <th>Relationship with NOK</th>
                                <td><input type="text" class="form-control" value="{{ $user->nok_address }}" name="nok_address" id="nok_address"/></td>
                            </tr>
                            <tr>
                                <th>CV</th>
                                <td>
                                <textarea class="form-control" name="cv">{{ $user->cv }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Salary</th>
                                <td><input type="text" class="form-control" value="{{ $user->salary }}" name="salary" id="salary"/></td>
                            </tr>
                            <tr>
                                <th>Date of Engagement</th>
                                <td><input type="date" class="form-control" value="{{ $user->date_of_engagement }}" name="date_of_engagement" id="date_of_engagement"/></td>
                            </tr>
                            <tr>
                                <th>Health Info</th>
                                <td><input type="text" value="{{ $user->health_info }}" class="form-control" name="health_info" id="health_info"/></td>
                            </tr>
                            <tr>
                                <th>Coverage Area</th>
                                <td><input type="text" class="form-control" value="{{ $user->coverage_area }}" name="coverage_area" id="coverage_area"/></td>
                            </tr>

                            <tr>
                                <th>Role</th>
                                <td>
                                    <select class="form-control"
                                            name="role" required>
                                        <option value="">Select role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ in_array($role->name, $userRole)
                                                    ? 'selected'
                                                    : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" class="btn btn-primary btn-sm" />                                </td>
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

