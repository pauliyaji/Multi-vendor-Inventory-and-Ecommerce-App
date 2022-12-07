@extends('layouts/layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['shoptransactions.update', $data->id]]) !!}
    @csrf
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Shop Transaction
                    <a href="{{ route('shoptransactions.index') }}" class="btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('shop_id', 'Shop', ['class' => 'control-label']) !!}
                        <select class="form-control"
                                name="shop_id">
                            <option value="">Select Shop No.</option>
                            @foreach($shops as $shop)
                                <option id="shop" @if($data->shop_id==$shop->id) selected @endif
                                value="{{ $shop->id }}"
                                    {{$shop->shop_id}}>{{ $shop->shop_no }}, managed by {{ $shop->user->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('shop_id'))
                            <span class="text-danger text-left">{{ $errors->first('shop_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('product_id', 'Product', ['class' => 'control-label']) !!}
                        <select class="form-control"
                                name="product_id" id="checkQty" required>
                            <option value="">Select product</option>
                            @foreach($products as $product)
                                <option @if($data->product_id==$product->id) selected @endif
                                value="{{ $product->id }}"
                                    {{$product->name}}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('product_id'))
                            <span class="text-danger text-left">{{ $errors->first('product_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('qty', 'qty', ['class' => 'control-label']) !!}
                        <input type="text" class="form-control" value="{{ $data->qty }}" name="qty" id="qty" required/>
                        <p class="help-block"></p>
                        @if($errors->has('qty'))
                            <p class="help-block">
                                {{ $errors->first('qty') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('trxtype_id', 'Transaction Type', ['class' => 'control-label']) !!}
                        <select class="form-control"
                                name="trxtype_id" id="checkReturn">
                            <option value="">Select Transaction Type</option>
                            @foreach($trxtypes as $trxtype)
                                <option @if($data->trxtype_id==$trxtype->id) selected @endif
                                value="{{ $trxtype->id }}"
                                    {{$trxtype->type}}>{{ $trxtype->type }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('trxtype_id'))
                            <span class="text-danger text-left">{{ $errors->first('trxtype_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('date_of_trx', 'Date of Transaction', ['class' => 'control-label']) !!}
                        {!! Form::date('date_of_trx', $data->date_of_trx, ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('date_of_trx'))
                            <p class="help-block">
                                {{ $errors->first('date_of_trx') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-4 form-group">
                        {!! Form::submit('Save', ['class' => 'btn btn-danger btn-sm']) !!}
                    </div>
                </div>
            </div>
        </div>

    {!! Form::close() !!}
    @include('layouts/footer')
    <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
        <script>
            jQuery(document).ready(function(){

                jQuery('#checkQty').change(function(e){

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    var id = $("#checkQty").val();
                    //alert(id);

                    jQuery.ajax({
                        url: "http://localhost/water/public/stocks/checkqty/"+ id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                            //  console.log(response);
                            if(response.status == 200){
                                swal("Warning", 'Selected Product available quantity is '+response.data.qty, "warning");
                            }else{
                                swal("Error", 'Selected Product not available now ', "error");
                                $("form").submit(function (e) {
                                    swal("Error", 'Selected Product is not available now. Please refresh and make a diiferent request', "error");
                                    return false;
                                });
                            }

                        },
                        error: function(error){
                            console.log(error);

                        },
                    });

                });

            });
        </script>
@stop


