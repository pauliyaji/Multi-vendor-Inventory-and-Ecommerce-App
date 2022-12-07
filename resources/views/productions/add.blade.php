@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Production Raw Material Transaction
                    <a href="{{ url()->previous() }}" class="float-right btn btn-success btn-sm"> << Back</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('productions.store') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @foreach($data as $d)
                            <tr>
                                <th>Production No.</th>
                                <td><input type="text" class="form-control" value="{{ $d->barcodes->ptn_no }}" name="barcode_id[]" id="barcode_id" readonly/>
                                    @if ($errors->has('barcode_id'))
                                        <span class="text-danger text-left">{{ $errors->first('barcode_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr style="background-color: #023784; color: white;">
                                <th>Raw Material</th>
                                <td><input type="text" class="form-control" value="{{ $d->rawmaterials->name }}" name="rawmaterial_id[]" id="rawmaterial_id" readonly/>
                                    @if ($errors->has('rawmaterial_id'))
                                        <span class="text-danger text-left">{{ $errors->first('rawmaterial_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Quantity Collected</th>
                                <td><input type="text" class="form-control" value="{{ $d->qty }}" name="qty_collected[]" id="qty_collected" readonly/>
                                    @if ($errors->has('qty_collected'))
                                        <span class="text-danger text-left">{{ $errors->first('qty_collected') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Quantity Returned</th>
                                @if($d->trxtype_id == 1)
                                <td><input type="text" class="form-control" value="0" name="qty_returned[]" id="qty_returned" readonly/>
                                    @if ($errors->has('qty_returned'))
                                        <span class="text-danger text-left">{{ $errors->first('qty_returned') }}</span>
                                    @endif </td>
                                @else
                                    <input type="text" class="form-control" value="{{ $d->qty }}" name="qty_returned[]" id="qty_returned" readonly/>
                                    @if ($errors->has('qty_returned'))
                                        <span class="text-danger text-left">{{ $errors->first('qty_returned') }}</span>
                                        @endif </td>
                                @endif
                            </tr>

                            <tr>
                                <th>Quantity Used</th>
                                <td><input type="text" class="form-control" name="qty_used[]" id="qty_used"/>
                                    @if ($errors->has('qty_used'))
                                        <span class="text-danger text-left">{{ $errors->first('qty_used') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Waste</th>
                                <td><input type="text" class="form-control" name="waste[]" id="waste"/>
                                    @if ($errors->has('waste'))
                                        <span class="text-danger text-left">{{ $errors->first('waste') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Remarks</th>
                                <td><input type="remarks" class="form-control" name="remarks[]" id="remarks"/>
                                    @if ($errors->has('remarks'))
                                        <span class="text-danger text-left">{{ $errors->first('remarks') }}</span>
                                    @endif </td>
                            </tr>
                                <tr>
                                    <th>Date of Transaction</th>
                                    <td><input type="date" class="form-control" value="{{ $d->date_of_trx }}" name="date_of_trx[]" id="date_of_trx" readonly/>
                                        @if ($errors->has('date_of_trx'))
                                            <span class="text-danger text-left">{{ $errors->first('date_of_trx') }}</span>
                                        @endif </td>
                                </tr>
                            @endforeach

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

