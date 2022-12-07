@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Raw Materials to Store
                    <a href="{{ route('factorystores.index') }}" class="float-right btn btn-success btn-sm">View All</a>

                </h6>
            </div>
            <div class="card-body">

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="post" action="{{ route('factorystores.store') }}" enctype="multipart/form-data">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            @csrf
                            <tr>
                                <th>Raw Material</th>
                                <td><input type="text" class="form-control" value="{{ $data->name }}" name="rawmaterial_id" id="rawmaterial_id" /></td>
                                @if ($errors->has('rawmaterial_id'))
                                    <span class="text-danger text-left">{{ $errors->first('rawmaterial_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Unit of Measure</th>
                                <td><input type="text" class="form-control" value="{{ $data->units->unit }}" name="unit_id" id="unit_id" /></td>
                                @if ($errors->has('unit_id'))
                                    <span class="text-danger text-left">{{ $errors->first('unit_id') }}</span>
                                    @endif </td>
                            </tr>

                            <tr>
                                <th>Quantity</th>
                                <td><input type="text" class="form-control" name="qty" id="qty"/>
                                    @if ($errors->has('qty'))
                                        <span class="text-danger text-left">{{ $errors->first('qty') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>
                                    <select class="form-control"
                                            name="supplier_id">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{$supplier->name}}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('supplier_id'))
                                        <span class="text-danger text-left">{{ $errors->first('supplier_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Unit Price</th>
                                <td><input type="text" class="form-control" name="unit_price" id="unit_price" /></td>
                                @if ($errors->has('unit_price'))
                                    <span class="text-danger text-left">{{ $errors->first('unit_price') }}</span>
                                    @endif </td>
                            </tr>
                            {{--  <tr>
                                  <th>Payment Status</th>
                                  <td>
                                      <select class="form-control"
                                              name="paymentstatus_id" required>
                                          <option value="">Select Supplier</option>
                                          @foreach($paymentstatuses as $paymentstatus)
                                              <option value="{{ $paymentstatus->id }}"
                                                  {{$paymentstatus->status}}>{{ $paymentstatus->status }}</option>
                                          @endforeach
                                      </select>
                                      @if ($errors->has('paymentstatus_id'))
                                          <span class="text-danger text-left">{{ $errors->first('paymentstatus_id') }}</span>
                                      @endif </td>
                              </tr>--}}
                            <tr>
                                <th>Date of Supply</th>
                                <td><input type="date" class="form-control" name="date_of_supply" id="date_of_supply"/>
                                    @if ($errors->has('date_of_supply'))
                                        <span class="text-danger text-left">{{ $errors->first('date_of_supply') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>
                                    <select class="form-control"
                                            name="paymentmethod_id">
                                        <option value="">Select Payment Method</option>
                                        @foreach($paymentmethods as $paymentmethod)
                                            <option value="{{ $paymentmethod->id }}"
                                                {{$paymentmethod->method}}>{{ $paymentmethod->method }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('paymentmethod_id'))
                                        <span class="text-danger text-left">{{ $errors->first('paymentmethod_id') }}</span>
                                    @endif </td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td><input type="text" class="form-control" name="total_price" id="total_price" readonly/></td>
                            </tr>
                            <tr>
                                <th>Amount Paid to Supplier</th>
                                <td><input type="text" class="form-control" name="amount_paid" id="amount_paid"/>
                                    @if ($errors->has('amount_paid'))
                                        <span class="text-danger text-left">{{ $errors->first('amount_paid') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Balance</th>
                                <td><input type="text" class="form-control" name="balance" id="balance" readonly /></td>
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
        //to get unit price and total price
        $("#qty").keyup(function(){
            un_price = ($("#unitprice").val());
            $("#unit_price").val(un_price);
            // $("#total_price").val(un_price * ($("#qty").val()))

        });
    });
</script>
