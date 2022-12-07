<div class="row" style="display: flex;">

    <div class="col-md-8" style="background-color: white; margin:10px;  padding: 10px;">
        <div class="row" style="display: flex;">

            <div class="col-md-12">
                <div class="">
                    <div class="my-2">
                        <form wire:submit.prevent="InsertoCart">
                            <input type="text" name="" id="" wire:model="product_code" class="form-control" placeholder="Enter Product Code">
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <br/>

        <div class="table-responsive">
            <div class="card">

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
            <table class="table table-bordered" id="prod_table">
                <thead style="background-color: #f5eded;">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Discount(%)</th>
                    <th class="text-center">Total Price</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="addMoreProduct">
                @foreach($productIncart as $cart)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td width="30%">
                            <input type="text" class="form-control" value="{{ $cart->products->name }}" name="" id="">
                        </td>
                        <td width="15%">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-sm btn-danger" wire:click.prevent="decrementQty({{ $cart->id }})">-</button>
                                </div>
                                <div class="col-md-1">
                                    {{-- <input type="text" value="{{ $cart->qty }}">--}}
                                    <label for="">{{ $cart->qty }}</label>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-sm btn-success" wire:click.prevent="incrementQty({{ $cart->id }})">+</button>
                                </div>

                            </div>

                        </td>
                        <td>
                            <input type="number" value="{{ $cart->selling_price }}"
                                   name="selling_price[]" id="selling_price"
                                   class="form-control selling_price" readonly>
                        </td>

                        <td width="15%">
                            <div class="row">
                                <div class="input-group">
                                    <button type="button" wire:click.prevent="decrementDisc({{ $cart->id }})" class="input-group-text btn-danger">-</button>
                                    <div class="form-control text-center">{{ $cart->discount }}</div>
                                    <button type="button" wire:click.prevent="incrementDisc({{ $cart->id }})" class="input-group-text btn-success">+</button>
                                </div>
                            </div>
                        </td>

                        <td>
                            <input type="number" name="total_price[]" id="total_price"
                                   value="{{ $cart->total_price}}"
                                   class="form-control total_price" readonly>
                        </td>
                        <td><a href="#" class="btn btn-sm btn-danger rounded-circle"><i class="fa fa-times delete" wire:click="removeProduct({{ $cart->id }})"></i></a></td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12" style="background-color: #a6a4a4; margin:5px; padding: 10px; display: flex;">

            <div class="form-control" style="background-color: darkgreen; color: white;">
                <h4>Total &#8358;<b class="total">  {{ $productIncart->sum('total_price') }} </b> </h4>
            </div>


        </div>
    </div>
    <div class="col-md-3" style="background-color: white; margin:10px;">
        <form action="{{route('orders.returnAdd')}}" method="POST">
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
            <div class="card" style="margin-top: 10px;">
                <div class="card-body">
                    <div class="btn-group">
                        <button type="button" onclick="PrintReceiptContent('print')"
                                class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Print</button>
                        <button type="button" onclick="PrintReceiptContent('print')"
                                class="btn btn-primary btn-sm"><i class="fa fa-print"></i> History</button>
                        <button type="button" onclick="PrintReceiptContent('print')"
                                class="btn btn-danger btn-sm"><i class="fa fa-print"></i> Report</button>
                    </div>
                </div>
            </div>

            <br/>
            <div class="row" style="padding-left: 20px; padding-right: 20px; margin-bottom: 20px;">

                <label for="name"><b>Total Amount Payable</b></label>
                <input name="total_amount" type="text" value="{{ $productIncart->sum('total_price') }}" class="form-control" id="name" aria-describedby="name" readonly>
                <br />
                {{--  <label for="name"><b>Total Discount</b></label>
                  <input name="total_discount" type="text" class="form-control" id="total_discount" aria-describedby="total_discount">
                  <br />--}}
                <label for="name"><b>Amount Returned</b></label>
                <input name="amount_paid" type="text" wire:model="amount_paid" class="form-control" id="amount_paid" aria-describedby="name">
                <br />
                <label for="name"><b>Total Balance</b></label>
                <input name="balance" type="text" wire:model="balance" class="form-control" id="balance" aria-describedby="name" readonly>

                <div style="background-color: dodgerblue; color: white; margin-top: 15px;">
                    <br />
                    <div class="col-md-12 form-control" style="display: flex;">
                        <select class="form-control"
                                name="customer_id">
                            <option value="">Select Customer</option>
                                <option @if($customer->customer_id) selected @endif
                                value="{{ $customer->customer_id }}">{{ $customer->customers->name }}</option>
                        </select>
                    </div>
                    <br/>
                    <label for="name"><b>Payment Method</b></label>
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
                    @endif
                    <br/>
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

{{--Modal for invoice--}}
{{--<div class="modal">
    <div id="print">
        <div id="invoice-pos">
            <div class="printed_content">

                <center id="top">
                    <div class="logo">
                        <img src="https://livingnero.com/app/img/kali.png" style="height: 70px; width: 70px;">
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
                        @foreach($order_receipt as $receipt)
                            <tr class="service">
                                <td class="tableitem"> <p class="itemtext">{{ $receipt->products->name }}</p></td>
                                <td class="tableitem"> <p class="itemtext">{{ $receipt->qty }}</p> </td>
                                <td class="tableitem"> 	<p class="itemtext">{{ number_format($receipt->unitprice, 2) }}</p> </td>
                                <td class="tableitem"> <p class="itemtext">{{ $receipt->discount }}</p></td>
                                <td class="tableitem"> <p class="itemtext">{{ number_format($receipt->amount, 2) }}</p></td>
                            </tr>
                        @endforeach

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
                                    {{ number_format($order_receipt->sum('amount'), 2) }}
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
                        <span>{{ $trx_date->created_at }}</span>

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
</div>--}}


