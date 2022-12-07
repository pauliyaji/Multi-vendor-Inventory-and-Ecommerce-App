<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
    @livewireStyles
    <title>POS</title>
</head>
<body>
<div class="py-4">
    <div class="container" style="background-color: #cccccc;">
        <div class="row" style="justify-items: center; background-color: #ffffff; display:flex;">
            <div class="float-left col-md-10">
                <h6>POS Terminal <i class="fa fa-keyboard"></i>
                    <button id="btn">Go Fullscreen</button>
                </h6>
            </div>

        </div>
        <hr/>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="row" style="display: flex;">
                <div class="col-md-8" style="background-color: white; margin:10px;  padding: 10px;">
                    <div class="row" style="display: flex;">

                        <div class="col-md-6">
                            <select class="col-md-8" name="customer_id" id="select2-dropdown">
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
                        <div class="col-md-6">

                        </div>

                    </div>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="prod_table">
                            <thead style="background-color: #f5eded;">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Total Price</th>
                                <th><a href="#" class="btn btn-sm btn-success"><i class="fa fa-plus-circle add_more rounded-circle"></i></a></th>
                            </tr>
                            </thead>
                            <tbody class="addMoreProduct">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select class="form-control product_id" name="product_id[]" >
                                            <option value="">Search Product</option>
                                            @foreach($myproducts as $product)
                                                <option data-price="{{ $product->selling_price }}" value="{{ $product->product_id }}">{{ $product->products->name }}, Available qty: {{ $product->qty }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="qty[]" id="qty"
                                               class="form-control qty">
                                    </td>
                                    <td>
                                        <input type="number" name="selling_price[]" id="selling_price"
                                               class="form-control selling_price" readonly>
                                    </td>

                                    <td>
                                        <input type="number" name="discount[]" id="discount[]"
                                               class="form-control discount">
                                    </td>
                                    <td>
                                        <input type="number" name="total_price[]" id="total_price"
                                               class="form-control total_price" readonly>
                                    </td>

                                    <td><a href="#" class="btn btn-sm btn-danger rounded-circle"><i class="fa fa-times delete"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" style="background-color: #a6a4a4; margin:5px; padding: 10px; display: flex;">
                        <div class="card">
                            <div class="card-header" style="background-color: darkgreen; color: white;">
                                <h4>Total &#8358;<b class="total"> 0.00 </b> </h4>
                            </div>
                            <div class="card-body">
                                ...........
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-3" style="background-color: white; margin:10px;">

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
                    <div class="row" style="padding-left: 20px; padding-right: 20px; margin-bottom: 20px; color: #757373;">
                        <label for="name"><b>Total Amount Payable (&#8358;)</b></label>
                        <input type="text" class="form-control" value="0.00" name="total_amount" id="total_amount" style="background-color: darkgreen; color: white; font-weight: bold;" readonly>
                        <br />
                        <label for="name"><b>Total Payment (&#8358;)</b></label>
                        <input name="amount_paid" type="text" class="form-control" id="amount_paid">
                        <br />
                        <label for="name"><b>Total Balance (&#8358;)</b></label>
                        <input name="balance" type="text" class="form-control" id="balance" readonly>
                        <br />
                        <div style="background-color: dodgerblue; color: white; margin-top: 15px;">
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
                            <br />
                            <label for="name"><b>Transaction Type</b></label>
                            <select class="form-control"
                                    name="trxtype_id" id="checkReturn">
                                <option value="">Select Transaction Type</option>
                                @foreach($trxtypes as $trxtype)
                                    <option value="{{ $trxtype->id }}"
                                        {{$trxtype->type}}>{{ $trxtype->type }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('trxtype_id'))
                                <span class="text-danger text-left">{{ $errors->first('trxtype_id') }}</span>
                            @endif
                            <br/>
                        </div>

                        <div>
                            <br/>
                            <input type="submit" class="btn btn-primary btn-sm" />
                            <input type="submit" value="Cancel" class="btn btn-danger btn-sm" />

                        </div>
                    </div>


                </div>

            </div>


            <br/>
        </form>
    </div>

</div>



<!-- Modal FOR CREATING A NEW CUSTOMER-->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0a58ca; color:white;">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="customerForm" name="customerForm" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <br/>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Modal for invoice--}}
<div class="modal">
    <div id="print">
        @include('reports.receipts')
    </div>
</div>



{{--Select2 script--}}
<script>
    $(document).ready(function () {
        $('#select2-dropdown').select2();
        $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            $("#select2-dropdown").val(data);
        });
        $('#product-dropdown').select2();
        $('#product-dropdown').on('change', function (e) {
            var data = $('#product-dropdown').select2("val");
            $("#product-dropdown").val(data);


        });
    });
</script>


{{--The FUll screen script--}}
<script>
    let myDocument = document.documentElement;
    let btn = document.getElementById("btn");

    btn.addEventListener("click", ()=>{
        if(btn.textContent == "Go Fullscreen"){
            if (myDocument.requestFullscreen) {
                myDocument.requestFullscreen();
            }
            else if (myDocument.msRequestFullscreen) {
                myDocument.msRequestFullscreen();
            }
            else if (myDocument.mozRequestFullScreen) {
                myDocument.mozRequestFullScreen();
            }
            else if(myDocument.webkitRequestFullscreen) {
                myDocument.webkitRequestFullscreen();
            }
            btn.textContent = "Exit Fullscreen";
        }
        else{
            if(document.exitFullscreen) {
                document.exitFullscreen();
            }
            else if(document.msexitFullscreen) {
                document.msexitFullscreen();
            }
            else if(document.mozexitFullscreen) {
                document.mozexitFullscreen();
            }
            else if(document.webkitexitFullscreen) {
                document.webkitexitFullscreen();
            }

            btn.textContent = "Go Fullscreen";
        }
    });
</script>
{{--CREATING A NEW CUSTOMER--}}
<script type="text/javascript">
    $(function () {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });


        $('#createNewCustomer').click(function () {
            $('#saveBtn').val("create-customer");
            // $('#product_id').val('');
            $('#customerForm').trigger("reset");
            $('#modelHeading').html("Create New Customer");
            $('#ajaxModel').modal('show');
        });

        //Create Customer

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#customerForm').serialize(),
                url: "http://localhost/water/public/customers/add",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    // alert(response.message);
                    $('#customerForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    location.reload();
                    // table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

    });
</script>
{{--THE END- CREATING A NEW  CUSTOMER--}}

<script>
    $(document).ready(function(){
       $('.add_more').on('click', function(){
          var product = $('.product_id').html();
          var numberofrow = ($('.addMoreProduct tr').length - 0) + 1;
          var tr = '<tr><td class"no"">' + numberofrow + '</td>'+
              '<td><select class="form-control product_id" name="product_id[]">' + product +
              ' </select></td>'+
              '<td> <input type="number" name="qty[]" class="form-control qty"> </td>'+
              '<td> <input type="number" name="selling_price[]" class="form-control selling_price" readonly> </td>'+
              '<td> <input type="number" name="discount[]" class="form-control discount"> </td>'+
              '<td> <input type="number" name="total_price[]" class="form-control total_price" readonly> </td>'+
              '<td> <a class="btn btn-danger btn-sm delete rounded-circle"> <i class="fa fa-times-circle"></i></a> </td>'
            $('.addMoreProduct').append(tr);

       });
       // Delete the row
       $('.addMoreProduct').delegate('.delete', 'click', function(){
           $(this).parent().parent().remove();
       });

       function TotalPrice(){
           // all the logic goes here
           var total = 0;
           $('.total_price').each(function(i, e){
              var amount = $(this).val() - 0;
              total += amount;
           });

           $('.total').html(total);
           $('#total_amount').val(total);

       }

       $('.addMoreProduct').delegate('.product_id', 'change', function(){
          var tr = $(this).parent().parent();
          var price = tr.find('.product_id option:selected').attr('data-price');
          tr.find('.selling_price').val(price);
          var qty = tr.find('.qty').val() - 0;
          var disc = tr.find('.discount').val() - 0;
          var price = tr.find('.selling_price').val() - 0;
          var total_price = (qty * price) - ((qty * price * disc) / 100);
          tr.find('.total_price').val(total_price);
          TotalPrice();
       });

       $('.addMoreProduct').delegate('.qty, .discount', 'change', function(){

           var tr = $(this).parent().parent();
           var qty = tr.find('.qty').val() - 0;
           var disc = tr.find('.discount').val() - 0;
           var price = tr.find('.selling_price').val() - 0;
           var total_price = (qty * price) - ((qty * price * disc) / 100);
           tr.find('.total_price').val(total_price);
           TotalPrice();

       })
    });

        $('#amount_paid').keyup(function(){
            var total = $('.total').html();
            var amount_paid = $(this).val();
            var tot = total - amount_paid;
            $('#balance').val(tot);
        });

        // Print section
        function PrintReceiptContent(el){
            var data = '<input type="button" id="printPageButton" class="PrintPageButton" style="display: block; width:100%; border: none; background-color: #008B8B; color: #fff; padding: 14px 28px; font-size: 16px; cursor:pointer; text-align:center" value="Print Receipt" onClick="window.print()">';

                data += document.getElementById(el).innerHTML;
                myReceipt = window.open("", "myWin", "left=150, top=130, width=400, height=400");
                myReceipt.screnX = 0;
                myReceipt.screnY = 0;
                myReceipt.document.write(data);
                myReceipt.document.title = 'Print Receipt';
                myReceipt.focus();
                setTimeout(() => {
                   myReceipt.close();
                }, 10000);

            }
</script>
</body>
</html>
