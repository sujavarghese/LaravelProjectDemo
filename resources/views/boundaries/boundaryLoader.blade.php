{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'Boundary Loader'}}
        <small>{{ $page_description or 'Loads boundary data to database' }}</small>
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4 class="box-title">Boundary Loader v1.0</h4>
                    </div>
                    <div class="panel-body">

                        <!-- form-start -->
                        <div>
                            <h6 class="box-title">This tools allows user to Boundary data loader in a specified KML format</h6>
                            <div class="box-body">
                                <a href="/kml_sample_template" class="btn btn-default pull-right">Download KML Sample</a>
                            </div>
                            {{--TODO: Provide details about CSV format--}}
                            {!! Form::open(
                                array(
                                    'url' => 'boundaries/upload',
                                    'class' => 'form-horizontal',
                                    'method' => 'POST',
                                    'files' => true
                                )
                              ) !!}
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Select the Boundary Type and Name: </label>
                                    <div class="col-sm-2">
                                        {!! Form::select(
                                            'selBoundaryType',
                                            array('' => '', 'SAM' => 'SAM'),
                                            null,
                                            [
                                                'class' => 'form-control',
                                                'id' => 'selBoundaryType'
                                            ])
                                        !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!!
                                            Form::select(
                                                'selBoundaryName',
                                                $response['sam_names'],
                                                null,
                                                [
                                                    'class' => 'form-control',
                                                    'id' => 'selBoundaryName',
                                                    'name' => 'selBoundaryName',

                                                ])
                                        !!}
                                        {{--TODO extract boundary name from database --}}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-sm-5 control-label">
                                        Upload Boundary KML file: </label>

                                    <div class="col-sm-5">

                                        {!!
                                            Form::file(
                                                'boundaryCsvFile'
                                                )
                                        !!}
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary pull-right" id="btnBoundaryLoadSubmit">Submit</button>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <!-- form-end -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4 class="box-title">Status</h4>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('boundary_msgs'))
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4 class="box-title">Status</h4>
                        </div>
                        <div class="panel-body">

                            @if(Session::get('boundary_msgs.overall_status') == 'Pass')
                                Overall Status:
                                <div class="form-group has-success">
                                    <label class="control-label">
                                        <i class="fa fa-check"></i> Passed
                                    </label>
                                    <br><a href="/boundaries/view_boundaries/?id={!! Session::get('boundary_msgs.job_code') !!}" class="btn btn-primary btn-xs">Click Here</a> to be view loaded boundaries.
                                </div>
                            @endif
                            @if(Session::get('boundary_msgs.overall_status') == 'Failed')
                                Overall Status:
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        <i class="fa fa-times-circle-o"></i> Failed
                                    </label>
                                </div>
                            @endif
                            <div>
                                @if(Session::has('boundary_msgs'))
                                    <div class="alert-box success">
                                        <ul>
                                            @foreach(Session::get('boundary_msgs') as $k => $msg)
                                                <li>{!! $k !!}: {!! $msg !!}</li>
                                            @endforeach
                                        </ul>
                                        <?php
                                            Session::remove('boundary_msgs');
                                        ?>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
@endsection

