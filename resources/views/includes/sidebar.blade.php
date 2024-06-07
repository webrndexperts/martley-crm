<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/becoming-institute-crm/" class="site_title"> <img src="{{ url('public/new/img/image_2024_02_02T10_11_48_862Z.png') }}"></a>
        </div>

        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
        </div>
        <!-- /menu profile quick info -->
        <br/>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                @if(Auth::user()->user_type == 2)

                    <ul class="nav side-menu">
                        <li class="active">
                            <a href="/becoming-institute-crm/"><img src="{{ url('public/new/img/dashboard.svg') }}">Dashboard</a>
                        </li>

                        <div class="sub_section_menu">
                            <h2 class="nav">Forms and Assessmnet</h2>
                        </div>

                        <li class="">
                            <a href="{{route('forms.index')}}">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i> Forms
                            </a>
                        </li>

                        <li class="">
                            <a href="{{route('assessment-list')}}"><img src="{{ url('public/new/img/sessions.svg') }}"> Assessments</a>
                        </li>

                        <div class="sub_section_menu">
                            <h2 class="nav">Users</h2>
                        </div>

                        <li class="">
                            <a href="{{route('list-clinician')}}"><img src="{{ url('public/new/img/teachers.svg') }}">Clinician </a>
                        </li>
                        <li class="">
                            <a href="{{route('list-patient')}}"><img src="{{ url('public/new/img/sessions.svg') }}">Patient </a>
                        </li>
                        
                        <!-- <li class="parent_item">
                            <a href="#" class="parent_link">
                                <img src="{{ url('public/new/img/msgg.svg') }}" alt="Message Center">
                                Message Center
                                <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <li><a href="#">Inbox</a></li> 
                                <li><a href="#">Sent</a></li>
                            </ul>
                        </li> -->

                    </ul>

                @elseif(Auth::user()->user_type == 3)

                    <ul class="nav side-menu">
                        <li class="active">
                            <a href="/becoming-institute-crm/"><img src="{{ url('public/new/img/dashboard.svg') }}">Dashboard</a>
                        </li>

                        <div class="sub_section_menu">
                            <h2 class="nav">Forms and Assessmnet</h2>
                        </div>

                        <li class="">
                            <a href="{{route('forms.index')}}">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i> 
                                Forms
                            </a>
                        </li>

                        <li class="">
                            <a href="{{route('assign-form-list')}}">
                                <i class="fa fa-list-alt"></i>
                                Assign Forms
                            </a>
                        </li>

                        <li class="">
                            <a href="{{route('assessment-list')}}">
                                    <i class="fa fa-building-o"></i> 
                                Assessments
                            </a>
                        </li>
                        <li class="">
                            <a href="{{route('assign-assessment-list')}}">
                                <i class="fa fa-list-alt"></i>
                                Assign Assessments
                            </a>
                        </li>

                        <div class="sub_section_menu">
                            <h2 class="nav">Users</h2>
                        </div>

                        <li class="">
                            <a href="{{route('list-patient')}}">
                                <img src="{{ url('public/new/img/sessions.svg') }}">
                                Patient 
                            </a>
                        </li>
                        
                        <!-- <li class="parent_item">
                            <a href="#" class="parent_link">
                                <img src="{{ url('public/new/img/msgg.svg') }}" alt="Message Center">
                                Message Center
                                <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <li><a href="#">Inbox</a></li> 
                                <li><a href="#">Sent</a></li>
                            </ul>
                        </li> -->

                    </ul>

                @else(Auth::user()->user_type == 4)

                    <ul class="nav side-menu">
                        <li class="active">
                            <a href="/becoming-institute-crm/"><img src="{{ url('public/new/img/dashboard.svg') }}">Dashboard</a>
                        </li>

                        <div class="sub_section_menu">
                            <h2 class="nav">Forms and Assessmnet</h2>
                        </div>

                        <li class="">
                            <a href="{{route('forms.index')}}">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i> Forms
                            </a>
                        </li>

                        <li class="">
                            <a href="{{route('assessment-list')}}"><img src="{{ url('public/new/img/sessions.svg') }}"> Assessments</a>
                        </li>

                        <div class="sub_section_menu">
                            <h2 class="nav">Users</h2>
                        </div>

                        <li class="">
                            <a href="{{route('patient-clinician-list')}}"><img src="{{ url('public/new/img/teachers.svg') }}">Clinician </a>
                        </li>
                        
                        <!-- <li class="parent_item">
                            <a href="#" class="parent_link">
                                <img src="{{ url('public/new/img/msgg.svg') }}" alt="Message Center">
                                Message Center
                                <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <li><a href="#">Inbox</a></li> 
                                <li><a href="#">Sent</a></li>
                            </ul>
                        </li> -->

                    </ul>

                @endif
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