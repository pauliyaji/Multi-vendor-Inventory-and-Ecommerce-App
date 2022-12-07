@extends('layouts/layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['rawmaterials.store']]) !!}
    @csrf
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Raw material
                    <a href="{{ route('rawmaterials.index') }}" class="btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('name', 'Name of Raw Material', ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 form-group">
                            {!! Form::label('unit_of_measure_id', 'Units', ['class' => 'control-label']) !!}

                            <select class="form-control"
                                    name="unit_of_measure_id" required>
                                <option value="">Select units</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{$unit->unit}}>{{ $unit->unit }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('unit_of_measure_id'))
                                <span class="text-danger text-left">{{ $errors->first('unit_of_measure_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 form-group">
                            {!! Form::label('unit_price', 'Unit Price', ['class' => 'control-label']) !!}
                            {!! Form::text('unit_price', old('unit_price'), ['class' => 'form-control', 'placeholder' => '']) !!}
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
                            {!! Form::label('re_order', 'Re-Order Level', ['class' => 'control-label']) !!}
                            {!! Form::text('re_order', old('re_order'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('re_order'))
                                <p class="help-block">
                                    {{ $errors->first('re_order') }}
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


