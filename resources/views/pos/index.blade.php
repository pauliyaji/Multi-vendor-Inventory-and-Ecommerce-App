
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All POS Transactions
                    <a href="{{ route("pos.create") }}" class="float-right btn btn-success btn-sm">Add New</a>
                </h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background-color: #4e73df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Invoice No.</th>
                            <th>Shop No.</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Date of Transaction</th>
                            <th>Transaction Type</th>
                            <th>Action</th>

                        </tr>
                        </thead>

                        <tbody>
                        @if($data)
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->trx_no}}</td>
                                    <td>{{ $d->shops->shop_no }}</td>
                                    <td>{{ $d->products->name }}</td>
                                    <td>{{ $d->qty }}</td>
                                    <td>{{ $d->date_of_trx }}</td>
                                    <td>
                                        @if($d->trxtype_id == 1)
                                            <span class="text-success text-left">{{ $d->trxtypes->type }}</span>
                                        @else
                                            <span class="text-danger text-left">{{ $d->trxtypes->type }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('pos.show', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('pos.edit', $d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                @if(Auth::user()->id == 1)
                                                    <form action="{{ route('pos.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </div>

                                    </td>

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="import" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

@include('layouts/footer')


<!-- Bootstrap core JavaScript-->

