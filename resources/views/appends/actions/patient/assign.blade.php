<div class="table-actions"> 
	<a href="{{ route('patient.assignment.edit', base64_encode($row->id)) }}" class="btn btn-info btn-sm" title="Edit">
		<i class="fa fa-pencil" aria-hidden="true"></i>
	</a>

	<a
		onclick="return confirm('Are you sure, you want to delete patient assigned to clinitian?')"
		href="{{ route('patient.assignment.delete', base64_encode($row->id)) }}"
		class="btn btn-info btn-sm"
		title="Delete"
	>
		<i class="fa fa-trash" aria-hidden="true"></i>
	</a>
</div>