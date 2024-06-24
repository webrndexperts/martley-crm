<section class="section-head">
	<h3 class="section-head">Dashboard</h3>

	<div class="analytics">
		@if(isset($clinitianCount))
			<a class="analytic" href="{{ route('list-clinician') }}">
				<div class="analytic-icon">
					<span class="las la-eye">
						<img src="{{ url('public/new/img/teacher.svg') }}" alt="" />
					</span>
				</div>
				<div class="analytic-info">
					<h4>Total Clinitians</h4>
					<h1>{{ $clinitianCount }}</h1>
				</div>
			</a>
		@endif

		@if(isset($patientCount))
			<a class="analytic" href="{{ route('list-patient') }}">
				<div class="analytic-icon">
					<span class="las la-clock">
						<img src="{{ url('public/new/img/patient_setting.svg') }}" alt="" />
					</span>
				</div>
				<div class="analytic-info">
					<h4>Total Patients</h4>
					<h1>{{ $patientCount }}</h1>
				</div>
			</a>
		@endif

		@if(isset($formCount))
			<a class="analytic" href="{{ route('forms.index') }}">
				<div class="analytic-icon">
					<span class="las la-users">
						<img src="{{ url('public/new/img/Form.svg') }}" alt="" />
					</span>
				</div>
				<div class="analytic-info">
					<h4>Total Forms</h4>
					<h1>{{ $formCount }}</h1>
				</div>
			</a>
		@endif

		@if(isset($assesmentCount))
			<a class="analytic" href="{{ route('assessment-list') }}">
				<div class="analytic-icon">
					<span class="las la-heart">
						<img src="{{ url('public/new/img/Assessment.svg') }}" alt="" />
					</span>
				</div>
				<div class="analytic-info">
					<h4>Total Assessments</h4>
					<h1>{{ $assesmentCount }}</h1>
				</div>
			</a>
		@endif
	</div>
</section>