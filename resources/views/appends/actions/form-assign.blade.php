<div class="table-actions"> 
	@if(Auth::user()->user_type == 2 || $row->user_id == Auth::user()->id)
		<a href="{{ route('edit-assigned-form', $row->id) }}" class="btn btn-info btn-sm" title="Edit">
			<i class="fa fa-pencil" aria-hidden="true"></i>
		</a>

		<a
			class="btn btn-info btn-sm table-form-btn"
			title="Delete"
			onclick="return confirm('Are you sure, you want to delete Form Assignment?')"
		>
			<form action="{{ route('destroy-assigned-form', $row->id) }}" method="POST">
				@csrf
				@method('DELETE')
				<button type="submit">
					<i class="fa fa-trash" aria-hidden="true"></i>
				</button>
			</form>
		</a>
	@endif
</div>