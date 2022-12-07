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
    <!-- MDB icon -->
    <link rel="icon" href="{{asset('img/mdb-favicon.ico') }}" type="image/x-icon" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{asset('/css/bootstrap-shopping-carts.min.css') }}" />

    <livewire:styles />
</head>
<body>
<style>
    .gradient-custom {
        /* fallback for old browsers */
        background: #063e90;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgb(6, 62, 144), rgb(6, 62, 144));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgb(6, 62, 144), rgb(6, 62, 144))
    }
</style>

<div class="py-4">
    <div class="container">
        <div class="row" style="justify-items: center; background-color: #ffffff; display:flex;">
            <div class="float-left col-md-10" style="display: flex;">
                <h6>POS Terminal <i class="fa fa-keyboard"></i>
                    <button id="btn">Go Fullscreen</button>
                </h6>
            </div>
            <div class="col-md-2">
               <a href="{{ route('dashboard') }}" class="btn btn-sm btn-danger" style="float: right;">Close POS</a>

            </div>
        </div>
        <div class="col-md-12" style="background-color: #063e90; font-family: Arial Black; margin: 0px; color:white; padding: 0px; text-align: center">
            <h1>LIVING NERO LTD.</h1>
        </div>

            @csrf
        @livewire('order')

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

<!-- MDB -->
<script type="text/javascript" src="{{asset('js/mdb.min.js') }}"></script>
<!-- Custom scripts -->
<script type="text/javascript"></script>

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
                url: "https://livingnero.com/app/productionreports/rawmatprice/"+ id,
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

                url: "https://livingnero.com/app/carts/add/"+id,
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
                url: "https://livingnero.com/app/customers/add",
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


<script>


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
      /*  setTimeout(() => {
            myReceipt.close();
        }, 10000);*/

    }
</script>
<livewire:scripts />

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
