@extends('admin.layout.main')
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
                    <form action="" id="categor_form" method="" enctype="multipart/form-data">
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
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        @error('image')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <button id="caegory_add" class="btn btn-success" class="form-control">save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <form id="categor_form_edit" action="" method="">
                        @csrf
                        <input type="hidden" name="id" id="category_id" class="form-control">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" id="category_name" class="form-control"
                                placeholder="Enter The Category Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Description</label>
                            <textarea name="description" id="category_description" class="form-control"
                                placeholder="Enter The Category Description"></textarea>
                        </div>
                        @error('description')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="image" id="category_image" class="form-control">
                        </div>
                        @error('image')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <button id="caegory_update" class="btn btn-success" class="form-control" data-id="category_id">update</button>
                        </div>
                    </form>
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
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#categories_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.category.index') }}",
                dataType: 'json',
                dataSrc: 'data',
                serverSide: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'image',
                        render: function(imagePath) {
                            return '<img src="' + imagePath + '" width="150" height="50">';
                        }
                    },
                    {
                        title: 'Action',
                        render: function(data, type, row) {
                            return '<a id="category_edit" class="btn btn-info" data-toggle="modal" data-target="#editModal" data-id="' +
                                row.id +
                                '">Edit</a> <a id="category_delete" class="btn btn-danger" data-id="' +
                                row.id + '">Delete</a>';

                        }
                    }
                ]
            })
        })
    </script>

    <script>
        $(document).on('click', '#caegory_add', function(e) {
            e.preventDefault();
            var form = document.getElementById('categor_form');
            var formdata = new FormData(form);
            $.ajax({
                type: 'post',
                url: "{{ route('admin.category.store') }}",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: (data) => {
                    var oTable = $("#categories_table").DataTable().ajax.reload();
                    oTable.ajax.reload();
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#category_edit', function(e) {
            var categoryId = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/category/edit') }}/' + categoryId,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#editModal').modal('show');
                    $('#category_id').val(data.id);
                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#category_image').val(data.image);
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#caegory_update', function(e) {
            e.preventDefault();
            var categoryId = $(this).data('category_id');
            var form = document.getElementById('categor_form_edit');
            var formdata = new FormData(form);
            $.ajax({
            type: 'POST',
            url: '{{ url('admin/category/update') }}',
            data:formdata,
            processData: false,
            contentType: false,
            cache: false,
            success: (data) => {
                $("#categories_table").DataTable().ajax.reload();
            },
        });
    });
    </script>
    <script>
        $(document).on('click', '#category_delete', function(e) {
            var categoryId = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/category/delete') }}/' + categoryId,
                type: 'get',
                success: function(response) {
                    if (response.success) {
                        $('#categories_table').DataTable().row($(this).closest('tr')).remove().draw();
                        alert('Category deleted successfully.');
                    } else {
                        alert('Error deleting category.');
                    }
                }
            });
        });
    </script>
@endsection
@endsection
