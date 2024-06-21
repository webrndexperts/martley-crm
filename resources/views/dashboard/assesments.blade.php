@if(Auth::user()->user_type == '4')


	<div class="row">
		@if(isset($assesments) && count($assesments))
			<div class="col-md-6">
				<h3>Assessments</h3>
				@foreach($assesments as $assesment)
					<a
						@if(!$assesment->submited)
							href="{{ route('assesments.answer.submit-get', base64_encode($assesment->id)) }}"
						@endif
						class="dashboard-value-link"
					>{{ $assesment->title }}</a>
				@endforeach
			</div>
		@endif

		@if(isset($forms) && count($forms))
			<div class="col-md-6">
				<h3>Forms</h3>
				@foreach($forms as $form)
					<a
						@if(!$form->submited)
							href="{{ route('forms.submit-get', base64_encode($form->id)) }}"
						@endif
						class="dashboard-value-link"
					>{{ $form->name }}</a>
				@endforeach
			</div>
		@endif
	</div>



@endif