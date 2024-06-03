<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/becoming-institute-crm/" class="site_title"> <img src="public/new/img/image_2024_02_02T10_11_48_862Z.png"></a>
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
                    <li class="active">
                        <a href="/becoming-institute-crm/"><img src="public/new/img/dashboard.svg">Dashboard</a>
                    </li>

                    <li>
                        <a class="parent_link"><img src="public/new/img/msgg.svg">Forms and Assessments
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">

                            <li class="">
                                <a href="#"><i class="fa fa-user-plus"></i> Forms </a>
                            </li>

                            <li class="">
                                <a href="#"><i class="fa fa-graduation-cap"></i> Assessments</a>
                            </li>
                        </ul>
                    </li>
        
                    <li class="">
                        <a href="#"><img src="public/new/img/teachers.svg">Clinician </a>
                    </li>
                    <li class="">
                        <a href="#"><img src="public/new/img/sessions.svg">Patient </a>
                    </li>
                    
                    

                    <!-- <li class="parent_item">
                        <a href="#" class="parent_link">
                            <img src="public/new/img/msgg.svg" alt="Message Center">
                            Message Center
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="#">Inbox</a></li> 
                            <li><a href="#">Sent</a></li>
                        </ul>
                    </li> -->






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

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var parentLink = document.querySelector('.parent_link');
        var childMenu = parentLink.nextElementSibling;

        parentLink.addEventListener('click', function(e) {
            e.preventDefault(); 
            childMenu.classList.toggle('show');
        });
    });
</script>

@endpush