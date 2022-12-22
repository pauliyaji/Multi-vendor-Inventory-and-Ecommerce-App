
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Shops
                </h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background-color: #4e73df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Shop No.</th>
                            <th>User</th>
                            <th>Phone</th>
                            <th>Coverage Area</th>
                            <th>Engagement Date</th>
                            <th>Shop Status</th>
                            <th>Action</th>

                        </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->shop_no }}</td>
                                    <td>{{ $d->user->name }}</td>
                                    <td>{{ $d->phone }}</td>
                                    <td>{{ $d->date_of_engagement }}</td>
                                    <td>{{ $d->coverage_area }}</td>
                                    @if($d->status == '1')
                                        <td><button type="button" class="btn btn-success btn-sm">{{ $d->statuses->status }}</button></td>
                                    @else
                                        <td><button type="button" class="btn btn-danger btn-sm">{{ $d->statuses->status }}</button></td>
                                    @endif
                                    <td>
                                        <a href="{{ route('shops.show', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('shops.edit', $d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('shops.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>

                                </tr>

                        @empty
                            <tr>
                                <p>We have no registered shops yet. Please contact the Administrator</p>
                            </tr>
                            @endforelse
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

