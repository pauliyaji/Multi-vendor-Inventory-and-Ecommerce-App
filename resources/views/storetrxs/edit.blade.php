@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Raw Material Store Transaction
                    <a href="{{ route('storetrxs.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('storetrxs.update', $data->id) }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            @method('patch')
                            <tr>
                                <th>Transaction No.</th>
                                <td><input type="text" class="form-control" value="{{ $data->trx_no }}" name="trx_no" id="trx_no" readonly /></td>
                            </tr>
                            <tr>
                                <th>Raw Material</th>
                                <td>
                                    <select class="form-control"
                                            name="rawmaterial_id">
                                        <option value="">Select Raw Material</option>
                                        @foreach($rawmaterials as $rawmaterial)
                                            <option @if($data->rawmaterial_id==$rawmaterial->id) selected @endif
                                            value="{{ $rawmaterial->id }}">{{ $rawmaterial->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rawmaterial_id'))
                                        <span class="text-danger text-left">{{ $errors->first('rawmaterial_id') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Quantity</th>
                                <td><input type="text" class="form-control" value="{{ $data->qty }}" name="qty" id="qty"/>
                                    @if ($errors->has('qty'))
                                        <span class="text-danger text-left">{{ $errors->first('qty') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Unit Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->unit_price }}" name="unit_price" id="unit_price"/></td>
                                @if ($errors->has('unit_price'))
                                    <span class="text-danger text-left">{{ $errors->first('unit_price') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td><input type="text" class="form-control" value="{{ $data->total_price }}" name="total_price" id="total_price" readonly/></td>
                            </tr>

                            <tr>
                                <th>Date of Transaction</th>
                                <td><input type="date" class="form-control" value="{{ $data->date_of_trx }}" name="date_of_trx" id="date_of_trx"/>
                                    @if ($errors->has('date_of_trx'))
                                        <span class="text-danger text-left">{{ $errors->first('date_of_trx') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Production Number</th>
                                <td>
                                    <select class="form-control"
                                            name="barcode_id">
                                        <option value="">Select Production Number</option>
                                        @foreach($barcodes as $barcode)
                                            <option @if($data->barcode_id==$barcode->id) selected @endif
                                            value="{{ $barcode->id }}">{{ $barcode->ptn_no }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('barcode_id'))
                                        <span class="text-danger text-left">{{ $errors->first('barcode_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Transaction Type</th>
                                <td>
                                    <select class="form-control"
                                            name="trxtype_id">
                                        <option value="">Select Transaction Type</option>
                                        @foreach($trxtypes as $trxtype)
                                            <option @if($data->trxtype_id==$trxtype->id) selected @endif
                                            value="{{ $trxtype->id }}">{{ $trxtype->type }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('trxtype_id'))
                                        <span class="text-danger text-left">{{ $errors->first('trxtype_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Approval Status</th>
                                <td>
                                    <select class="form-control"
                                            name="approvalstatus_id">
                                        <option value="">Select Approval Status </option>
                                        @foreach($approvalstatuses as $approvalstatus)
                                            <option @if($data->approvalstatus_id==$approvalstatus->id) selected @endif
                                            value="{{ $approvalstatus->id }}">{{ $approvalstatus->status }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('approvalstatus_id'))
                                        <span class="text-danger text-left">{{ $errors->first('approvalstatus_id') }}</span>
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
    });
</script>
