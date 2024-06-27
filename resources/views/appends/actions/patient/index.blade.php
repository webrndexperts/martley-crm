<div class="table-actions action_icon">
	@if(Auth::user()->user_type == 2)
		<a href="{{ route('edit-patient', $row->id) }}" class="btn btn-info btn-sm">
			<i class="fa fa-pencil" aria-hidden="true"></i>
		</a>

		@if($row->user->status === '1')
            <a
            	onclick="return confirm('Are you sure, you want to deactivate {{ $row->first_name }} {{ $row->last_name  }}?')"
	            href="{{ route('patient.deactivate', $row->user->id) }}"
	            class="btn btn-info btn-sm red_box"
	            title="Deactivate"
            >
                <i class="fa fa-ban" aria-hidden="true"></i>
            </a>
        @else
            <a
            	onclick="return confirm('Are you sure, you want to activate {{ $row->first_name }} {{ $row->last_name  }}?')"
            	href="{{ route('patient.activate', $row->user->id) }}"
            	class="btn btn-info btn-sm green_box"
            	title="Activate"
            >
                <i class="fa fa-check" aria-hidden="true"></i>
            </a>
        @endif
    @elseif(Auth::user()->user_type == 3)
    	<a href="{{ route('assign-assessment', ['id' => base64_encode($row->id)]) }}" class="btn btn-info btn-sm" title="Assign Assessment">
			<img src="{{ url('public/new/img/Assessment.svg') }}">
		</a>

		<a href="{{ route('assign-form', ['id' => base64_encode($row->id)]) }}" class="btn btn-info btn-sm" title="Assign Form">
			<img src="{{ url('public/new/img/Form.svg') }}">
		</a>
	@endif

	<a href="{{ route('forms.patient.submitted', ['id' => base64_encode($row->id)]) }}" class="btn btn-info btn-sm" title="Submitted Forms">
		<img src="{{ url('public/new/img/form-submission.svg') }}">
	</a>

	<a href="{{ route('assessment.patient.submitted', ['id' => base64_encode($row->id)]) }}" class="btn btn-info btn-sm" title="Submitted Assessments">
		<img src="{{ url('public/new/img/view_s.svg') }}">
	</a>
</div>