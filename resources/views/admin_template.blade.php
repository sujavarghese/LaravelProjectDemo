{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


    <div id="navbar" class="collapse navbar-collapse">

    </div>

    <section class="content-header">
        <h1>
            {{ $page_title or 'Boundary Exchange Dashboard'}}
            <small>{{ $page_description or 'Overall summary of Boundary Exchange portal' }}</small>
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
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total SAMs</span>
                                            <span class="info-box-number">90</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total ADAs</span>
                                            <span class="info-box-number">41,410</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->

                                <!-- fix for small devices only -->
                                <div class="clearfix visible-sm-block"></div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Users</span>
                                            <span class="info-box-number">56</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Admin</span>
                                            <span class="info-box-number">2</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
