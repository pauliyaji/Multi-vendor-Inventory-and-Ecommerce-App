@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">New Raw Material Store Transaction
                    <a href="{{ url()->previous() }}" class="float-right btn btn-primary btn-sm" style="margin-left: 5px;"> >> Back </a>

                    <a href="{{ route('storetrxs.index') }}" class="float-right btn btn-success btn-sm">View Raw Material Transaction Report</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('storetrxs.store') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            <tr>
                                <th>Raw Material</th>
                                <td>
                                    <select class="form-control"
                                            name="rawmaterial_id">
                                        <option value="">Select Raw Material</option>
                                        @foreach($rawmaterials as $rawmaterial)
                                            <option id="item" value="{{ $rawmaterial->id }}"
                                                {{$rawmaterial->rawmaterial_id}}>{{ $rawmaterial->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rawmaterial_id'))
                                        <span class="text-danger text-left">{{ $errors->first('rawmaterial_id') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Quantity</th>
                                <td><input type="text" class="form-control" name="qty" id="qty"/>
                                    @if ($errors->has('qty'))
                                        <span class="text-danger text-left">{{ $errors->first('qty') }}</span>
                                    @endif </td>
                            </tr>
                         {{--   <tr>
                                <th>Unit Price</th>
                                <td><input type="text" class="form-control" name="unit_price" id="unit_price" readonly/></td>
                                @if ($errors->has('unit_price'))
                                    <span class="text-danger text-left">{{ $errors->first('unit_price') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td><input type="text" class="form-control" name="total_price" id="total_price" readonly/></td>
                            </tr>--}}

                            <tr>
                                <th>Date of Transaction</th>
                                <td><input type="date" class="form-control" name="date_of_trx" id="date_of_trx"/>
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
                                            <option value="{{ $barcode->id }}"
                                                {{$barcode->ptn_no }}>{{ $barcode->ptn_no }}</option>
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
                                            <option value="{{ $trxtype->id }}"
                                                {{$trxtype->type}}>{{ $trxtype->type }}</option>
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
                                            <option value="{{ $approvalstatus->id }}"
                                                {{$approvalstatus->status }}>{{ $approvalstatus->status  }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('approvalstatus_id'))
                                        <span class="text-danger text-left">{{ $errors->first('approvalstatus_id') }}</span>
                                    @endif </td>
                            </tr>

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
       /* //to get unit price and total price
        $("#qty").keyup(function(){
            un_price = ($("#unitprice").val());
            $("#unit_price").val(un_price);
            $("#total_price").val(un_price * ($("#qty").val()))

        });*/
    });
</script>
