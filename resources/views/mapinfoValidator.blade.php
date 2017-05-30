{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'Boundary Exchange MapInfo Validator'}}
        <small>{{ $page_description or 'Validate MapInfo designs' }}</small>
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4 class="box-title">MapInfo Validator</h4>
                    </div>
                    <div class="panel-body">

                        <!-- form-start -->
                        <div>
                            <h6 class="box-title">This tools allows user to upload MapInfo File
                                and validates MapInfo Package against a specific
                                <a href="#" data-toggle="modal" data-target="#miSpecModal">
                                    <i class="fa fa-fw fa-info-circle"></i>
                                </a>

                                format.</h6>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <!-- Button trigger modal -->
                            <!-- Modal -->
                            <div class="modal fade" id="miSpecModal" tabindex="-1" role="dialog" aria-labelledby="miSpecModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">MapInfo Specification Format</h4>
                                        </div>
                                        <div class="modal-body">
                                            Details to be added about MapInfo Spec
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(['url' => 'foo/bar', 'class' => 'form-horizontal']) !!}

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Select the Boundary Type and Name</label>

                                    <div class="col-sm-2">
                                        {!! Form::select(
                                            'boundary_type',
                                            array('sam' => 'SAM', 'ada' => 'ADA'),
                                            null,
                                            ['class' => 'form-control'])
                                        !!}
                                        {{--TODO extract boundary type from database --}}
                                    </div>
                                    <div class="col-sm-3">
                                        {!!
                                            Form::select(
                                                'boundary_name',
                                                array(
                                                    '2ABN-01' => '2ABN-01',
                                                    '3ACH-01' => '3ACH-01',
                                                    '4MRA-63' => '4MRA-63',
                                                    '5LIS-20' => '5LIS-20',
                                                ),
                                                null,
                                                ['class' => 'form-control'])
                                        !!}
                                        {{--TODO extract boundary name from database --}}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-sm-5 control-label">Uploade T18 Package</label>

                                    <div class="col-sm-5">
                                        <input type="file"  id="exampleInputFile">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-5">
                                        &nbsp;&nbsp;
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I Agree
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-info pull-right">Validate</button>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <!-- form-end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

