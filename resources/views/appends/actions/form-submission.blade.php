<div class="table-actions"> 
	<a href="{{ route('forms.submit-view', [base64_encode($row->form_id), base64_encode($row->user_id)]) }}" class="btn btn-info  btn-sm" title="View">
		<i class="fa fa-eye" aria-hidden="true"></i>
	</a>
</div>