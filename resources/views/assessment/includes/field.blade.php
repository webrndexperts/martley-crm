@if($question->question_type == 'input')
	<div class="form-group">
		@if($question->question) <label>{{ $question->question }}</label> @endif

		<input
			type="input"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			placeholder="{{ $question->question }}"
		/>
	</div>
@endif

@if($question->question_type == 'textarea')
	<div class="form-group">
		@if($question->question) <label>{{ $question->question }}</label> @endif

		<textarea
			class="form-control"
			rows="3"
			name="answers[{{ $k }}][answer]"
			placeholder="{{ $question->question }}"
		></textarea>
	</div>
@endif

@if($question->question_type == 'radio')
	<div class="form-group">
		@if($question->question) <label>{{ $question->question }}</label> @endif

		@foreach($options as $mk => $mcq)
			<span>
				<input
					type="radio"
					@if($mk == 0) checked @endif
					class="form-control  redio_btns"
					name="answers[{{ $k }}][answer]"
					value="{{ $mcq }}"
				/>
				{{ $mcq }}
			</span>
		@endforeach
	</div>
@endif