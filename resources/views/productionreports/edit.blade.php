@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Production
                    <a href="{{ route('productionreports.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('productionreports.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Product</th>
                                <td>
                                    <select class="form-control"
                                            name="product_id">
                                        <option value="">Select Raw Material</option>
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
                                <th>Production Number</th>
                                <td>
                                    <select class="form-control"
                                            name="barcode_id" id="ajaxSubmit">
                                        <option value="">Select Batch Number</option>
                                        @foreach($barcodes as $barcode)
                                            <option @if($data->ptn_no==$barcode->id) selected @endif
                                            value="{{ $barcode->id }}">{{ $barcode->ptn_no }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('barcode_id'))
                                        <span class="text-danger text-left">{{ $errors->first('barcode_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Total Qty</th>
                                <td><input type="text" class="form-control" value="{{ $data->total_qty }}" name="total_qty" id="total_qty" readonly/></td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->total_price }}" name="total_price" id="total_price" readonly /></td>
                            </tr>
                            <tr>
                                <th>Date of Production</th>
                                <td><input type="date" class="form-control" value="{{ $data->date_of_ptn }}" name="date_of_ptn" id="date_of_ptn"/></td>
                            </tr>
                            <tr>
                                <th>Production Status</th>
                                <td>
                                    <select class="form-control"
                                            name="status" id="ajaxSubmit">
                                        <option value="">Select Production Status </option>
                                        @foreach($productionstatuses as $status)
                                            <option @if($data->status==$status->id) selected @endif
                                            value="{{ $status->id }}"
                                                {{$status->id }}>{{ $status->status }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td><input type="text" class="form-control" value="{{ $data->remarks }}" name="remarks" id="remarks"/></td>
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
                },
                error: function(error){
                    console.log(error);
                },
            });
        });
    });
</script>
