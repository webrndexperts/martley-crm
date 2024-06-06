@extends('layouts.app')

@section('content')

	<section class="view-form">
		@if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('forms.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>

		<form method="POST" action="{{ route('forms.submit') }}" enctype="multipart/form-data">
			<h2>{{ $form->name }}</h2>
            @csrf

            <input type="hidden" name="form_id" value="{{ $form->id }}" />

            @if(count($form->fields) > 0)
            	@foreach($form->fields as $k => $field)
            		<input type="hidden" name="answers[{{ $k }}][id]" value="{{ $field->id }}" />
            		<input type="hidden" name="answers[{{ $k }}][type]" value="{{ $field->type }}" />
            		<?php $options = json_decode($field->options); ?>

            		@include('forms.includes.field')

            	@endforeach
            @endif

            <button type="submit">{{ $form->submit }}</button>
        </form>
	</section>

@endsection