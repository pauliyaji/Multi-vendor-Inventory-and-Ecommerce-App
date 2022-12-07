@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Stocks
                    <a href="{{ route('stocks.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('stocks.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Product</th>
                                <td>
                                    <select class="form-control" disabled
                                            name="product_id">
                                        <option value="">Product</option>
                                        @foreach($products as $product)
                                            <option @if($data->product_id==$product->id) selected @endif
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product_id'))
                                        <span class="text-danger text-left">{{ $errors->first('product_id') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Total Qty</th>
                                <td><input type="text" class="form-control" value="{{ $data->qty }}" name="qty" id="total_qty" readonly/></td>
                            </tr>
                            <tr>
                                <th>Cost Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->cost_price }}" name="cost_price" id="cost_price" /></td>
                            </tr>
                            <tr>
                                <th>Selling Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->selling_price }}" name="selling_price" id="selling_price"/></td>
                            </tr>
                            <tr>
                                <th>Alert Quantity</th>
                                <td><input type="text" class="form-control" value="{{ $data->alert_qty }}" name="alert_qty" id="alert_qty"/></td>
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
    jQuery(document).ready(function(){

        jQuery('#ajaxSubmit').change(function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var id = $("#ajaxSubmit").val();
            // alert(prinew);

            jQuery.ajax({
                url: "http://localhost/water/public/stocks/rawmatprice/"+ id,
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    // var xyz = sum(response.data.total_price);
                    $('#total_price').val(response.data);
                },
                error: function(error){
                    console.log(error);
                },
            });
        });
    });
</script>
