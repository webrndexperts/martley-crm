<section class="section-head">
	<h3 class="section-head">Dashboard</h3>

	<div class="analytics">
		@if(isset($clinitianCount))
			<a class="analytic" href="{{ route('list-clinician') }}">
				<div class="analytic-icon">
					<span class="las la-eye">
						<i class="fa fa-eye" style="font-size:20px"></i>
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
						<i class="fa fa-clock-o" style="font-size:20px"></i>
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
						<i class="fa fa-user" style="font-size:20px"></i>
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
						<i class="fa fa-heart" style="font-size:20px;"></i>
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