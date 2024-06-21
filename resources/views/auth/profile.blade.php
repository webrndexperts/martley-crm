@extends('layouts.app')
@section('title', "Add New Form")

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 add_field">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Profile</h2>

                    <a href="{{ url('/') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
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

                    <form method="POST" action="{{ route('profile.save') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 form-group profile-pic-main">
                                <img src="{{ (Auth::user()->profile) ? url(Auth::user()->profile) : url('public/admin/images/user.jpg') }}" class="profile-pic" alt="profile" />

                                <label>Profile Pic</label>
                                <input type="file" name="profile_pic" class="form-field" accept="image/*" />
                            </div>
                        </div>

                        <div class="row">
                            @if(Auth::user()->user_type == '2')
                                <div class="col-md-12 form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-field @error('name') is-invalid @enderror" value="{{ $user->name }}" placeholder="Name" name="name" required />

                                    @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @else
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-field @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}" placeholder="First Name" name="first_name" required />

                                    @error('first_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-field @error('last_name') is-invalid @enderror" value="{{ $user->last_name }}" placeholder="Last Name" name="last_name" required />

                                    @error('last_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-12 form-group">
                                <label>Email</label>
                                <input type="text" class="form-field" value="{{ Auth::user()->email }}" readonly disabled placeholder="email" />
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <input id="password" placeholder="Password" type="password" class="form-field @error('password') is-invalid @enderror" name="password" autocomplete="new-password" />

                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-field" name="password_confirmation" autocomplete="new-password" />
                            </div>
                        

                            <div class="col-md-12 form-group mt-10">
                                <button class="btn btn-info" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection