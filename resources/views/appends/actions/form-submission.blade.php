<div class="d-flex align-items-center">
	<div class="custom-list-dropdown w-50">
		<div class="dropdown">
			<p class="dropdown-toggle pointer text-center" id="formsList{{ $row->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ url('public/icons/drop-icon.svg') }}" />
			</p>
			<div class="dropdown-menu" aria-labelledby="formsList{{ $row->id }}">					
				<a href="{{ route('forms.submit-view', [base64_encode($row->form_id), base64_encode($row->user_id)]) }}" class="dropdown-item text-primary">
					<i class="fa fa-eye" aria-hidden="true"></i> View
				</a>
			</div>
		</div>
	</div>
</div>