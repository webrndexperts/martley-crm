@extends('layouts.app')
@section('title', 'View Submitted Answers')

@section('content')
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
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
                    <h2>View Answers Of - {{ $form->name }}</h2>

                    <a href="{{ url()->previous() }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content tabel_content">
            		@if($formAnswers && count($formAnswers) > 0)
                        @foreach($formAnswers as $k => $answer)
                            <div class="answer-div">
                                <label>{{ $answer->question->label }}</label>

                                @if($answer->question->type == 'file')
                                    <a class="answer file-type" href="{{ $answer->answer }}" target="_blank">View</a>
                                @else
                                    <div class="answer_data">
                                        <span class="answer">{{ $answer->answer }}</span>
                                  </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
	</div>
@endsection