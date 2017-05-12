@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'Boundary & Design Exchange Dashboard'}}
        <small>{{ $page_description or 'Overall summary of Boundary & Design Exchange' }}</small>
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua">S</span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total SAMs</span>

                                        <span class="info-box-number">
                                            @if(isset($dashboard_data['sam_count']))
                                                {!!  $dashboard_data['sam_count'] !!}
                                            @else
                                                0
                                            @endif
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red">A</span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total ADAs</span>
                                        <span class="info-box-number">
                                            @if(isset($dashboard_data['ada_count']))
                                                {!!  $dashboard_data['ada_count'] !!}
                                            @else
                                                0
                                            @endif

                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- fix for small devices only -->
                            <div class="clearfix visible-sm-block"></div>

                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Users</span>
                                        <span class="info-box-number">
                                            @if(isset($dashboard_data['user_count']))
                                                {!!  $dashboard_data['user_count'] !!}
                                            @else
                                                0
                                            @endif

                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
