@extends('layouts.app')

@section('title', 'Patient List')

<!-- page content -->

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
                <h2>Patients List</h2>

                @if(Auth::user()->user_type == '2')
                    <a href="{{ route('create-patient') }}" class="pull-right btn btn-info btn-sm" title="Add Patient">
                        <i class="fa fa-plus"></i> Add Patient
                    </a>
                @endif
                
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable no-footer" id="patient_table">
                        <thead>
                            <tr>
                                <th>Sr. no.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
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
            var _url = "{{ route('patient.datatable') }}";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $('#patient_table').DataTable({
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
                    {data: 'email', className: 'email'},
                    {data: 'phone'},
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