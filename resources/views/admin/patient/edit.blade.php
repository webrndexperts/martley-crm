@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_title">
                <h2>Edit/View Patient</h2>
                <a href="{{route('list-patient')}}" class="btn btn-primary" style="float:right;" title="Back">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                </a>
                <div class="clearfix"></div>
            </div>

            <div class="container">
                @if(isset($errors))
                    @if ( count($errors) > 0)
                        <ul class="error-list-none form-errors">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('success') }}
                    </div>
                @endif

                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" id="personal-info-tab" data-toggle="tab" href="#personal-info">Personal Information</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="contact-info-tab" data-toggle="tab" href="#contact-info">Contact Info</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link" id="credential-tab" data-toggle="tab" href="#credential">Credentials</a>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link" id="password-tab" data-toggle="tab" href="#password">Update Password</a>
                    </li>
                </ul>

                <form action="{{ route('update-patient',  $patient->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content mt-3">

                        <!-- Tab 1: Personal Information -->
                        <div class="tab-pane fade active in" id="personal-info">
                            <h3> </h3>

                            <div class="form-group">
                                <img src="{{ ($patient->user && $patient->user->profile) ? url($patient->user->profile) : url('public/admin/images/user.jpg') }}" alt="" class="form-profile-pic">

                                <div class="p-image">
                                   <i class="fa fa-camera upload-button"></i>
                                    <input class="file-upload" name="profile_photo" type="file" accept="image/*" />
                                </div>
                            </div>

                            <div class="date-end">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" name="first_name" minlength="3" class="form-control" value="{{ $patient->first_name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" name="last_name" minlength="3" class="form-control" value="{{ $patient->last_name }}" required>
                                </div>

                            </div>
                            <div class="date-end">

                                <div class="form-group">
                                    <label for="birthday">Birthday:</label>
                                    <input type="date" name="birthday" class="form-control" value="{{ $patient->birthday }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select Gender:</option>
                                        <option value="0" {{ $patient->sex == '0' ? 'selected' : '' }}>Male</option>
                                        <option value="1" {{ $patient->sex == '1' ? 'selected' : '' }}>Female</option>
                                        <option value="2" {{ $patient->sex == '2' ? 'selected' : '' }}>Other</option>
                                        <option value="3" {{ $patient->sex == '3' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <div class="date-end">

                                <div class="form-group">
                                <label for="status">Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $patient->user->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $patient->user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Contact Info -->

                        <div class="tab-pane fade" id="contact-info">
                            <h3> </h3>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" value="{{ $patient->user->email }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="phone" name="phone" class="form-control" value="{{ $patient->phone }}" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea id="address" name="address" class="form-control" placeholder="Enter your address">{{ $patient->address }}</textarea>
                            </div>
                        </div>

                        <!-- Tab 3: Credentials -->

                        <!-- <div class="tab-pane fade" id="credential">
                            <h3> </h3>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" />
                            </div>
                        </div> -->

                        <div class="tab-pane fade" id="password">
                            <h3> </h3>

                            <div class="form-group">
                                <label for="password">New Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Add New Password" value="" />
                            </div>

                            <div class="form-group">
                                <label for="password">Confirm Password:</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" value="" />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" title="Save">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection
