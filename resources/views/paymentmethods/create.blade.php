@extends('layouts/layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['paymentmethods.store']]) !!}
    @csrf
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Payment Method
                    <a href="{{ route('paymentmethods.index') }}" class="btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="row">
                    <div class="col-md-12 col-xs-12 form-group">
                        {!! Form::label('method', 'Method', ['class' => 'control-label']) !!}
                        {!! Form::text('method', old('method'), ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('method'))
                            <p class="help-block">
                                {{ $errors->first('method') }}
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


