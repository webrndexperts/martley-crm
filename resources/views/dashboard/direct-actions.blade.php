<div class="actions-direct">

	@if(Auth::user()->user_type == 2)
		<div class="row">
			<h2>Quick Actions</h2>

            <div class="col-md-3">
                <a href="{{ route('create-patient') }}" class="card">
                    <p>
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        <span>Create Patient</span>
                    </p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('create-clinician') }}" class="card">
                    <p>
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        <span>Create Clinician</span>
                    </p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('create-assessment') }}" class="card">
                    <p>
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        <span>Create Assesment</span>
                    </p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('forms.create') }}" class="card">
                    <p>
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        <span>Create Form</span>
                    </p>
                </a>
            </div>
		</div>
	@endif
</div>