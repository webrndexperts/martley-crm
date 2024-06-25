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
                    <h2>View Answers Of - {{ $assessment->title }}</h2>

                    <a href="{{ route('assessment-list') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    @if($answers && count($answers) > 0)
                        @foreach($answers as $k => $answer)
                            <div class="answer-div">
                                <label>{{ $answer->question->question }}</label>

                                @if($answer->question->question_type == 'file')
                                    <a class="file-type" href="{{ $answer->answer }}" target="_blank">View</a>
                                @else
                                    <span class="answer">{{ $answer->answer }}</span>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection