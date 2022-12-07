@extends('layouts/layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['barcodes.store']]) !!}
    @csrf
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Generate Production No. and Barcode
                    <a href="{{ route('barcodes.index') }}" class="btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('date_of_production', 'Date of production', ['class' => 'control-label']) !!}
                        {!! Form::date('date_of_production', old('date_of_production'), ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('date_of_production'))
                            <p class="help-block">
                                {{ $errors->first('date_of_production') }}
                            </p>
                        @endif
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 form-group">
                            {!! Form::label('product_id', 'Product', ['class' => 'control-label']) !!}
                            <select class="form-control" required
                                    name="product_id">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
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
                            {!! Form::label('output_qty', 'Batch Quantity', ['class' => 'control-label']) !!}
                            {!! Form::text('output_qty', old('output_qty'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('output_qty'))
                                <p class="help-block">
                                    {{ $errors->first('output_qty') }}
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

@stop


