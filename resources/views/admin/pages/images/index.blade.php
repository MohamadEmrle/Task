@extends('admin.layout.main')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    @if (Session::has('store'))
        <div class="row mr-2 ml-2">
            <label class="alert alert-success">{{ Session::get('store') }}</label>
        </div>
    @endif
    <button style="margin-bottom: 10px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
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
                    <form action="" id="image_form" method="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Categories</label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('description')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <button id="image_add" class="btn btn-success" class="form-control">save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModale" tabindex="-1" role="dialog" aria-labelledby="editeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModaleLabel">Store Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="image_edit_form" method="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="image_id" class="form-control">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Categories</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <button id="image_update" class="btn btn-success" class="form-control" data-id="image_id">update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <table id="images_table" class="table table-bordered data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>CategoryName</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#images_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.image.index') }}",
                dataType: 'json',
                dataSrc: 'data',
                serverSide: true,
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'image',
                        render: function(image) {
                            return '<img src="' + image + '" width="150" height="50">';
                        }
                    },
                    {
                        data: 'CategoryName',
                        name: 'CategoryName'
                    },
                    {
                        title: 'Action',
                        render: function(data, type, row) {
                            return '<a id="image_edit" class="btn btn-info" data-toggle="modal" data-target="#editModale" data-id="' +
                                row.id +
                                '">Edit</a> <a id="image_delete" class="btn btn-danger" data-id="' +
                                row.id + '">Delete</a>';

                        }
                    }
                ]
            })
        })
    </script>

    <script>
        $(document).on('click', '#image_add', function(e) {
            e.preventDefault();
            var form = document.getElementById('image_form');
            var formdata = new FormData(form);
            $.ajax({
                type: 'post',
                url: "{{ route('admin.image.store') }}",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: (data) => {
                    var oTable = $("#images_table").DataTable().ajax.reload();
                    oTable.ajax.reload();
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#image_edit', function(e) {
            var imageId = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/image/edit') }}/' + imageId,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#editModale').modal('show');
                    $('#image_id').val(data.id);
                    $('#image').val(data.image);
                    $('#category_id').val(data.category_id);
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#image_update', function(e) {
            e.preventDefault();
            var imageId = $(this).data('image_id');
            var form = document.getElementById('image_edit_form');
            var formdata = new FormData(form);
            $.ajax({
            type: 'POST',
            url: '{{ url('admin/image/update') }}',
            data:formdata,
            processData: false,
            contentType: false,
            cache: false,
            success: (data) => {
                $("#images_table").DataTable().ajax.reload();
            },
        });
    });
    </script>
    <script>
        $(document).on('click', '#image_delete', function(e) {
            var imageId = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/image/delete') }}/' + imageId,
                type: 'get',
                success: function(response) {
                    if (response.success) {
                        $('#images_table').DataTable().row($(this).closest('tr')).remove().draw();
                        alert('Image deleted successfully.');
                    } else {
                        alert('Error deleting Image.');
                    }
                }
            });
        });
    </script>
@endsection
@endsection
