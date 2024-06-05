@extends('layouts.app')

@section('content')
	<section class="form-section">
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

		<a href="{{ route('forms.create') }}">Create</a>


		<div class="table-responsive">
	  		<table class="table align-middle table-striped" id="forms_table">
				<thead>
					<tr>
						<th scope="col">Sr. No</th>
						<th scope="col">Name</th>
						<th scope="col">Created By</th>
						<th scope="col">Created Date</th>
						<th scope="col">Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        function generateDataTable() {
        	var _url = "{{ route('forms.datatable') }}";
        	let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        	$('#forms_table').DataTable({
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
					{data: 'user'},
					{data: 'created_at'},
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