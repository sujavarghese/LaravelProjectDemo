<ul class="sidebar-menu">
    <li class="header">Navigation</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="active"><a href="{{ route('home') }}"><span>Dashboard</span></a></li>
    <li>
        <a href="#"><span>Boundary</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu" role="menu">
            <li>
                <a href="/boundary_loader">
                    Boundary Loader
                </a>
            </li>
            <li>
                <a href="/view_boundaries">
                    View Boundaries
                </a>
            </li>
        </ul>

    </li>
    <li>
        <a href="#"><span>HFC</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu" role="menu">
            <li>
                <a href="/mapinfo_validator">
                    MapInfo Validator
                </a>
            </li>
            <li>
                <a href="/kml_export">
                    Export KML
                </a>
            </li>
        </ul>

    </li>
    <li>
        <a href="#"><span>MTM</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu" role="menu">
            <li>
                <a href="/mapinfo_validator">
                    MapInfo Validator
                </a>
            </li>
            <li>
                <a href="/unknown">
                    New Menu
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#"><span>Utilities</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu" role="menu">
            <li>
                <a href="/converter">
                    File Converter
                </a>
            </li>
        </ul>
    </li>
    <li class="active"><a href="{{ route('home') }}"><span>Admin</span></a></li>
    <li class="active">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </li>

</ul><!-- /.sidebar-menu -->
