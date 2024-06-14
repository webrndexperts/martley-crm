<div class="d-flex align-items-center">
	<div class="custom-list-dropdown w-50">
		<div class="dropdown">
			<p class="dropdown-toggle pointer text-center" id="assesmentAnswerList{{ $row->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ url('public/icons/drop-icon.svg') }}" />
			</p>
			<div class="dropdown-menu" aria-labelledby="assesmentAnswerList{{ $row->id }}">					
				<a href="{{ route('assesments.answer.submit-view', [base64_encode($row->assesment_id), base64_encode($row->user_id)]) }}" class="dropdown-item text-primary">
					<i class="fa fa-eye" aria-hidden="true"></i> View
				</a>
			</div>
		</div>
	</div>
</div>