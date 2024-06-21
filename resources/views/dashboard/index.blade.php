@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    @include('dashboard.counts')

                    @include('dashboard.direct-actions')

                    @include('dashboard.assesments')

                    @if(Auth::user()->user_type == 2)

                        <h2>{{Auth::user()->name}} <span> , you are logged in and your role is Admin .</span> </h2>

                    @elseif(Auth::user()->user_type == 3)

                        <h2>{{Auth::user()->name}} <span> , you are logged in and your role is Clinician .</span> </h2>

                    @else(Auth::user()->user_type == 4)

                        <h2>{{Auth::user()->name}} <span> , you are logged in and your role is Patient .</span> </h2>

                    @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    
@endpush
