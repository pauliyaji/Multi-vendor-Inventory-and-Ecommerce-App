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
        <form method="POST" action="{{ route('pos.store') }}">
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
                       {{--
                       <a title="Add new Customer" class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> <i class="fa fa-plus-circle fa-lg"></i></a>
--}}
                   </div>
                   <div class="col-md-6">
                       <select class="col-md-8" name="product_id" id="product-dropdown">
                           <option value="">Select Product</option>
                           @foreach($myproducts as $product)
                               <option value="{{ $product->id }}">{{ $product->products->name }}, Available qty: {{ $product->qty }}</option>
                           @endforeach
                       </select>
                   </div>

               </div>
                <br/>
                <div class="table-responsive">
                    <table class="table table-bordered" id="prod_table">
                        <thead style="background-color: #f5eded;">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Total Price</th>
                            <th>Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" style="background-color: #a6a4a4; margin:5px; padding: 10px; display: flex;">
                    <hr style="color: white;"/>
                    @foreach($myproducts as $product)
                        <a href="#" style="text-decoration: none; color: #1f1e1e;">
                            <div class="card text-center" style="margin:5px;">
                                <div class="card-header">
                                    <div class="card-title">
                                        <b>{{ $product->products->name  }}</b>
                                    </div>
                                </div>
                                <div class="card-body">
                                    &#8358;{{ number_format($product->selling_price, 2)}}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3" style="background-color: white; margin:10px;">
                <br/>
                <div class="row" style="padding-left: 20px; padding-right: 20px; margin-bottom: 20px;">
                        <label for="name"><b>Total Amount Payable</b></label>
                        <input name="name" type="text" class="form-control" id="name" aria-describedby="name" readonly>
                        <span class="text-danger">{{ $errors->first('total_amount') }}</span>
                          <br />
                            <label for="name"><b>Total Discount</b></label>
                            <input name="total_discount" type="text" class="form-control" id="total_discount" aria-describedby="total_discount" readonly>
                            <span class="text-danger">{{ $errors->first('total_discount') }}</span>
                    <br />
                    <label for="name"><b>Amount Paid</b></label>
                    <input name="name" type="text" class="form-control" id="name" aria-describedby="name" readonly>
                    <span class="text-danger">{{ $errors->first('total_amount') }}</span>
                    <br />
                    <label for="name"><b>Total Balance</b></label>
                    <input name="name" type="text" class="form-control" id="name" aria-describedby="name" readonly>
                    <span class="text-danger">{{ $errors->first('total_amount') }}</span>
                    <br />
                    <div style="background-color: dodgerblue; color: white;">
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

<script>
    jQuery(document).ready(function(){

        jQuery('#ajaxSubmit').change(function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var id = $("#ajaxSubmit").val();
            // alert(prinew);

            jQuery.ajax({
                url: "http://localhost/water/public/productionreports/rawmatprice/"+ id,
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    // var xyz = sum(response.data.total_price);
                    $('#total_price').val(response.data);
                },
                error: function(error){
                    console.log(error);
                },
            });
        });
// Adding products to cart
        jQuery('#product-dropdown').change(function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var id = $("#product-dropdown").val();
            // alert(prinew);
          //  alert(id);
            jQuery.ajax({

                url: "http://localhost/water/public/carts/add/"+id,
                type: 'get',
                dataType: 'json',
                success: function(response){
                   console.log(response.data);
                   var len = response.data;
                   alert(len);
                    if(len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var product = response['data'][i].item;
                            var selling_price = response['data'][i].selling_price;
                            var qty = response['data'][i].qty;
                            var total_price = response['data'][i].total_price;

                            var tr_str = "<tr>" +
                                "<td>" + (i + 1) + "</td>" +
                                "<td>" + product + "</td>" +
                                "<td>" + selling_price + "</td>" +
                                "<td>" + qty + "</td>" +
                                "<td>" + total_price + "</td>" +
                                "<td>" + qty + "</td>" +

                                "</tr>";

                            $("#prod_table").append(tr_str);
                        }
                    }
                },
                error: function(error){
                    console.log(error);
                },
            });
        });
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
{{--THE END- CREATING A NEW CUSTOMER--}}



    </body>
</html>
