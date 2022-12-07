
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Shop Sales and Sales Returned Summary
                </h6>
            </div>
            <div class="card-body">

                <div class="row" style="display: flex;">
                    <div class="card col-md-6" style="margin: 0; padding: 0;">
                        <div class="card-header" style="background-color: #024a04; color: white; margin:0;">
                            <h6 style="font-weight: bold;">All Shop Sales Report</h6>
                        </div>
                        @foreach($data as $shop)
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold;">{{ $shop->shops->shop_no }}, {{ $shop->shops->coverage_area }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold;">₦{{ number_format($shop->total_amount) }}</h6>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="card col-md-6" style="margin: 0; padding: 0;">
                        <div class="card-header" style="background-color: #bc0505; color: white; margin:0;">
                            <h6 style="font-weight: bold;">All Shop Sales Returned Report</h6>
                        </div>
                        @foreach($data2 as $shop)
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold;">{{ $shop->shops->shop_no }}, {{ $shop->shops->coverage_area }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold;">₦{{ number_format($shop->total_amount) }}</h6>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
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
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Total over this page
                pageTotal = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(3).footer()).html('₦' + parseFloat(pageTotal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());



            },
        });
    });
</script>
