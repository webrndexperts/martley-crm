@if(isset($clinitianCount))
	<div>
		<a class="counts-data" href="{{ route('list-clinician') }}">
			<span class="count">{{ $clinitianCount }}</span>
			<span class="name">Clinicians</span>
		</a>
	</div>
@endif

@if(isset($patientCount))
	<div>
		<a class="counts-data" href="{{ route('list-patient') }}">
			<span class="count">{{ $patientCount }}</span>
			<span class="name">Patients</span>
		</a>
	</div>
@endif