
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="col-md-12" style="display: flex; margin: 10px;">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <form action="{{ route('productions.materials') }}" method="post">
                    @csrf

                    <select onchange="this.form.submit()" name="ptn_id" id="select2-dropdown" class="form-control">
                        <option value="">Select Production Batch </option>
                        @foreach($ptn as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->ptn_no }}</option>
                        @endforeach
                    </select>


                </form>
            </div>
            <div class="col-md-4">

            </div>

        </div>
        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h6 class="m-0 font-weight-bold text-primary">All Production Raw Materials Summary

               </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <p class="text-success">{{ Session('success') }}</p>
                @endif
                    @if(Session::has('message'))
                        <p class="text-danger">{{ Session('message') }}</p>
                    @endif
                <div class="d-flex my-2 ">
{{--
                    <a href="" class="btn btn-primary m-2 me-1">Export Data</a>
--}}

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background-color: #4e73df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Batch No.</th>
                            <th>Raw material</th>
                            <th>Qty Collected</th>
                            <th>Qty Returned</th>
                            <th>Qty Used</th>
                            <th>Qty Wasted</th>
                            <th>Production Date</th>
                            {{--<th>Action</th>--}}

                        </tr>
                        </thead>

                        <tbody>
                        @if($data)
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->ptn_no }}</td>
                                    <td>{{ $d->rawmaterial_id }}</td>
                                    <td>{{ $d->qty_collected }}</td>
                                    <td>{{ $d->qty_returned }}</td>
                                    <td>{{ $d->qty_used }}</td>
                                    <td>{{ $d->waste }}</td>
                                    <td>{{ $d->date_of_trx }}</td>
                                   {{--<td>
                                       <a href="{{ route('productions.show', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>

                                   </td>--}}

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

