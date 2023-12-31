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
                    <form action="" id="content_form" method="">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlFile1">services</label>
                            <select name="service_id" id="service_id" class="form-control">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter The Contents Name">
                        </div>
                        @error('name')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Type</label>
                            <input type="text" name="type" class="form-control" placeholder="Enter The Contents Type">
                        </div>
                        @error('type')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter The Contents Phone">
                        </div>
                        @error('phone')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter The Contents Email">
                        </div>
                        @error('email')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="image" class="form-control" placeholder="Enter The Service Name">
                        </div>
                        @error('email')
                            <h4 class="alert alert-danger">{{ $message }}</h4>
                        @enderror
                        <div class="form-group">
                            <button id="content_add" class="btn btn-success" class="form-control">save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <table id="cont_table" class="table table-bordered data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>serviceName</th>
                <th>name</th>
                <th>type</th>
                <th>phone</th>
                <th>email</th>
                <th>image</th>
                <th>action</th>
            </tr>
        </thead>
    </table>
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#cont_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('content.create') }}",
                dataType: 'json',
                dataSrc: 'data',
                serverSide: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'serviceName',
                        name: 'serviceName'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
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
                            return '</a> <a id="content_delete" class="btn btn-danger" data-id="' +
                                row.id + '">Delete</a>';

                        }
                    }
                ]
            })
        })
    </script>

    <script>
        $(document).on('click', '#content_add', function(e) {
            e.preventDefault();
            var form = document.getElementById('content_form');
            var formdata = new FormData(form);
            $.ajax({
                type: 'post',
                url: "{{ route('content.store') }}",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: (data) => {
                    var oTable = $("#cont_table").DataTable().ajax.reload();
                    oTable.ajax.reload();
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#content_delete', function(e) {
            var contenteId = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('admin/content') }}/" + contenteId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        $('#cont_table').DataTable().row($(this).closest('tr')).remove().draw();
                        alert('Content deleted successfully.');
                    } else {
                        alert('Error deleting Content.');
                    }
                }
            });
        });
    </script>
@endsection
@endsection
