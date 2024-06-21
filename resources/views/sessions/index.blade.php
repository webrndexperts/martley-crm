@extends('layouts.app')

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
	            <h2>Sessions and Meetings</h2>

	            @if(Auth::user()->user_type == '2' || Auth::user()->user_type == '3')
		            <a href="{{ route('sessions.create') }}" class="pull-right btn btn-info btn-sm">
		            	<i class="fa fa-plus" aria-hidden="true"></i> Create
		            </a>
	            @endif
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">
				<div class="table-responsive">
			  		<table class="table align-middle table-striped" id="forms_table">
						<thead>
							<tr>
								<th scope="col">Sr. No</th>
								<th scope="col">Clinician</th>
								<th scope="col">Session Title</th>
								<th scope="col">Start Date/Time</th>
								<th scope="col">End Date/Time</th>
								<th scope="col">File Upload</th>
								<th scope="col">Meeting Link</th>
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
    	function createLink(data, text = "Open Link", noData = "No Meeting URL Available") {
    		var value = noData;

    		if(data) {
    			value = `<a href="${data}" class="table-anchor" target="_blank" >${text}</a>`;
    		}
    		
    		return value;
    	}

        function generateDataTable() {
        	var _url = "{{ route('sessions.datatable') }}";
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
					{data: 'clinician'},
					{data: 'session'},
					{data: 'start_date'},
					{data: 'end_date'},
	                {data: 'file',
						render: function (data, type, row, meta) {
	                        return createLink(data, 'View', "No File Uploaded");
	                    }, orderable: false, searchable: false
	                },
					{data: 'meeting', orderable: false, searchable: false },
					{data: 'actions', orderable: false, searchable: false}
				],
				"language":{
					"processing": '<div class="loader-image"></div>',
				},
				"dom": '<"top table-search-flds d-flex align-items-center justify-content-between"fl>rt<"bottom table-paginater"ip><"clear">'
			});
        }


        function openZoomMeeting(meetingId, password) {
	        var url = `https://success.zoom.us/wc/join/${meetingId}?from=join&pwd=${password}`;
	        var win = window.open(url, '_blank', 'width=800,height=600');
	        win.focus();
	    }



        generateDataTable();
    </script>
@endpush