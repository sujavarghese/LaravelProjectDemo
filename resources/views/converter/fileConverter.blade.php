

{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


    <div id="navbar" class="collapse navbar-collapse">

    </div>

    <section class="content-header">
        <h1>
            {{ $page_title or 'File Converter'}}
            <small>{{ $page_description or 'Converts simple features data between file formats.' }}</small>
        </h1>
        <!-- You can dynamically generate breadcrumbs here -->
    </section>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4 class="box-title">File Converter v1.0</h4>
                        </div>
                        <div class="panel-body">

                            <!-- form-start -->
                            <div>
                                <h6 class="box-title">This tools allows user to upload a file and convert to other available formats.</h6>
                                {{--TODO: Provide details about CSV format--}}
                                {!! Form::open(
                                    array(
                                        'url' => 'file_converter/upload',
                                        'class' => 'form-horizontal',
                                        'method' => 'POST',
                                        'files' => true
                                    )
                                  ) !!}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Input File Type</label>
                                        <div class="col-sm-2">
                                            {!! Form::select(
                                                'inputFileType',
                                                array('' => '', 'CSV' => 'CSV', 'GML' => 'GML', 'KML' => 'KML', 'MAPINFO' => 'MAPINFO'),
                                                null,
                                                [
                                                    'class' => 'form-control',
                                                    'id' => 'inputFileType'
                                                ])
                                            !!}
                                        </div>
                                        <label class="col-sm-2 control-label">Output File Type</label>
                                        <div class="col-sm-3">
                                            {!!
                                                Form::select(
                                                    'outputFileType',
                                                    array('' => '', 'CSV' => 'CSV', 'GML' => 'GML', 'KML' => 'KML', 'MAPINFO' => 'MAPINFO'),
                                                    null,
                                                    [
                                                        'class' => 'form-control',
                                                        'id' => 'outputFileType',
                                                        'name' => 'outputFileType',

                                                    ])
                                            !!}
                                            {{--TODO extract boundary name from database --}}

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-sm-5 control-label">
                                            Upload Input File </label>

                                        <div class="col-sm-5">

                                            {!!
                                                Form::file(
                                                    'inputFile'
                                                    )
                                            !!}
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <button type="submit" class="btn btn-primary pull-right" id="btnFileConverterSubmit">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>

                            <!-- form-end -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <br><a href="/view_boundaries" class="btn btn-primary btn-xs">Click Here</a> to be view loaded boundaries.
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
                                                    <li>{!! $k !!} - {!! $msg !!}</li>
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

