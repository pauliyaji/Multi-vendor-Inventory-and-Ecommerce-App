@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Return Item
                    <a href="{{ route('orderdetails.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('orderdetails.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Product Name</th>
                                <td><input type="text" class="form-control" value="{{ $data->products->name }}" name="name" id="name"/></td>
                            </tr>
                            <tr>
                                <th>Qty</th>
                                <td><input type="text" class="form-control" value="{{ $data->qty }}" name="qty" id="qty"/></td>
                            </tr>
                            <tr>
                                <th>Return Qty</th>
                                <td><input type="text" class="form-control" name="returnQty" id="returnQty"/></td>
                            </tr>
                            <tr>
                                <th>Selling Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->unitprice }}" name="unitprice" id="unitprice"/></td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->amount }}" name="amount" id="amount"/></td>
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
<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function(){
        $("#returnQty").keyup(function(){
            retQty = $('#returnQty').val();
            orgQty = $('#qty').val();
            if(retQty < orgQty){
                total = ($("#returnQty").val()) * ($("#unitprice").val());
                $("#amount").val(total);
            }else{
                $("#retQty").val('0');
                swal("Error", 'You can not return more than you bought', "error");

            }

        });

    });
</script>

