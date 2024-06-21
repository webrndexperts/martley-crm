<div class="table-actions"> 			
	<a href="{{ route('assesments.answer.submit-view', [base64_encode($row->assesment_id), base64_encode($row->user_id)]) }}" class="btn btn-info btn-sm" title="View">
		<i class="fa fa-eye" aria-hidden="true"></i>
	</a>
</div>