@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Supplier
                    <a href="{{ route('suppliers.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('suppliers.store') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            <tr>
                                <th>Name of Supplier</th>
                                <td><input type="text" class="form-control" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td><input type="text" class="form-control" name="phone" id="phone"/></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control" name="address" id="address"/></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" class="form-control" name="email" id="email"/></td>
                            </tr>
                            <tr>
                                <th>Contact Person</th>
                                <td><input type="text" class="form-control" name="contact_person" id="contact_person"/></td>
                            </tr>
                            <tr>
                                <th>Rawmaterial</th>
                                <td>
                                <select class="form-control"
                                        name="rawmaterial_id" required>
                                    <option value="">Select rawmaterials</option>
                                    @foreach($rawmaterials as $rawmaterial)
                                        <option value="{{ $rawmaterial->id }}"
                                            {{$rawmaterial->name}}>{{ $rawmaterial->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('rawmaterial_id'))
                                    <span class="text-danger text-left">{{ $errors->first('rawmaterial_id') }}</span>
                                @endif </td>
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

