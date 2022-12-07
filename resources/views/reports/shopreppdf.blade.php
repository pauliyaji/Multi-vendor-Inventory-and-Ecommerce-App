
<div class="col-md-12 col-xs-12 shadow mb-4">

    <div class="py-3 mb-4">
        <h4 class="m-0 font-weight-bold text-primary float-left" style="color: #333; text-align: center;">General Shop Summary </h4>
        <h4 class="float-right m-0 font-weight-bold" style="color: #0a9b0d; text-align: center;">Net Profit: ₦{{ number_format($sales->sum('total_amount') - $stocks->sum('total_price'), 2) }}</h4>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md">
                <div class="card bg-light text-dark">
                    <div class="card-header" style="background-color: #02275f; color: white; margin:0;">
                        <h4 class="card-title mb-1">
                            Stocks Financial Status
                        </h4>
                    </div>
                    <div class="card-body text-left" style="color: #1a1e21;">
                        <p class="card-text">
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
                                <h6 style="font-weight: bold;">Total Cost of Stocks Returned</h6>
                            </div>
                            <div class="col-md-6">
                                <h6 style="font-weight: bold;" >₦{{ number_format($stocksRet->sum('total_price'), 2) }}</h6>
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
                            General Shop Sales Report
                        </h4>
                    </div>
                    <div class="card-body text-left" style="color: #1a1e21;">
                        <p class="card-text">
                        <div class="row" style="margin: 10px;">
                            <div class="col-md-6">
                                <h6 style="font-weight: bold; color:#757373;">Total Sales</h6>
                            </div>
                            <div class="col-md-6">
                                <h6 style="font-weight: bold; color: #0a9b0d;">₦{{ number_format($sales->sum('total_amount'), 2) }}</h6>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px; padding: 10px; background-color: #d45757;; color: white;">
                            <div class="col-md-6">
                                <h6 style="font-weight: bold;">Total Sales Returned</h6>
                            </div>
                            <div class="col-md-6">
                                <h6 style="font-weight: bold;">₦{{ number_format($salesreturned->sum('total_amount'), 2) }}</h6>
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
                            Total Stock Collected by Product
                        </h4>
                    </div>
                    <div class="card-body text-left p-0 m-0" style="color: #1a1e21;">
                        <p class="card-text">
                        @foreach($totalstockcollected as $ptn)
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold; color:#757373;">{{ $ptn->products->name }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold; color:#757373;">{{ $ptn->qty }} nos.</h6>
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
                            Total Stock Returned by Product
                        </h4>
                    </div>
                    <div class="card-body text-left" style="color: #1a1e21;">
                        <p class="card-text">
                        @foreach($totalstockreturned as $ptn)
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold; color:#757373;">{{ $ptn->products->name }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold; color:#757373;">{{ $ptn->qty }} nos.</h6>
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
    <h4 style="font-weight: bold; color: #0a9b0d;">Net Profit: <span style="font-weight: bold; color: green;">₦{{ number_format($sales->sum('total_amount') - $stocks->sum('total_price'), 2) }}</span></h4>
</div>




