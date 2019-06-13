<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{url('/admin/dashboard')}}" class="site_title"><i class="fa fa-paw"></i> <span>Admin Panel</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ isset(auth('admin')->user()->photo)?asset('images/'.auth('admin')->user()->photo):'' }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{auth('admin')->user()->name}}</h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a><i class="fa fa-home"></i> Admins <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('admin/user/create') }}">New</a></li>
                            <li><a href="{{ url('admin/user/list') }}">List</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('all/front/users') }}"><i class="fa fa-home"></i> Users</a></li>
                    <li><a><i class="fa fa-home"></i> Questions <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('all/approved/questions') }}">approved</a></li>
                            <li><a href="{{ url('pending/question') }}">Pending</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-home"></i> Answers <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="">approved</a></li>
                            <li><a href="">Pending</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Trash Items"
            href="{{ url('admin/trash-board') }}">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Profile">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>