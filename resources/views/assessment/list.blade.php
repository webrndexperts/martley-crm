@extends('layouts.app')
@section('title', 'Assessments')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Assessments</h2>
                @if(Auth::user()->user_type == 2)
                    <a href="{{ route('create-assessment') }}" class="pull-right btn btn-info btn-sm" title="Add Clinical Assessment">
                        <i class="fa fa-plus"></i> Create
                    </a>
                @endif
                
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable no-footer" id="assesments_table">
                        <thead>
                            <tr>
                                <th>Sr. no.</th>
                                <th>Assessment Name</th>                   
                                <th>Description</th>                       
                                <th>Due Date</th>                       
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function generateDataTable() {
            var _url = "{{ route('assesments.datatable') }}";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $('#assesments_table').DataTable({
                "lengthMenu": [ [10, 50, 100, -1], [10, 50, 100, "All"] ],
                processing: true,
                serverSide: true,
                processing: true,
                order: [[ 0, "DESC" ]],
                ajax: {
                    'url': _url,
                    'type': 'post',
                    "dataType": "json",
                    "beforeSend": function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                columns: [
                    {
                        "data": "DT_RowIndex",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'name'},
                    {data: 'description'},
                    {data: 'date'},
                    {data: 'actions', orderable: false, searchable: false}
                ],
                "language":{
                    "processing": '<div class="loader-image"></div>',
                },
                "dom": '<"top table-search-flds d-flex align-items-center justify-content-between"fl>rt<"bottom table-paginater"ip><"clear">'
            });
        }

        generateDataTable();
    </script>
@endpush