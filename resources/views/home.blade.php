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
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Latest Uploads</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                            class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                            class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table no-margin">
                                                    <thead>
                                                    <tr>
                                                        <th>Job Id</th>
                                                        <th>Region Type</th>
                                                        <th>Region Name</th>
                                                        <th>Validation Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($dashboard_data['recent_uploads'] as $row)
                                                        <tr role="row" class="even">
                                                            <td class="">{!! $row->id !!}</td>
                                                            <td class="">{!! $row->boundary_type !!}</td>
                                                            <td class="">{!! $row->boundary_code  !!}</td>
                                                            <td>@if ($row->validation_status === 'PASS')
                                                                    <span class="label label-success">PASS</span>@endif
                                                                @if ($row->validation_status === 'VALIDATED')
                                                                    <span class="label label-success">VALIDATED</span>@endif
                                                                @if ($row->validation_status === 'FAILED')
                                                                    <span class="label label-danger">FAILED</span>@endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer clearfix">
                                            <a href="/boundaries/view_boundaries/"
                                               class="btn btn-sm btn-default btn-flat pull-right">View All Boundaries</a>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="box box-default">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Boundary Load Statistics</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                            class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                            class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="chart-responsive" style="text-align: center">
                                                    <canvas id="pieChart" height="210" width="205"
                                                            style="width: 205px; height: 210px;"></canvas>
                                                </div>
                                                <!-- ./chart-responsive -->
                                                <ul class="chart-legend clearfix" style="margin-left: 30%;">
                                                    <li><i class="fa fa-circle-o text-gray"></i> Successfully Uploaded
                                                    </li>
                                                    <li><i class="fa fa-circle-o text-blue"></i> Validation Passed</li>
                                                    <li><i class="fa fa-circle-o text-aqua"></i> Successfully Loaded
                                                        into Database
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset ("/bower_components/admin-lte/plugins/chartjs/Chart.min.js") }}"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            var pie = <?php echo json_encode($dashboard_data['load_stat']); ?>;
            var canvas = document.getElementById("pieChart");
            var ctx = canvas.getContext("2d");
            new Chart(ctx).Doughnut(pie);
        });
    </script>
@endsection
