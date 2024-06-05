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

        	alert(_url)


        }

        generateDataTable();
    </script>
@endpush