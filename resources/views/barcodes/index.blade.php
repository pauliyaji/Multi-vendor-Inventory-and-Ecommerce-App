
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Production Batches/Barcodes
                    <a href="{{ route("barcodes.create") }}" class="float-right btn btn-success btn-sm">Create A New Production Batch</a>
                </h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background-color: #4e73df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Production no.</th>
                            <th>Product</th>
                            <th>Output Qty</th>
                            <th>QR Code</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Production no.</th>
                            <th>Product</th>
                            <th>Output Qty</th>
                            <th>QR Code</th>

                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if($data)
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                       <a href="{{ route('productions.mats', $d->id) }}"> {{ $d->ptn_no }}</a>

                                    </td>
                                    <td>{{ $d->products->name }}</td>
                                    <td>{{ $d->output_qty }}</td>
                                   {{-- <td>
                                        <div class="mb-3">{!! DNS1D::getBarcodeHTML($d->ptn_no, 'UPCA') !!}</div>
                                    </td>--}}
                                    <td>{{ QrCode::size(80)->generate('Property of Hope Bassey Water company'.$d->ptn_no) }}</td>

                                    <td>
                                        <a href="{{ route("barcodes.edit", $d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit Batch</a>

                                        <a href="{{ route("storetrxs.create") }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Raw materials</a>

                                        {{--   <div class="card">
                                               <p class="name">Hope Bassey Water Company</p>
                                               {!! DNS1D::getBarcodeHTML($d->ptn_no, "C128",1.4,22) !!}
                                               <p class="pid">{{$d->ptn_no }}</p>
                                           </div>--}}
                                    </td>

                                  {{--  <td>
                                        @if(Auth::user()->id == 1)
                                            <div class="btn-group">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('barcodes.show', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View Details</a>
                                                    @if(Auth::user()->id == 1)
                                                        <form action="{{ route('barcodes.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endif
                                                </div>

                                            </div>
                                    </td>
                                    @endif --}}
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

