@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Supplier
                    <a href="{{ route('suppliers.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('suppliers.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Name of Supplier</th>
                                <td><input type="text" class="form-control" value="{{ $data->name }}" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td><input type="text" class="form-control" value="{{ $data->phone }}" name="phone" id="phone"/></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control" value="{{ $data->address }}" name="address" id="address"/></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" class="form-control" value="{{ $data->email }}" name="email" id="email"/></td>
                            </tr>
                            <tr>
                                <th>Contact Person</th>
                                <td><input type="text" class="form-control" value="{{ $data->contact_person }}" name="contact_person" id="contact_person"/></td>
                            </tr>
                            <tr>
                                <th>rawmaterial</th>
                                <td>
                                    <select class="form-control"
                                            name="rawmaterial_id" required>
                                        <option value="">Select rawmaterials</option>
                                        @foreach($rawmaterials as $rawmaterial)
                                            <option @if($data->rawmaterial_id==$rawmaterial->id) selected @endif
                                            value="{{ $rawmaterial->id }}">{{ $rawmaterial->name }}</option>
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

