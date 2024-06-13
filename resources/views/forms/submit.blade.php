@extends('layouts.app')
@section('title', 'Submit Form Values')

@section('content')

	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 add_field">
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

            <div class="x_panel">
                <div class="x_title">
                    <h2>Submit - {{ $form->name }}</h2>

                    <a href="{{ route('forms.index') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
            		<form method="POST" action="{{ route('forms.submit') }}" enctype="multipart/form-data">
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
                </div>
            </div>
        </div>
	</div>

@endsection