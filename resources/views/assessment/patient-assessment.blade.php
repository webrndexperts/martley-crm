@extends('layouts.app')
@section('title', 'Submitted forms list')

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
	            <h2>Submitted Assessments list of - {{ $patient->first_name }} {{ $patient->last_name }}</h2>

	            <a href="{{ route('list-patient') }}" class="btn btn-primary" style="float:right;" title="Back">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                </a>
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">
				<div class="table-responsive">
			  		<table class="table align-middle table-striped" id="forms_table">
						<thead>
							<tr>
								<th scope="col">Sr. No</th>
								<th scope="col">Assessment Name</th>
								<th scope="col">Submission Date</th>
								<th scope="col">Actions</th>
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
        	var id = "{{ $patient->user->id }}";
        	var _url = "{{ route('assessment.patient.submit.list', ':patient_id') }}".replace(':patient_id', id);
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
					{data: 'created_at'},
					{data: 'actions', orderable: false, searchable: false}
				],
				"language":{
					"processing": `<div class="loader-image"></div>`,
				},
				"dom": '<"top table-search-flds d-flex align-items-center justify-content-between"fl>rt<"bottom table-paginater"ip><"clear">'
			});
        }

        generateDataTable();
    </script>
@endpush