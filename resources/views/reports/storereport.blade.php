
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="col-md-12" style="display: flex;">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <form action="{{ route('reports.searchshop') }}" method="post">
                    @csrf

                    <select onchange="this.form.submit()" name="shop_id" id="select2-dropdown" class="form-control">
                        <option value="">Search by Shop</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->shop_no }}, {{ $shop->coverage_area }}</option>
                        @endforeach
                    </select>


                </form>
            </div>
            <div class="col-md-4">

            </div>
        </div>
        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">General Store Reports
                </h6>
            </div>
            <div class="card-body col-md-12" style="display: flex; color: #333;">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <th colspan="2" style="background-color: #02275f; color: white;">Factory Store Report</th>
                            <tr>
                                <th scope="row">Total Cost of Raw Materials Supplied</th>
                                <th>₦{{ number_format($data->sum('total_price'), 2) }}</th>
                            </tr>
                            <tr>
                                <th scope="row">Total Amount Paid to Suppliers</th>
                                <td>₦{{ number_format($data->sum('amount_paid'), 2) }}</td>
                            </tr>
                            <tr style="background-color: #c42929; color: white;">
                                <th scope="row">Total Remaining Balance</th>
                                <td>₦{{ number_format($data->sum('balance'), 2) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total Cost of Production</th>
                                <th>₦{{ number_format($production->sum('total_price'), 2) }}</th>
                            </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <th colspan="2" style="background-color: #02275f; color: white;">General Sales Report</th>
                            <tr>
                                <th scope="row">Total Sales</th>

                                <td>₦{{ number_format($sales->sum('total_amount'), 2) }}</td>
                            </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


        </div>
        <!-- Modal -->
        <div class="card" style="padding: 10px;">
            <h4 style="color: #333;">Net Profit: <span style="color: green;">₦{{ number_format($sales->sum('total_amount') -$production->sum('total_price'), 2) }}</span></h4>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

@include('layouts/footer')


<!-- Bootstrap core JavaScript-->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total1 = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                total2 = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                total3 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                pageTotal2 = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                pageTotal3 = api
                    .column(6, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                // Update footer
                $(api.column(4).footer()).html('₦' + parseFloat(pageTotal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $(api.column(5).footer()).html('₦' + parseFloat(pageTotal2, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $(api.column(6).footer()).html('₦' + parseFloat(pageTotal3, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

            },
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#select2-dropdown').select2();
        $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            $("#select2-dropdown").val(data);
        });
    });
</script>
<?php
