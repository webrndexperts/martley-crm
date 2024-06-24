@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-page">
                    <main>
                        @include('dashboard.counts')

                        @include('dashboard.direct-actions')

                        @include('dashboard.assesments')
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    
@endpush
