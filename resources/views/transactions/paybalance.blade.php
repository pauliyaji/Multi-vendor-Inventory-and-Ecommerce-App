@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Raw Materials
                    <a href="{{ route('factorystores.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('transactions.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')

                            <tr>
                                <th>Transaction No.</th>
                                <td><input type="text" class="form-control" value="{{ $data->trx_no }}" name="trx_no" id="trx_no" readonly/>
                            </tr>
                            <tr>
                                <th>Order ID.</th>
                                <td><input type="text" class="form-control" value="{{ $data->order_id }}" name="order_id" id="order_id" readonly/>
                            </tr>
                            <tr>
                                <th>Amount Paid</th>
                                <td><input type="text" class="form-control" value="{{ $data->amount_paid }}" name="amount_paid" id="amount_paid" readonly/>
                            </tr>

                            <tr>
                                <th>Balance</th>
                                <td><input type="text" class="form-control" value="{{ $data->balance }}" name="balance" id="balance" readonly/>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td><input type="text" class="form-control" value="{{ $data->total_amount }}" name="total_amount" id="total_amount" readonly/>
                            </tr>
                            <tr>
                                <th>Amount to Pay</th>
                                <td><input type="text" class="form-control" value="{{ $data->amount_to_pay }}" name="amount_to_pay" id="amount_to_pay" />
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
        var oldpay = ($("#amount_paid").val());
        var total_amount = ($("#total_amount").val());
        var oldbalance = ($("#balance").val());
        $("#amount_to_pay").keyup(function(){
            var newpay = ($("#amount_to_pay").val());
            var total_paid = (+oldpay) + (+newpay);
            //console.log(total_paid);
            $("#amount_paid").val(total_paid);


            newbalance = oldbalance - newpay;
            // console.log(newpay);
            $("#balance").val(newbalance);

        });
    });
</script>
