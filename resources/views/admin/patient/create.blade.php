@extends('layouts.app')

@section('title', 'Create Patient')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

                @if(isset($errors))
                    @if ( count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="x_title">
                <a href="{{route('list-patient')}}" class="btn btn-primary" style="float:right;" title="Back">Back</a>
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

                <form action="{{ route('save-patient') }}" method="post" enctype="multipart/form-data">
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

                                <input type="text" name="first_name" class="form-control" minlength="3" value="{{old('first_name')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name:</label>

                                <input type="text" name="last_name" class="form-control" minlength="3"  value="{{old('last_name')}}" required>
                            </div>
                        </div>
                        <div class="date-end">
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>

                                <input type="date" name="birthday" class="form-control" value="{{old('birthday')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="sex">Gender:</label>

                                <select name="sex" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option @if(old('sex') == '0') selected @endif value="0">Male</option>
                                    <option @if(old('sex') == '1') selected @endif value="1">Female</option>
                                    <option @if(old('sex') == '2') selected @endif value="2">Other</option>
                                    <option @if(old('sex') == '3') selected @endif value="3">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                            <div class="form-group">
                                <label for="status">Status:</label>

                                <select name="status" class="form-control" value="{{old('status')}}">
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                            </div>
                        </div>


                        <!-- Tab 2: Contact Info -->

                        <div class="tab-pane fade" id="contact-info">

                            <h3> </h3>

                            <div class="form-group">
                                <label for="email">Email:</label>

                                <input type="email" name="email" class="form-control" value="{{old('email')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone:</label>

                                <input type="phone" name="phone" class="form-control" value="{{old('phone')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:</label>
                                
                                <textarea id="address" name="address" class="form-control" placeholder="Enter your address">{{old('address')}}</textarea>
                            </div>
                        </div>



                        <!-- Tab 3: Credentials -->

                        <div class="tab-pane fade" id="credential">

                            <h3> </h3>

                            <div class="form-group">

                                <label for="password">Password:</label>

                                <input type="password" name="password" value="{{old('password')}}" class="form-control">

                            </div>

                        </div>                      

                    </div>

                    <button type="submit" class="btn btn-primary" title="Save">Save</button>
            </div>
        </div>
    </div>
@endsection
