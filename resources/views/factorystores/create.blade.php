@extends('layouts/layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['factorystores.store']]) !!}
    @csrf
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Raw Materials to Store
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
                                <option value="{{ $rawmaterial->id }}"
                                    {{$rawmaterial->name}}>{{ $rawmaterial->name }}</option>

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
                                    <option value="{{ $unit->id }}"
                                        {{$unit->unit}}>{{ $unit->unit }}</option>
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
                            <input type="text" class="form-control" name="qty" id="qty" required/>
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
                                    <option value="{{ $supplier->id }}"
                                        {{$supplier->name}}>{{ $supplier->name }}</option>
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
                            <input type="text" class="form-control" name="unit_price" id="unit_price" required/>
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
                            {!! Form::date('date_of_supply', old('date_of_supply'), ['class' => 'form-control', 'placeholder' => '']) !!}
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
                                    <option value="{{ $paymentmethod->id }}"
                                        {{$paymentmethod->method}}>{{ $paymentmethod->method }}</option>
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
                            <input type="text" class="form-control" name="total_price" id="total_price" readonly/>
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
                            <input type="text" class="form-control" name="amount_paid" id="amount_paid" required/>
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
                            <input type="text" class="form-control" name="balance" id="balance" readonly />
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
                            {!! Form::text('remarks', old('remarks'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('remarks'))
                                <p class="help-block">
                                    {{ $errors->first('remarks') }}
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
                //to get unit price and total price
                $("#qty").keyup(function(){
                    un_price = ($("#unitprice").val());
                    $("#unit_price").val(un_price);
                    // $("#total_price").val(un_price * ($("#qty").val()))

                });
            });
        </script>
@stop


