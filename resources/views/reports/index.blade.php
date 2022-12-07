
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container">
        <button onclick="getPDF()" id="downloadbtn" style="display: inline-block;"><b>Click to Download PDF</b></button>

        <div class="canvas_div_pdf">
        <form action="{{ route('reports.searchdate') }}" method="post">
            @csrf
            <div class="row g-3">

                <div class="col-sm-7 m-1">
                    <select onchange="this.form.submit()" class="form-control" style="background: green; color: #FFF;"
                            name="date_id" id="select2-date">
                        <option value="" class="form-control">Filter by Date</option>
                        @foreach($datefilters as $date)
                            <option style="background: #0a58ca;" value="{{ $date->id }}">{{ $date->filter }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm m-1">
                    <button class="no-click form-control btn btn-success btn-sm"> @if($resultdate == '')
                            All Time
                        @elseif($resultdate)
                            {{ $resultdate->filter }}
                        @endif</button>
                </div>
                <div class="col-sm m-1">
                    <a href="{{ route('reports.index') }}"><button class="form-control btn btn-primary btn-sm float-right" aria-label="RefreshPage">
                            Refresh Page
                        </button></a>
                </div>

            </div>
        </form>

        <!-- Page Heading -->

        <div class="col-md-12 col-xs-12 shadow mb-4">
            <div class="py-3 mb-4">
                <h4 class="m-0 font-weight-bold text-primary float-left" style="color: #333; text-align: center;">General Status Report Summary </h4>
                <h4 class="float-right m-0 font-weight-bold" style="color: #0a9b0d; text-align: center;">Net Profit: ₦{{ number_format($sales->sum('total_amount') - $total_stocks, 2) }}</h4>
            </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md">
                            <div class="card bg-light text-dark">
                                <div class="card-header" style="background-color: #02275f; color: white; margin:0;">
                                    <h4 class="card-title mb-1">
                                        Factory Financial Status
                                    </h4>
                                </div>
                                <div class="card-body text-left" style="color: #1a1e21;">
                                    <p class="card-text">
                                    <div class="row" style="margin: 10px;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color:#757373;">Total Cost of Raw Materials Supplied</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($data->sum('total_price'), 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color:#757373;">Total Amount Paid to Suppliers</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($data->sum('amount_paid'), 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px; padding: 10px; background-color: #d45757;; color: white;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold;">Total Remaining Balance</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold;" >₦{{ number_format($data->sum('balance'), 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color:#757373;">Total Cost of Raw Materials Used in Production</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($production->sum('total_price'), 2) }}</h6>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="card bg-light text-dark">
                                <div class="card-header" style="background-color: #02275f; color: white; margin:0;">
                                    <h4 class="card-title mb-1">
                                        General Sales Report
                                    </h4>
                                </div>
                                <div class="card-body text-left" style="color: #1a1e21;">
                                    <p class="card-text">
                                    <div class="row" style="margin: 10px;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color:#757373;">Total Cost of All Stocks Produced</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($total_stocks, 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color:#757373;">Total Cost of Stocks Collected</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($stocks->sum('total_price'), 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px; padding: 10px; background-color: #d45757;; color: white;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold;">Cost of Stocks Returned</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold;">₦{{ number_format($stocksRet->sum('total_price'), 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color:#757373;">Total Sales</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($sales->sum('total_amount'), 2) }}</h6>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 10px; padding: 10px; background-color: #d45757; color: white;">
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold;">Total Sales Returned</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="font-weight: bold;">₦{{ number_format($salesreturned->sum('total_amount'), 2) }}</h6>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="card bg-light text-dark">
                                <div class="card-header" style="background-color: #024a04; color: white; margin:0;">
                                    <h4 class="card-title mb-1">
                                        Products Production Report
                                    </h4>
                                </div>
                                <div class="card-body text-left p-0 m-0" style="color: #1a1e21;">
                                    <p class="card-text">
                                    @foreach($production as $ptn)
                                        <div class="row" style="margin: 10px;">
                                            <div class="col-md-3">
                                                <h6 style="font-weight: bold; color:#757373;">{{ $ptn->products->name }}</h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 style="font-weight: bold; color: #0a9b0d;">{{ $ptn->total_qty }} nos.</h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($ptn->total_price, 2) }}</h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 style="font-weight: bold; color:#757373;">{{ $ptn->date_of_ptn }}</h6>
                                            </div>
                                        </div>

                                        @endforeach
                                        </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="card bg-light text-dark">
                                <div class="card-header" style="background-color: #024a04; color: white; margin:0;">
                                    <h4 class="card-title mb-1">
                                        General Shop Sales Report
                                    </h4>
                                </div>
                                <div class="card-body text-left" style="color: #1a1e21;">
                                    <p class="card-text">
                                    @foreach($shopsales as $shop)
                                        <div class="row" style="margin: 10px;">
                                            <div class="col-md-6">
                                                <h6 style="font-weight: bold; color:#757373;">{{ $shop->shops->shop_no }}, {{ $shop->shops->coverage_area }}</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($shop->total_amount) }}</h6>
                                            </div>
                                        </div>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        <!-- Modal -->
        <div class="card" style="padding: 10px;">
            <h4 style="font-weight: bold; color: #333;">Net Profit: <span style="font-weight: bold; color: green;">₦{{ number_format($sales->sum('total_amount') -$total_stocks, 2) }}</span></h4>
        </div>
    </div>
    </div>
    <!-- /.container-fluid -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

@include('layouts/footer')


<!-- Bootstrap core JavaScript-->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
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

    $(document).ready(function () {
        $('#select2-date').select2();
        $('#select2-date').on('change', function (e) {
            var data = $('#select2-date').select2("val");
            $("#select2-date").val(data);
        });
    });

    {{--Print HTML DIV to PDF--}}
    function getPDF(){

        var HTML_Width = $(".canvas_div_pdf").width();
        var HTML_Height = $(".canvas_div_pdf").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width+(top_left_margin*2);
        var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


        html2canvas($(".canvas_div_pdf")[0],{allowTaint:true}).then(function(canvas) {
            canvas.getContext('2d');

            console.log(canvas.height+"  "+canvas.width);


            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);


            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            }

            pdf.save("HTML-Document.pdf");
        });
    }
</script>




{{--
//SUBMITING A FORM ONCHANGE
<div class="col-md-4">
    <form action="{{ route('reports.searchshop') }}" method="post">
        @csrf
        <select onchange="this.form.submit()" style="background: #009966; color: #FFF;" name="date_id" id="select2-date" class="form-control">
            <option value="">Filter by Date</option>
            @foreach($datefilters as $date)
                <option style="background: #0a58ca;" value="{{ $date->id }}">{{ $date->filter }}</option>
            @endforeach
        </select>
    </form>
</div>--}}
