@extends('admin.layout.main')
@section('content')
    @if (Session::has('store'))
        <div class="row mr-2 ml-2">
            <label class="alert alert-success">{{ Session::get('store') }}</label>
        </div>
    @endif
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        create
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Store Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.category.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter The Category Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter The Category Description"></textarea>
                        </div>
                        @error('description')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="save" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <table id="categories_table" class="table table-bordered data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
    @section('scripts')
        <script src="text/javascript">
            $(document).ready(function() {
                var table = $('#categories_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.category.index') }}",
                    columns: [
                        {data: 'id',name: 'id'},
                        {data: 'name',name: 'name'},
                        {data: 'description',name: 'description'},
                        {data: 'action',name: 'action',orderable: false,searchable: false}
                    ]
                })
            })
        </script>
    @endsection
@endsection
