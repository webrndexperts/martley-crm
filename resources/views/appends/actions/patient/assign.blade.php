<div class="d-flex align-items-center">
	<div class="custom-list-dropdown w-50">
		<div class="dropdown">
			<p class="dropdown-toggle pointer text-center" id="formsList{{ $row->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ url('public/icons/drop-icon.svg') }}" />
			</p>

			<div class="dropdown-menu" aria-labelledby="formsList{{ $row->id }}">
				<a href="{{ route('patient.assignment.edit', base64_encode($row->id)) }}" class="dropdown-item text-primary">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit
				</a>

				<a href="{{ route('patient.assignment.delete', base64_encode($row->id)) }}" class="dropdown-item text-danger">
					<i class="fa fa-trash" aria-hidden="true"></i> Delete
				</a>
			</div>
		</div>
	</div>
</div>