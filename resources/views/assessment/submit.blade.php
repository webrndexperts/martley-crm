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
                    <h2>Submit - {{ $assessment->title }}</h2>

                    <a href="{{ route('assessment-list') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
            		<form method="POST" action="{{ route('assesments.answer.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}" />

                        @if(count($assessment->questions) > 0)
                        	@foreach($assessment->questions as $k => $question)
                        		<input type="hidden" name="answers[{{ $k }}][id]" value="{{ $question->id }}" />
                        		<input type="hidden" name="answers[{{ $k }}][type]" value="{{ $question->question_type }}" />
                        		<?php $options = ($question->answer) ? explode(',', $question->answer) : array(); ?>

                        		@include('assessment.includes.field')

                        	@endforeach
                        @endif

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
	</div>

@endsection