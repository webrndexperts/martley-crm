<div class="d-flex align-items-center">
	<div class="custom-list-dropdown w-50">
		<div class="dropdown">
			<p class="dropdown-toggle pointer text-center" id="formsList{{ $row->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ url('public/icons/drop-icon.svg') }}" />
			</p>
			<div class="dropdown-menu" aria-labelledby="formsList{{ $row->id }}">
				@if(Auth::user()->user_type == 2 || $row->user_id == Auth::user()->id)
					<a href="{{ route('edit-assigned-form', $row->id) }}" class="dropdown-item text-primary">
						<i class="fa fa-pencil" aria-hidden="true"></i> Edit
					</a>

					<a class="dropdown-item text-danger">
						<form action="{{ route('destroy-assigned-form', $row->id) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit">
								<i class="fa fa-trash" aria-hidden="true"></i> Delete
							</button>
						</form>
					</a>
				@endif
			</div>
		</div>
	</div>
</div>