@if($field->type == 'email')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif

		<input
			type="email"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'password')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif
		
		<input
			type="password"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'input')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif
		
		<input
			type="text"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'textarea')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif
		
		<textarea
			type="password"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		></textarea>
	</div>
@endif

@if($field->type == 'file')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif
		
		<input
			type="file"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'number')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif
		
		<input
			type="number"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'tel')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif
		
		<input
			type="tel"
			class="form-control"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'mcq')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif

		@if(property_exists($options, 'mcq'))
			@foreach($options->mcq as $mk => $mcq)
				<label>
					<input
						type="radio"
						@if($mk == 0) checked @endif
						class="form-control"
						name="answers[{{ $k }}][answer]"
						value="{{ $mcq }}"
						@if(property_exists($options, 'required')) required @endif
						@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
					/>
					{{ $mcq }}
				</label>
			@endforeach
		@endif
	</div>
@endif