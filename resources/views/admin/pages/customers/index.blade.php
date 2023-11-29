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
                    <form action="" id="customer_form" method="">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter The Customer Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter The Customer Email">
                        </div>
                        @error('email')
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
                            <button id="customer_add" class="btn btn-success" class="form-control">save</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <form id="customer_form_edit" action="" method="">
                        @csrf
                        <input type="hidden" name="id" id="customer_id" class="form-control">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" id="customer_name" class="form-control" placeholder="Enter The Customer Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Email</label>
                            <input type="email" name="email" id="customer_email" class="form-control" placeholder="Enter The Customer Email">
                        </div>
                        @error('email')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" id="customer_image" name="image" class="form-control">
                        </div>
                        @error('image')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <button id="customer_update" class="btn btn-success" class="form-control" data-id="customer_id">update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table id="customers_table" class="table table-bordered data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
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
            var table = $('#customers_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.create') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'image',
                        render: function(image) {
                            return '<img src="' + image + '" width="150" height="50">';
                        }
                    },
                    {
                        title: 'action',
                        render: function(data, type, row) {
                            return '<a id="customer_edit" class="btn btn-info" data-toggle="modal" data-target="#editModal" data-id="' +
                                row.id +
                                '">Edit</a> <a id="customer_delete" class="btn btn-danger" data-id="' +
                                row.id + '">Delete</a>';

                        }
                    }
                ]
            })
        })
    </script>

    <script>
        $(document).on('click', '#customer_add', function(e) {
            e.preventDefault();
            var form = document.getElementById('customer_form');
            var formdata = new FormData(form);
            $.ajax({
                type: 'post',
                url: "{{ route('customer.store') }}",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: (data) => {
                    var oTable = $("#customers_table").DataTable().ajax.reload();
                    oTable.ajax.reload();
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#customer_edit', function(e) {
            var customerId = $(this).data('id');
            $.ajax({
                url: "{{ route('customer.index') }}"+"/"+customerId+"/edit",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#editModal').modal('show');
                    $('#customer_id').val(data.id);
                    $('#customer_name').val(data.name);
                    $('#customer_email').val(data.email);
                    $('#customer_image').val(data.image);
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#customer_update', function(e) {
            e.preventDefault();
            var customerId = $(this).data('customer_id');
            var form = document.getElementById('customer_form_edit');
            var formdata = new FormData(form);
            $.ajax({
            type: 'POST',
            url: '{{ url('admin/customer/update') }}',
            data:formdata,
            processData: false,
            contentType: false,
            cache: false,
            success: (data) => {
                $("#customers_table").DataTable().ajax.reload();
            },
        });
    });
    </script>
    <script>
        $(document).on('click', '#customer_delete', function(e) {
            var customerId = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/customer/delete') }}/' + customerId,
                type: 'get',
                success: function(response) {
                    if (response.success) {
                        $('#customers_table').DataTable().row($(this).closest('tr')).remove().draw();
                        alert('Customer deleted successfully.');
                    } else {
                        alert('Error deleting Customer.');
                    }
                }
            });
        });
    </script>
@endsection
@endsection
