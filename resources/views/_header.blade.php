<!-- Main Header -->
<header class="main-header">
    <a href="{{route('home')}}" class="logo"><b>{{ config('app.name', 'Boundary Exchange') }}</b></a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            {{--@include('_notifications')--}}
            @include('_useraccountheader')
                <!-- User Account Menu -->
            </ul>
        </div>
    </nav>
</header>