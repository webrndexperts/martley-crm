<div class="d-flex align-items-center">
	<div class="custom-list-dropdown w-50">
		<div class="dropdown">
			<p class="dropdown-toggle pointer text-center" id="formsList{{ $row->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ url('public/icons/drop-icon.svg') }}" />
			</p>
			<div class="dropdown-menu" aria-labelledby="formsList{{ $row->id }}">
				@if(Auth::user()->user_type == 2)
					<a href="{{ route('edit-clinician', $row->id) }}" class="dropdown-item text-primary">
						<i class="fa fa-pencil" aria-hidden="true"></i> Edit
					</a>

					@if($row->user->status === '1')
                        <a href="{{ route('deactive-clinician', $row->user->id) }}" class="dropdown-item text-danger" title="Deactive">
                            <i class="fa fa-ban" aria-hidden="true"></i> Deactivate
                        </a>
                    @else
                        <a href="{{ route('active-clinician', $row->user->id) }}" class="dropdown-item text-success" title="Active">
                            <i class="fa fa-check" aria-hidden="true"></i> Activate
                        </a>
                    @endif
				@endif
			</div>
		</div>
	</div>
</div>