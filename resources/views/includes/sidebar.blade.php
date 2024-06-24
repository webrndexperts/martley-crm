<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title"> <img src="{{ url('public/new/img/logo.png') }}"></a>
        </div>

        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
        </div>
        <!-- /menu profile quick info -->
        <br/>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li class="{{ Request::is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}">
                            <img src="{{ url('public/new/img/dashboard.svg') }}"> Dashboard
                        </a>
                    </li>

                    <div class="sub_section_menu">
                        <h2 class="nav">Forms and Assessmnet</h2>
                    </div>

                    <li class="">
                        <a href="{{route('forms.index')}}">
                        <img src="{{ url('public/new/img/Form.svg') }}"> Forms
                        </a>
                    </li>

                    <li class="">
                        <a href="{{route('assessment-list')}}">
                        <img src="{{ url('public/new/img/Assessment.svg') }}"> Assessments
                        </a>
                    </li>

                    @if(Auth::user()->user_type == '2' || Auth::user()->user_type == '3')
                        <li class="">
                            <a href="{{route('assign-form-list')}}">
                            <img src="{{ url('public/new/img/Assign.svg') }}"> Assign Forms
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->user_type == '3')
                        <li class="">
                            <a href="{{route('assign-assessment-list')}}">
                                <i class="fa fa-list-alt"></i>
                                Assign Assessments
                            </a>
                        </li>
                    @endif

                    <li class="">
                        <a href="{{route('sessions.index')}}">
                        <img src="{{ url('public/new/img/Form.svg') }}"> Sessions
                        </a>
                    </li>

                    @if(Auth::user()->user_type == '2' || Auth::user()->user_type == '3')
                        <div class="sub_section_menu">
                            <h2 class="nav">Users</h2>
                        </div>
                    @endif

                    @if(Auth::user()->user_type == '2')
                        <li class="">
                            <a href="{{route('list-clinician')}}">
                                <img src="{{ url('public/new/img/teacher.svg') }}"> Clinician
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->user_type == '2' || Auth::user()->user_type == '3')
                        <li class="">
                            <a href="{{route('list-patient')}}">
                                <img src="{{ url('public/new/img/sessions.svg') }}"> Patient
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->user_type == '2')
                        <li class="">
                            <a href="{{ route('patient.assignment.get') }}">
                                <i class="fa fa-list-alt"></i> Assign Patient
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>


        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="/public/logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>