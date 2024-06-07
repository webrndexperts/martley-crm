@extends('layouts.app')

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
                    <h2>View - {{ $form->name }}</h2>

                    <a href="{{ route('forms.index') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
            		
                </div>
            </div>
        </div>
	</div>
@endsection