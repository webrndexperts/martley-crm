@if(isset($clinitianCount))
	<div class="clinicians_data">
		<a class="counts-data clinician_patients" href="{{ route('list-clinician') }}">
			<span class="count">{{ $clinitianCount }}</span>
			<span class="name">Clinicians</span>
		</a>
@endif

@if(isset($patientCount))
	
		<a class="counts-data" href="{{ route('list-patient') }}">
			<span class="count">{{ $patientCount }}</span>
			<span class="name">Patients</span>
		</a>
	</div>
@endif