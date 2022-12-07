@extends('layouts/layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['factorystores.update', $data->id]]) !!}
    @csrf
    @method('patch')
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Raw Materials
                    <a href="{{ route('factorystores.index') }}" class="btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('rawmaterials_id', 'Raw Material', ['class' => 'control-label']) !!}
                        <select class="form-control" required
                                name="rawmaterial_id">
                            <option value="">Select rawmaterials</option>
                            @foreach($rawmaterials as $rawmaterial)
                                <option @if($data->rawmaterial_id==$rawmaterial->id) selected @endif
                                value="{{ $rawmaterial->id }}">{{ $rawmaterial->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('rawmaterials_id'))
                            <span class="text-danger text-left">{{ $errors->first('rawmaterials_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('units_id', 'Units', ['class' => 'control-label']) !!}
                        <select class="form-control"
                                name="units_id">
                            <option value="">Select units</option>
                            @foreach($units as $unit)
                                <option @if($data->units_id==$unit->id) selected @endif
                                value="{{ $unit->id }}">{{ $unit->unit }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('units_id'))
                            <span class="text-danger text-left">{{ $errors->first('units_id') }}</span>
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
                        {!! Form::label('supplier_id', 'Supplier', ['class' => 'control-label']) !!}
                        <select class="form-control" required
                                name="supplier_id">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option @if($data->supplier_id==$supplier->id) selected @endif
                                value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('supplier_id'))
                            <span class="text-danger text-left">{{ $errors->first('supplier_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('unit_price', 'Unit Price', ['class' => 'control-label']) !!}
                        <input type="text" class="form-control" value="{{ $data->unit_price }}" name="unit_price" id="unit_price" required/>
                        <p class="help-block"></p>
                        @if($errors->has('unit_price'))
                            <p class="help-block">
                                {{ $errors->first('unit_price') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('date_of_supply', 'Date of supply', ['class' => 'control-label']) !!}
                        {!! Form::date('date_of_supply', $data->date_of_supply, ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('date_of_supply'))
                            <p class="help-block">
                                {{ $errors->first('date_of_supply') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('paymentmethod_id', 'Supplier', ['class' => 'control-label']) !!}
                        <select class="form-control" required
                                name="paymentmethod_id">
                            <option value="">Select Payment Method</option>
                            @foreach($paymentmethods as $paymentmethod)
                                <option @if($data->paymentmethod_id==$paymentmethod->id) selected @endif
                                value="{{ $paymentmethod->id }}">{{ $paymentmethod->method }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('paymentmethod_id'))
                            <span class="text-danger text-left">{{ $errors->first('paymentmethod_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('total_price', 'Total Price', ['class' => 'control-label']) !!}
                        <input type="text" class="form-control" name="total_price" value="{{ $data->total_price }}" id="total_price" readonly/>
                        <p class="help-block"></p>
                        @if($errors->has('total_price'))
                            <p class="help-block">
                                {{ $errors->first('total_price') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('amount_paid', 'Amount Paid to Supplier', ['class' => 'control-label']) !!}
                        <input type="text" class="form-control" value="{{ $data->amount_paid }}" name="amount_paid" id="amount_paid" required/>
                        <p class="help-block"></p>
                        @if($errors->has('amount_paid'))
                            <p class="help-block">
                                {{ $errors->first('amount_paid') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('balance', 'Balance', ['class' => 'control-label']) !!}
                        <input type="text" class="form-control" value="{{ $data->balance }}" name="balance" id="balance" readonly />
                        <p class="help-block"></p>
                        @if($errors->has('balance'))
                            <p class="help-block">
                                {{ $errors->first('balance') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('remarks', 'Remarks', ['class' => 'control-label']) !!}
                        {!! Form::text('remarks', $data->remarks, ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('remarks'))
                            <p class="help-block">
                                {{ $errors->first('remarks') }}
                            </p>
                        @endif
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 form-group" style="background: #0a9b0d; color:white;">
                            {!! Form::label('new_payment', 'Make additional payment', ['class' => 'control-label']) !!}
                            <input type="text" class="form-control" value="{{ $data->new_payment }}" name='new_payment' id="new_payment"/>
                            <p class="help-block"></p>
                            @if($errors->has('new_payment'))
                                <p class="help-block">
                                    {{ $errors->first('new_payment') }}
                                </p>
                            @endif
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-12 col-xs-4 form-group">
                        {!! Form::submit('Update', ['class' => 'btn btn-danger btn-sm']) !!}
                    </div>
                </div>
            </div>
        </div>

    {!! Form::close() !!}
    @include('layouts/footer')
    <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script>
            $(document).ready(function(){
                var oldpay = ($("#amount_paid").val());
                var total_price = ($("#total_price").val());
                var oldbalance = ($("#balance").val());
                $("#new_payment").keyup(function(){
                    var newpay = ($("#new_payment").val());
                    var total_paid = (+oldpay) + (+newpay);
                    //console.log(total_paid);
                    $("#amount_paid").val(total_paid);


                    newbalance = oldbalance - newpay;
                    // console.log(newpay);
                    $("#balance").val(newbalance);

                });
            });
        </script>
@stop


