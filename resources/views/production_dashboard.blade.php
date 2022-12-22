@extends('layouts/layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

         <div class="col-md">
             <h4 style="color: green">Welcome <span style="color:blue;">{{ Auth::user()->name }}</span>, Do have a great day at work today?</h4>
         </div>


        </div>
        <!-- Content Row -->

    </div>

@endsection

@section('scripts')

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/chart.js/Chart.min.js') }}"></script>
    {{--  <script type="text/javascript">
          var _labels = {!! json_encode($labels) !!}
          var _data = {!! json_encode($data) !!}

          var _plabels = {!! json_encode($plabels) !!}
          var _pdata = {!! json_encode($pdata) !!}

      </script>--}}

    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/js/demo/chart-pie-demo.js') }}"></script>

@endsection

