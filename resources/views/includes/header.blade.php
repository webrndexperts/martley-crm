<div class="top_nav">

    <div class="nav_menu">
        <nav class="navbar navbar-default">
            <div class="nav toggle">
                <a id="menu_toggle">
                    <img src="{{ url('public/new/img/small-ico.png') }}">
                </a>
            </div>

            <div class="nav title">
                <h2>The Becoming Institute</h2>
            </div>
            
            <div class="profile">
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{auth()->user()->name}}
                                <span class=" fa fa-angle-down"></span> 
                                <img src="{{ url('public/admin/images/user.jpg') }}" alt="">
                            </a>

                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="{{ url('becoming-institute-crm/account') }}"> Profile</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                                            <i class="fa fa-sign-out pull-right"></i> Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o" style="font-size:16px"></i>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
    </div>
</div>