@if(Auth::user()->user_type == 4)
	@if(!$row->submited)
		<a href="{{ route('forms.submit-get', base64_encode($row->id)) }}" class="btn btn-info btn-sm" title="Fill">
			<i class="fa fa-file-word-o" aria-hidden="true"></i>
		</a>
	@else

	@endif
@else
	<div class="d-flex align-items-center">
		<div class="custom-list-dropdown w-50">
			<div class="dropdown">
				<p class="dropdown-toggle pointer text-center" id="formsList{{ $row->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="{{ url('public/icons/drop-icon.svg') }}" />
				</p>
				<div class="dropdown-menu" aria-labelledby="formsList{{ $row->id }}">	
					@if(Auth::user()->user_type == 2 || Auth::user()->user_type == 3)
						<a href="{{ route('assesments.submit-list', base64_encode($row->id)) }}" class="dropdown-item text-secondary">
							<i class="fa fa-list-alt" aria-hidden="true"></i> Submissions
						</a>
					@endif

					<a href="{{ route('show-assessment', $row->id) }}" class="dropdown-item text-secondary" title="View">
						<i class="fa fa-eye" aria-hidden="true"></i> View
					</a>

					@if(Auth::user()->user_type == 2 || Auth::user()->id == $row->user_id)
						<a href="{{ route('edit-assessment', $row->id) }}" class="dropdown-item text-primary">
							<i class="fa fa-pencil" aria-hidden="true"></i> Edit
						</a>

						<a class="dropdown-item text-danger">
							<form action="{{ route('destroy-assessment', $row->id) }}" method="POST">
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
@endif