<div class="table-actions"> 
	@if(Auth::user()->user_type == 4)
		@if(!$row->submited)
			<a href="{{ route('forms.submit-get', base64_encode($row->id)) }}" class="btn btn-info btn-sm" title="Fill">
				<i class="fa fa-file-word-o" aria-hidden="true"></i>
			</a>
		@endif
	@else	
		@if(Auth::user()->user_type == 2 || Auth::user()->user_type == 3)
			<a href="{{ route('forms.submit-list', base64_encode($row->id)) }}" class="btn btn-info btn-sm">
				<i class="fa fa-list-alt" aria-hidden="true"></i>
			</a>
		@endif

		@if(Auth::user()->user_type == 2)
			<a href="{{ route('forms.edit', base64_encode($row->id)) }}" class="btn btn-info btn-sm" title="Edit">
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>

			<a
				class="btn btn-info btn-sm table-form-btn"
				title="Delete"
				onclick="return confirm('Are you sure, you want to delete {{ $row->name }} form?')"
			>
				<form action="{{ route('forms.destroy', base64_encode($row->id)) }}" method="POST">
					@csrf
					@method('DELETE')
					<button type="submit">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
				</form>
			</a>
		@endif
	@endif
</div>