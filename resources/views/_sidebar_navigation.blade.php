<ul class="sidebar-menu">
    <!-- Optionally, you can add icons to the links -->
    <li class="{!! Request::is('/') ? 'active' : '' !!}">
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a>
            <i class="fa fa-square-o"></i>
            <span>Boundary</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu" role="menu">
            <li class="{!! Request::is('boundaries/boundary_loader') ? 'active' : '' !!}">
                <a href="/boundaries/boundary_loader">
                    <i class="fa fa-circle-o"></i>
                    <span>Boundary Loader</span>
                </a>
            </li>
            <li class="{!! Request::is('boundaries/view_boundaries') ? 'active' : '' !!}">
                <a href="/boundaries/view_boundaries/">
                    <i class="fa fa-circle-o"></i>
                    <span>View Boundaries</span>
                </a>
            </li>
            {{--<li class="{!! Request::is('export') ? 'active' : '' !!}">--}}
                {{--<a href="/export">--}}
                    {{--<i class="fa fa-circle-o"></i>--}}
                    {{--<span>Export Boundary to KML</span>--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>

    </li>
    <li class="{!! Request::is('map') ? 'active' : '' !!}">
        <a href="/map">
            <i class="fa fa-map-marker"></i>
            <span>Map</span>
        </a>
    </li>
    {{--<li class="{!! Request::is('/') ? 'active' : '' !!}"><a href="{{ route('home') }}">--}}
            {{--<i class="fa fa-user-plus"></i>--}}
            {{--<span>Admin</span>--}}
        {{--</a>--}}
    {{--</li>--}}
    <li>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
            <span>Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </li>

</ul><!-- /.sidebar-menu -->
