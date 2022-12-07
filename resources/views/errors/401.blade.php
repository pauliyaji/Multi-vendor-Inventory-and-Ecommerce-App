@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{ Session('success') }}</p>
                @endif
                <h2>Unauthorized!!!..Sorry, you are not allowed to view this page</h2>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@include('layouts/footer')


<!-- Bootstrap core JavaScript-->

