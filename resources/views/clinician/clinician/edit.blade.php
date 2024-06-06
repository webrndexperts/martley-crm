@extends('layouts.app')

@section('title', 'Edit/View Clinician')

@section('content')

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="x_title">
                <h2>Edit/View Clinician</h2>
                <a href="{{route('list-clinician')}}" class="btn btn-primary" style="float:right;" title="Back">Back</a>
                <div class="clearfix"></div>
            </div>

            <div class="container">
                <ul class="nav nav-tabs">

                    <li class="nav-item active">
                        <a class="nav-link" id="personal-info-tab" data-toggle="tab" href="#personal-info">Personal Information</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="contact-info-tab" data-toggle="tab" href="#contact-info">Contact Info</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="credential-tab" data-toggle="tab" href="#credential">Credentials</a>
                    </li>
                </ul>



                <form action="{{ route('update-clinician',  $clinician->id) }}" method="post">
                    @csrf
                    <div class="tab-content mt-3">

                        <!-- Tab 1: Personal Information -->

                        <div class="tab-pane fade active in" id="personal-info">
                            <h3> </h3>

                            <div class="form-group">
                                <label for="profile_photo">Profile Photo:</label>
                                <input type="file" name="profile_photo" class="form-control">
                            </div>

                            <div class="date-end">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" name="first_name" minlength="3" class="form-control" value="{{ $clinician->first_name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" name="last_name" minlength="3" class="form-control" value="{{ $clinician->last_name }}" required>
                                </div>

                            </div>
                            <div class="date-end">

                                <div class="form-group">
                                    <label for="birthday">Birthday:</label>
                                    <input type="date" name="birthday" class="form-control" value="{{ $clinician->birthday }}" required>
                                </div>

                                <div class="form-group">
                                <label for="sex">Gender:</label>
                                    <select name="sex" class="form-control">
                                        <option value="0">Select Gender:</option>
                                        <option value="{{ \App\Libraries\Enumerations\UserGender::$MALE }}" {{ $clinician->sex == 0 ? 'selected' : '' }}>Male</option>
                                        <option value="{{ \App\Libraries\Enumerations\UserGender::$FEMALE }}" {{ $clinician->sex == \App\Libraries\Enumerations\UserGender::$FEMALE ? 'selected' : '' }}>Female</option>
                                        <option value="{{ \App\Libraries\Enumerations\UserGender::$OTHER }}" {{ $clinician->sex == \App\Libraries\Enumerations\UserGender::$OTHER ? 'selected' : '' }}>Other</option>
                                        <option value="{{ \App\Libraries\Enumerations\UserGender::$PREFER_NOT_TO_SAY }}" {{ $clinician->sex == \App\Libraries\Enumerations\UserGender::$PREFER_NOT_TO_SAY ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <div class="date-end">

                                <div class="form-group">
                                <label for="status">Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="{{ \App\Libraries\Enumerations\UserStatus::$ACTIVE }}" {{ $clinician->status == \App\Libraries\Enumerations\UserStatus::$ACTIVE ? 'selected' : '' }}>Active</option>
                                        <option value="{{ \App\Libraries\Enumerations\UserStatus::$INACTIVE }}" {{ $clinician->status == \App\Libraries\Enumerations\UserStatus::$INACTIVE ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select name="user_type" class="form-control">
                                        <option value="0">Select Role:</option>
                                        <option value="{{ $clinician->user->user_type }}" {{ $clinician->user->user_type == 3 ? 'selected' : '' }}>Clinician</option>
                                        <option value="{{ $clinician->user->user_type }}" {{ $clinician->user->user_type == 4 ? 'selected' : '' }}>Patient</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <!-- Tab 2: Contact Info -->

                        <div class="tab-pane fade" id="contact-info">
                            <h3> </h3>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" value="{{ $clinician->user->email }}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="phone" name="phone" class="form-control" value="{{ $clinician->phone }}" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea id="address" name="address" class="form-control" placeholder="Enter your address">{{ $clinician->address }}</textarea>
                            </div>
                        </div>

                        <!-- Tab 3: Credentials -->

                        <div class="tab-pane fade" id="credential">
                            <h3> </h3>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" value="{{ $clinician->user->password }}" required>
                            </div>

                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary" title="Save">Save</button>
            </div>
        </div>
    </div>

@endsection
