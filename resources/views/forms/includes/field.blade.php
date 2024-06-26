@if($field->type == 'email')
	<div class="form-group">
		@if($field->label) <label>{{ $field->label }}</label> @endif

		<input
			type="email"
			class="form-field"
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
			class="form-field"
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
			class="form-field"
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
			class="form-control"
			rows="3"
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
			class="form-field"
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
			class="form-field"
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
			class="form-field"
			name="answers[{{ $k }}][answer]"
			@if(property_exists($options, 'required')) required @endif
			@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
		/>
	</div>
@endif

@if($field->type == 'checkbox')
	<div class="form-group">
		<label class="submit_all_fields">
			<input
				type="checkbox"
				class="form-field redio_btns"
				value="1"
				name="answers[{{ $k }}][answer]"
				@if(property_exists($options, 'required')) required @endif
				@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
			/>

			<span>{{ $field->label }}</span>
		</label>
	</div>
@endif

@if($field->type == 'mcq')
	<div class="form-group ">
		@if($field->label) 
		<label>{{ $field->label }}</label> 

		<div class="submit_all_fields">
		@endif
		@if(property_exists($options, 'mcq'))
			@foreach($options->mcq as $mk => $mcq)
				<span>
					<input
						type="radio"
						@if($mk == 0) checked @endif
						class="form-control redio_btns"
						name="answers[{{ $k }}][answer]"
						value="{{ $mcq }}"
						@if(property_exists($options, 'required')) required @endif
						@if(property_exists($options, 'placeholder')) placeholder="{{ $options->placeholder }}" @endif
					/>
					{{ $mcq }}
				</span>
			@endforeach
		@endif
	</div>
	</div>
@endif