@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Customers
                    <a href="{{ route('customers.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('customers.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text" class="form-control" value="{{ $data->name }}" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control" value="{{ $data->address }}" name="address" id="address"/></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" class="form-control" value="{{ $data->phone }}" name="phone" id="phone"/></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" class="form-control" value="{{ $data->email }}" name="email" id="email"/></td>
                            </tr>
                              <tr>
                                  <th>Total Purchases</th>
                                  <td><input type="text" class="form-control" value="{{ $data->total_purchases }}" readonly name="total_purchase" id="total_purchase"/></td>
                              </tr>
                              <tr>
                                  <th>Total Returns</th>
                                  <td><input type="text" class="form-control" value="{{ $data->total_returns }}" readonly name="total_returns" id="total_returns"/></td>
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

