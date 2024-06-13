@extends('layouts.login-app')

@section('content')

    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                
                <section class="login_content">
                    <form action="{{ route('login.custom') }}" method="post">
                        {{ csrf_field() }}
                        <img src="{{url('public/new/img/image_2024_02_02T10_11_48_862Z.png') }}"> 
                            
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

                            @if(Session::has('success'))

                            <div class='alert alert-success'>
                                {{Session::get('success')}}
                            </div>

                            @endif 
                        
                            @if(Session::has('unsuccess'))
                                <div class='alert alert-danger'>
                                    {{Session::get('unsuccess')}}
                                </div>
                            @endif

                        <div>
                            <input type="text" name="email" class="form-control" placeholder="Email" required="" />
                        </div>

                        <div>
                            <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                        </div>

                        <div class="left">
                            <input type="checkbox" name="remember" />
                            <label for=""> Remember me</label>
                        </div>

                        <input id="" type="hidden" name="urlPath" value="">

                        <div>
                            <button type="submit" class="btn btn-default submit">Login</button>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </section>

                <div class="Login-img">
                    <img src="{{ url('public/new/img/crm-login.jpg') }}">
                </div>
            </div>
        </div>
    </div>

@endsection