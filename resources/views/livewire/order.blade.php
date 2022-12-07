
<section class="h-100 gradient-custom">

    <div class="container py-5">
        <div class=" row col-md-12">
            <div class="">
                <div class="my-2">
                    <form wire:submit.prevent="InsertoCart">
                        <input type="text" name="" id="" wire:model="product_code"
                               class="form-control" placeholder="Enter Product Code">
                    </form>
                </div>
            </div>
        </div>
        <div class="row card mb-0">

            @if(session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session()->has('info'))
                <div class="alert alert-danger">{{ session('info') }}</div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger"> {{ session('error') }} </div>
            @elseif($message)
                <div class="alert alert-success">{{ $message }}</div>
            @endif
        </div>
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Cart - {{ $productIncart->count() }} items</h5>
                    </div>
                    <div class="addMoreProduct card-body ">
                    @foreach($productIncart as $cart)
                        <!-- Single item -->
                        <div class="row">
                            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                <p><strong>{{ $cart->products->name }}</strong></p>
                                <!-- Price -->
                                <p>Unit Price:
                                    <strong>₦{{ number_format($cart->selling_price, 2) }}</strong>
                                </p>
                                <!-- Price -->

                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <!-- Quantity -->
                                <div class="d-flex mb-4" style="max-width: 300px">
                                    <button class="btn btn-primary px-1 me-2"
                                            wire:click.prevent="decrementQty({{ $cart->id }})">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <div class="form-outline">
                                        <input id="form1" min="0" name="quantity" value="{{ $cart->qty }}" type="number" class="form-control" readonly/>
                                        {{--<input name="mqty" type="text" wire:model="mQty({{ $cart->id }})" class="form-control" placeholder="Quantity" id="mqty" aria-describedby="mqty">--}}
                                       <label class="form-label" for="form1">Quantity</label>
                                    </div>

                                    <button class="btn btn-primary px-1 ms-2"
                                            wire:click.prevent="incrementQty({{ $cart->id }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- Quantity -->

                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <!-- Discount -->
                                <div class="d-flex mb-4" style="max-width: 300px">
                                    <button class="btn btn-primary px-1 me-1"
                                            wire:click.prevent="decrementDisc({{ $cart->id }})">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <div class="form-outline">
                                        <input id="form1" min="0" name="quantity" value="{{ $cart->discount }}" type="number" class="form-control" readonly/>
                                        <label class="form-label" for="form1">Discount</label>
                                    </div>

                                    <button class="btn btn-primary px-1 ms-1"
                                            wire:click.prevent="incrementDisc({{ $cart->id }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- Discount -->
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <!-- Data -->
                                <input type="number" name="total_price[]" id="total_price"
                                       value="{{ $cart->total_price}}"
                                       class="form-control total_price" readonly>
                                <!-- Data -->
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <!-- Data -->
                                <button type="button" class="btn btn-danger btn-sm me-1 mb-2" wire:click="removeProduct({{ $cart->id }})"
                                        title="Remove item">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <!-- Data -->
                            </div>
                        </div>
                        <!-- Single item -->
                        <hr class="my-4" />
                    @endforeach
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="row card-body col-md-12">
                                <div class="btn-group">
                                    <button type="button" onclick="PrintReceiptContent('print')"
                                            class="btn btn-dark btn-lg"><i class="fa fa-print"></i> Print</button>
                                    <button type="button" onclick="PrintReceiptContent('print')"
                                            class="btn btn-primary btn-lg"><i class="fa fa-print"></i> History</button>
                                    <button type="button" onclick="PrintReceiptContent('print')"
                                            class="btn btn-danger btn-lg"><i class="fa fa-print"></i> Report</button>
                                </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total amount</strong>
                                </div>
                                <span><strong><h2>&#8358;{{ number_format($productIncart->sum('total_price'), 2) }}</h2></strong></span>
                            </li>
                            <hr class="my-4" />
                        </ul>


                       {{-- <button type="button" class="btn btn-primary btn-lg btn-block">
                            Go to checkout
                        </button>--}}
                        <form action="{{route('orders.store')}}" method="POST">
                            @csrf

                            @foreach($productIncart as $cart)

                                <input type="hidden" class="form-control" value="{{ $cart->product_id }}" name="product_id[]">

                                <input type="hidden" name="qty[]" value="{{ $cart->qty }}">
                                <input type="hidden" value="{{ $cart->selling_price }}"
                                       name="selling_price[]"
                                       class="form-control selling_price">
                                <input type="hidden" name="shop_id[]" value="{{ $cart->shop_id }}">
                                <input type="hidden" name="discount[]"
                                       class="form-control discount">

                                <input type="hidden" name="total_price[]"
                                       value="{{ $cart->total_price}}"
                                       class="form-control total_price">

                            @endforeach

                            <br/>
                            <div class="row" style="padding-left: 20px; padding-right: 20px; margin-bottom: 20px;">

                                <label for="name"><b>Total Amount Payable</b></label>
                                <input name="total_amount" type="text" value="{{ $productIncart->sum('total_price') }}" class="form-control" id="name" aria-describedby="name" readonly>
                                <br />
                                {{--  <label for="name"><b>Total Discount</b></label>
                                  <input name="total_discount" type="text" class="form-control" id="total_discount" aria-describedby="total_discount">
                                  <br />--}}
                                <label for="name"><b>Amount Paid</b></label>
                                <input name="amount_paid" type="text" wire:model="amount_paid" class="form-control" id="amount_paid" aria-describedby="name" required>
                                <br />
                                <label for="name"><b>Total Balance</b></label>
                                <input name="balance" type="text" wire:model="balance" class="form-control" id="balance" aria-describedby="name" readonly>

                                <div style="background-color: dodgerblue; color: white; margin-top: 15px;">
                                    <br />
                                    <div class="col-md-12 form-control" style="display: flex;">
                                        <select class="form-control" name="customer_id" id="select2-dropdown" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        <!-- Button trigger modal -->
                                        <a href="javascript:void(0)">
                                            <button type="button" id="createNewCustomer" class="btn btn-default bg-white btn-flat add_new_customer" data-name="">
                                                <i class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                        </a>
                                    </div>
                                    <br/>
                                    <label for="name"><b>Payment Method</b></label>
                                    <select class="form-control"
                                            name="paymentmethod_id" required>
                                        <option value="">Select Payment Method</option>
                                        @foreach($paymentmethods as $paymentmethod)
                                            <option value="{{ $paymentmethod->id }}"
                                                {{$paymentmethod->method}}>{{ $paymentmethod->method }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('paymentmethod_id'))
                                        <span class="text-danger text-left">{{ $errors->first('paymentmethod_id') }}</span>
                                    @endif
                                    <br />

                                </div>

                                <div>
                                    <br/>
                                    <input type="submit" class="btn btn-primary btn-sm" />
                                    <button wire:click.prevent="doCancel" class="btn btn-danger btn-sm" >Cancel</button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{--Modal for invoice--}}
