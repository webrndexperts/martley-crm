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
		<a href="{{ route('forms.edit', ['form' => base64_encode(1)]) }}">Update</a>


		<div class="table-responsive">
	  		<table class="table align-middle table-striped" id="forms-table">
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

        	jQuery('#forms-table').DataTable({
				"lengthMenu": [ [10, 50, 100, -1], [10, 50, 100, "All"] ],
				processing: true,
				serverSide: true,
				processing: true,
				order: [[ 0, "DESC" ]],
				ajax: {
					'url': _url,
					'type': 'post',
					"dataType": "json"
				},
				columns: [
					{data: 'name', width: "15%"},
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