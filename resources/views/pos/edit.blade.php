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

    <livewire:styles />
</head>
<body>
<div class="py-4">
    <div class="container" style="background-color: #cccccc;">
        <div class="row" style="justify-items: center; background-color: #ffffff; display:flex;">
            <div class="float-left col-md-10" style="display: flex;">
                <h6>POS Terminal <i class="fa fa-keyboard"></i>
                    <button id="btn">Go Fullscreen</button>
                </h6>
            </div>
            <div class="col-md-2">
                <form action="{{ route('pos.destroy', Auth::user()->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel and close this operation?');" style="display: inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i> Close POS</button>
                </form>
            </div>
        </div>
        <div class="col-md-12" style="background-color: #063e90; font-family: Arial Black; margin: 0px; color:white; padding: 0px; text-align: center">
            <h1>LIVING NERO LTD.</h1>
        </div>
        {{--
                <form method="POST" action="{{ route('pos.store') }}">
        --}}
        @csrf
        @livewire('returnpos')

        <br/>
        </form>
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


</body>
</html>
