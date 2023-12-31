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
                    <form action="" id="service_form" method="">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter The Service Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter The Service Description"></textarea>
                        </div>
                        @error('description')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror

                        <div class="form-group">
                            <button id="service_add" class="btn btn-success" class="form-control">save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModale" tabindex="-1" role="dialog" aria-labelledby="editModaleLabel"
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
                    <form id="service_form_edit" action="" method="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="service_id" class="form-control">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" id="service_name" class="form-control"
                                placeholder="Enter The Category Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Description</label>
                            <textarea name="description" id="service_description" class="form-control"
                                placeholder="Enter The Category Description"></textarea>
                        </div>
                        @error('description')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror

                        <div class="form-group">
                            <button id="service_update" class="btn btn-success" class="form-control" data-id="service_id">update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table id="services_table" class="table table-bordered data-table">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#services_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('service.create') }}",
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
                        title: 'Action',
                        render: function(data, type, row) {
                            return '<a id="service_edit" class="btn btn-info" data-toggle="modal" data-target="#editModale" data-id="' +
                                row.id +
                                '">Edit</a> <a id="service_delete" class="btn btn-danger" data-id="' +
                                row.id + '">Delete</a>';

                        }
                    }
                ]
            })
        })
    </script>

    <script>
        $(document).on('click', '#service_add', function(e) {
            e.preventDefault();
            var form = document.getElementById('service_form');
            var formdata = new FormData(form);
            $.ajax({
                type: 'post',
                url: "{{ route('service.store') }}",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: (data) => {
                    var oTable = $("#services_table").DataTable().ajax.reload();
                    oTable.ajax.reload();
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#service_edit', function(e) {
            var serviceId = $(this).data('id');
            $.ajax({
                url: "{{ route('service.index') }}"+"/"+serviceId+"/edit",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#editModale').modal('show');
                    $('#service_name').val(data.name);
                    $('#service_description').val(data.description);
                    $('#service_id').val(data.id);
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#service_update', function(e) {
            e.preventDefault();
            var serviceeId = $(this).data('id');
            var form = document.getElementById('service_form_edit');
            var formdata = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('admin/service') }}/" + serviceeId, // Use correct route name
                type: 'POST',
                data:formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: (data) => {
                    $("#services_table").DataTable().ajax.reload();
                },
            });
    });
    </script>
    <script>
        $(document).on('click', '#service_delete', function(e) {
            var serviceId = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('admin/service') }}/" + serviceId, // Use correct route name
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        $('#services_table').DataTable().row($(this).closest('tr')).remove().draw();
                        alert('Service deleted successfully.');
                    } else {
                        alert('Error deleting Service.');
                    }
                }
            });
        });
    </script>
@endsection
@endsection
