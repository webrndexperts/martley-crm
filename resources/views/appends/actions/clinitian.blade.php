<div class="table-actions">
	@if(Auth::user()->user_type == 2)
		<a href="{{ route('edit-clinician', $row->id) }}" class="btn btn-info btn-sm" title="Edit">
			<i class="fa fa-pencil" aria-hidden="true"></i>
		</a>

		@if($row->user->status === '1')
            <a
	            onclick="return confirm('Are you sure, you want to deactivate {{ $row->first_name }} {{ $row->last_name  }}?')"
	            href="{{ route('deactive-clinician', $row->user->id) }}"
	            class="btn btn-info btn-sm"
	            title="Deactivate"
            >
                <i class="fa fa-ban" aria-hidden="true"></i>
            </a>
        @else
            <a
            	onclick="return confirm('Are you sure, you want to activate {{ $row->first_name }} {{ $row->last_name  }}?')"
	            href="{{ route('active-clinician', $row->user->id) }}"
	            class="btn btn-info btn-sm"
	            title="Activate"
            >
                <i class="fa fa-check" aria-hidden="true"></i>
            </a>
        @endif
	@endif
</div>