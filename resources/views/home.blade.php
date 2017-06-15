@extends('_template')

@section('content')

    <div id="navbar" class="collapse navbar-collapse">

    </div>

    <section class="content-header">
        <h1>
            {{ $page_title or 'Boundary Exchange Dashboard'}}
            <small>{{ $page_description or 'Overall summary of Boundary Exchange' }}</small>
        </h1>
        <!-- You can dynamically generate breadcrumbs here -->
    </section>

    <section class="content">
        <div class="container width100">
            <div class="row">
                <div class="col-md-10" style="width: 95%">
                    <div class="panel panel-default">
                        <div class="panel-heading">Dashboard</div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon" style="background: transparent;">
                                            <img style="height: 71%;" src="{{ asset("/sam-image.png")}}">
                                        </span>
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
                                        <span class="info-box-icon" style="background: transparent;">
                                            <img style="height: 90%;" src="{{ asset("/ada-img.png")}}">
                                        </span>

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
                                        <span class="info-box-icon" style="background: transparent;">
                                            <img style="height: 80%;" src="{{ asset("/users.png")}}">
                                        </span>
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
                                    <div class="box box-info">

                                        <div class="box-header with-border">
                                            <h3 class="box-title">Boundary Load Statistics</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                            class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="progress-group" style="padding: 10px 5px;">
                                                <span class="progress-text">Successfully Uploaded</span>
                                                <span class="progress-number"><b>{{$dashboard_data['load_stat']['valid_upload_count']}}</b>/{{$dashboard_data['load_stat']['total_count']}}</span>

                                                <div class="progress sm" style="margin-top: 5px;">
                                                    <div class="progress-bar progress-bar-aqua" style="width: {{$dashboard_data['load_stat']['valid_upload_percentage']}}%"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                            <div class="progress-group" style="padding: 10px 5px;">
                                                <span class="progress-text">Validation Passed</span>
                                                <span class="progress-number"><b>{{$dashboard_data['load_stat']['valid_validate_count']}}</b>/{{$dashboard_data['load_stat']['total_count']}}</span>

                                                <div class="progress sm" style="margin-top: 5px;">
                                                    <div class="progress-bar progress-bar-yellow" style="width: {{$dashboard_data['load_stat']['valid_validate_percentage']}}%"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                            <div class="progress-group" style="padding: 10px 5px;">
                                                <span class="progress-text">Successfully Loaded</span>
                                                <span class="progress-number"><b>{{$dashboard_data['load_stat']['valid_load_count']}}</b>/{{$dashboard_data['load_stat']['total_count']}}</span>

                                                <div class="progress sm" style="margin-top: 5px;">
                                                    <div class="progress-bar progress-bar-green" style="width: {{$dashboard_data['load_stat']['valid_load_percentage']}}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
