@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create a New Shop
                    <a href="{{ route('shops.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('shops.index') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf

                           {{-- <tr>
                                <th>Shop No.</th>
                                <td><input type="text" class="form-control" value="{{ $data->shop_no }}" name="shop_no" id="shop_no" readonly /></td>
                            </tr>--}}
                            <tr>
                                <th>Staff</th>
                                <td>
                                    <select class="form-control" disabled
                                            name="user_id">
                                        <option value="">Select Staff</option>
                                        @foreach($users as $user)
                                            <option @if($data->user_id==$user->id) selected @endif
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="text-danger text-left">{{ $errors->first('user_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" class="form-control" value="{{ $data->phone }}" name="phone" id="phone" readonly /></td>
                            </tr>

                            <tr>
                                <th>Coverage Area</th>
                                <td><input type="text" class="form-control" value="{{ $data->coverage_area }}" name="coverage_area" id="coverage_area" readonly/></td>
                            </tr>
                            <tr>
                                <th>Date of Engagement</th>
                                <td><input type="text" class="form-control" value="{{ $data->date_of_engagement }}" name="date_of_engagement" id="date_of_engagement" readonly/></td>
                            </tr>
                            <tr>
                                <th>Shop Status</th>
                                <td>
                                    <select class="form-control"
                                            name="status_id">
                                        <option value="">Select Status</option>
                                        @foreach($statuses as $status)
                                            <option @if($data->status==$status->id) selected @endif
                                            value="{{ $status->id }}">{{ $status->status }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function(){
        $("#unit_price").keyup(function(){
            total = ($("#qty").val()) * ($("#unit_price").val());
            //console.log(total);
            $("#total_price").val(total);
            $("#amount_paid").keyup(function(){
                balance = total - ($("#amount_paid").val());
                $("#balance").val(balance);
            });
        });
    });
</script>
