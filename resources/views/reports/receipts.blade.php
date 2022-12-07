<div id="invoice-pos">
    <div class="printed_content">

        <center id="top">
            <div class="logo">
                <img src="{{ asset('http://localhost/water/public/img/kali.png') }}" style="height: 70px; width: 70px;">
            </div>
            <h2>Livingnero Ltd</h2>
        </center>
    </div>

    <div class="mid">
        <div class="info">
            <h2>Contact Us</h2>
            <p>
                Address: House 1-3, Block NL3, Knowledge Court Estate, Galadimawa District, FCT-Abuja.
                Email: info@livingnero.com
                Phone: +234 803 632 1271, 09024535000
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
                <span>11/08/22 &nbsp; &nbsp; 11:08</span>

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
        background-image:{{ asset('../img/kali.png') }};
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

