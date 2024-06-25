<div class="table-actions "> 
	@if(Auth::user()->user_type == 2 || Auth::user()->id == $row->user_id)
		<a href="{{ route('sessions.edit', base64_encode($row->id)) }}" class="btn btn-info btn-sm" title="Edit">
			<i class="fa fa-pencil" aria-hidden="true"></i>
		</a>

		<a
			class="btn btn-info btn-sm table-form-btn"
			title="Delete"
			onclick="return confirm('Are you sure, you want to delete {{ $row->title }} session?')"
		>
			<form action="{{ route('sessions.destroy', base64_encode($row->id)) }}" method="POST">
				@csrf
				@method('DELETE')
				<button type="submit">
					<i class="fa fa-trash" aria-hidden="true"></i>
				</button>
			</form>
		</a>
	@endif

	@if($meeting)
		<a @if(Auth::user()->user_type == 2) target="_blank" href="{{ $meeting->start_url }}" @else onclick="openZoomMeeting('{{ $meeting->zoom_id }}', '{{ $meeting->password }}')" @endif class="btn btn-info  btn-sm" title="Join Meeting">
			<i class="fa fa-sign-in" aria-hidden="true"></i>
		</a>
	@endif

</div>