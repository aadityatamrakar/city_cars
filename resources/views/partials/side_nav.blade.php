<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/dist/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">NAVIGATION</li>
            <li class="{{ Route::currentRouteName()=='dashboard'?"active":'' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            @if(\App\Http\Controllers\UsersController::check_access(1))
                <li class="treeview {{ substr(Route::currentRouteName(), 0, 11)=='data_lookup'?'active':'' }}">
                    <a href="#">
                        <i class="fa fa-search"></i> <span>Data Lookup</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Route::currentRouteName()=='data_lookup.customers'?"active":'' }}"><a href="{{ route('data_lookup.customers') }}"><i class="fa fa-circle-o"></i> Customer Lookup</a></li>
                        <li class="{{ Route::currentRouteName()=='data_lookup.vehicles'?"active":'' }}"><a href="{{ route('data_lookup.vehicles') }}"><i class="fa fa-circle-o"></i> Vehicle Lookup</a></li>
                        <li class="{{ Route::currentRouteName()=='data_lookup.transactions'?"active":'' }}"><a href="{{ route('data_lookup.transactions') }}"><i class="fa fa-circle-o"></i> Transaction Lookup</a></li>
                    </ul>
                </li>
            @endif
            @if(\App\Http\Controllers\UsersController::check_access(2))
                <li class="{{ Route::currentRouteName()=='data_entry'?"active":'' }}"><a href="{{ route('data_entry') }}"><i class="fa fa-pencil"></i> <span>Data Entry</span></a></li>
            @endif
            @if(\App\Http\Controllers\UsersController::check_access(3))
                <li class="{{ Route::currentRouteName()=='reports.index'?"active":'' }}"><a href="{{ route('reports.index') }}"><i class="fa fa-list-alt"></i> <span>Create Reports</span></a></li>
                <li class="{{ Route::currentRouteName()=='reports.view'?"active":'' }}"><a href="{{ route('reports.view') }}"><i class="fa fa-file"></i> <span>Generate Reports</span></a></li>
                <li class="{{ Route::currentRouteName()=='mailing.index'?"active":'' }}"><a href="{{ route('mailing.index') }}"><i class="fa fa-envelope"></i> <span>Mailing Settings</span></a></li>
            @endif
            @if(\App\Http\Controllers\UsersController::check_access(4))
                <li class="{{ Route::currentRouteName()=='users.index'?"active":'' }}"><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>Manage Users</span></a></li>
                <li class="{{ Route::currentRouteName()=='sessions.index'?"active":'' }}"><a href="{{ route('sessions.index') }}"><i class="fa fa-list"></i> <span>Session Info</span></a></li>
                <li ><a href="{{ route('mailing.index') }}"><i class="fa fa-download"></i> <span>Database Backup</span></a></li>
                <li class="{{ Route::currentRouteName()=='settings.index'?"active":'' }}"><a href="{{ route('settings.index') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
            @endif
        </ul>
    </section>
</aside>