<div class="modal">
    <div id="print">
        <div id="invoice-pos">
            <div class="printed_content">

                <center id="top">
                    <div class="logo">
                       <!-- <img src="http://p3portfolio.com/livingnero/public/img/kali.png" style="height: 70px; width: 70px;">-->
                    </div>
                    <h2>Livingnero Ltd</h2>
                </center>
            </div>

            <div class="mid">
                <div class="info">
                    <h2>Contact Us</h2>
                    <p>
                          Address: House 1-3, Block NL3, Knowledge Court Estate, Galadimawa District, FCT-Abuja. 
                            Email: billing@livingnero.com <br>
                            Phone: (234) 9088888522
                    </p>
                </div>
            </div>
            <!--End of Receipt Mid-->

            <div class="bot">
                <div id="table">
                    <table>
                        <tr class="title">
                            <td class="item"><h2>Item</h2></td>
                            <td class="hours"><h2>QTY</h2></td>
                            <td class="rate"><h2>Unit Price</h2></td>
                            <td class="rate"><h2>Discount</h2></td>
                            <td class="rate"><h2>Sub Total</h2></td>
                        </tr>
                        @if($order_receipt)
                            @foreach($order_receipt as $receipt)
                                <tr class="service">
                                    <td class="tableitem"> <p class="itemtext">{{ $receipt->products->name }}</p></td>
                                    <td class="tableitem"> <p class="itemtext">{{ $receipt->qty }}</p> </td>
                                    <td class="tableitem"> 	<p class="itemtext">{{ number_format($receipt->unitprice, 2) }}</p> </td>
                                    <td class="tableitem"> <p class="itemtext">{{ $receipt->discount }}</p></td>
                                    <td class="tableitem"> <p class="itemtext">{{ number_format($receipt->amount, 2) }}</p></td>
                                </tr>
                            @endforeach
                        @endif
                        <tr class="tabletitle">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="Rate"><p class="itemtext">Tax</p></td>
                            <td class="Payment"><p class="itemtext">0.00 </p></td>

                        </tr>

                        <tr class="tabletitle">
                            <td></td>
                            <td></td>
                            <td></td>
                            <h1> <td class="Rate">Total</td>
                                <td class="Payment">
                                    @if($order_receipt)
                                        {{ number_format($order_receipt->sum('amount'), 2) }}
                                    @endif
                                </td> </h1>
                        </tr>
                    </table>

                    <div class="legalcopy">
                        <p class="legal">
                            <strong> ** Thank you for your patronage ** </strong><br>
                            The good which are subjec to tax, prices includes tax
                        </p>
                    </div>
                    <div class="serial-number">
                        Serial: <span class="serial">
                    123456789674635
                </span>
                        @if($trx_date)
                            <span>{{ $trx_date->created_at }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <style>
            #invoice-pos{
                box-shadow: 0 0 1in -0.25in rgb(0,0,0.5);
                padding: 2mm;
                margin: 0 auto;
                width: 58mm;
                background-color: #fff;
            }

            #invoice-pos ::selection{
                background: #f315f3;
                color: #fff
            }

            #invoice-pos -mz-selection {
                background: #34495E;
                color: #fff
            }

            #invoice-pos h1{
                font-size: 1.5em;
                color: #222;
            }

            #invoice-pos h2{
                font-size: 0.5em;
            }

            #invoice-pos h3{
                font-size: 1.2em;
                font-weight: 300;
                line-height: 2em;
            }

            #invoice-pos p{
                font-size: 0.7em;
                line-height: 1.2em;
                color: #666;
            }

            #invoice-pos #top, #invoice-pos .mid, #invoice-pos .bot{
                border-bottom: 1px solid #eee;
            }

            #invoice-pos #top{
                min-height: 100px;
            }

            #invoice-pos .mid{
                min-height: 80px;
            }

            #invoice-pos .bot{
                min-height: 50px;
            }

            #invoice-pos #top .logo{
                height: 60px;
                width: 60px;
                background-image:url('https://livingnero.com/app/img/kali.png');
                background-size: 60px 60px;
                border-radius: 50px;
            }

            #invoice-pos .info{
                display: block;
                margin-left: 0;
                text-align:center;
            }

            #invoice-pos .title{
                text-align:justify;
                background-color: #eee;

            }
            #invoice-pos .title p{
                text-align:right;

            }

            #invoice-pos #table{
                width: 100%;
                border-collapse: collapse;
            }

            #invoice-pos .tabletitle{
                font-size: 0.5em;
                background: #eee;
            }

            #invoice-pos .service{
                border-bottom: 1px solid #eee;

            }

            #invoice-pos .item{
                width: 24mm;
            }

            #invoice-pos .item {
                width: 24mm;
            }

            #invoice-pos .itemtext{
                font-size: 0.5em;

            }

            #invoice-pos .legalcopy{
                margin-top: 5mm;
                text-align: center;
            }

            .serial-number{
                margin-top: 5mm;
                margin-bottom: 2mm;
                text-align: center;
                font-size: 12px;
            }

            .serial{
                font-size: 10px !important;
            }



        </style>
    </div>
</div>
{{--Printing Invoice Ends--}}
<!-- End your project here-->
