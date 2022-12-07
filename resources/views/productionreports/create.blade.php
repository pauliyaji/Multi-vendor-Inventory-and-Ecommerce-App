@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Production
                    <a href="{{ route('productionreports.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('productionreports.store') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            <tr>
                                <th>Product</th>
                                <td>
                                    <select class="form-control"
                                            name="product_id" required>
                                        <option value="">Select product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{$product->name}}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product_id'))
                                        <span class="text-danger text-left">{{ $errors->first('product_id') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Production Number</th>
                                <td>
                                    <select class="form-control"
                                            name="barcode_id" id="ajaxSubmit">
                                        <option value="">Select Production Number</option>
                                        @foreach($barcodes as $barcode)
                                            <option value="{{ $barcode->id }}"
                                                {{$barcode->id }}>{{ $barcode->ptn_no }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('barcode_id'))
                                        <span class="text-danger text-left">{{ $errors->first('barcode_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Total Qty</th>
                                <td><input type="text" class="form-control" name="total_qty" id="total_qty"/></td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td><input type="text" class="form-control" name="total_price" id="total_price"/></td>
                            </tr>
                            <tr>
                                <th>Date of Production</th>
                                <td><input type="date" class="form-control" name="date_of_ptn" id="date_of_ptn"/></td>
                            </tr>
                            <tr>
                                <th>Production Status</th>
                                <td>
                                    <select class="form-control"
                                            name="status" id="ajaxSubmit">
                                        <option value="">Select Production Status</option>
                                        @foreach($productionstatuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{$status->id }}>{{ $status->status }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                                    @endif </td>                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td><input type="text" class="form-control" name="remarks" id="remarks"/></td>
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
                url: "http://localhost/water/public/productionreports/rawmatprice/"+ id,
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    console.log(response);
                   // var xyz = sum(response.data.total_price);
                    $('#total_price').val(response.data);
                    $('#qty')
                },
                error: function(error){
                    console.log(error);
                },
            });
        });
    });
</script>
