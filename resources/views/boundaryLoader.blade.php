{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'Boundary & Design Exchange Dashboard'}}
        <small>{{ $page_description or 'Overall summary of Boundary & Design Exchange portal' }}</small>
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4 class="box-title">Boundary Loader</h4>
                    </div>
                    <div class="panel-body">

                        <!-- form-start -->
                        <div class="box box-primary">
                            <h6 class="box-title">This tools allows user to Boundary data loader in a specified CSV format</h6>
                            {{--TODO: Provide details about CSV format--}}
                            <!-- /.box-header -->
                            <!-- form start -->
                            {!! Form::open(['url' => '/boundary_loader', 'class' => 'form-horizontal']) !!}

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
                                    <label for="exampleInputFile" class="col-sm-5 control-label">Upload Boundary CSV file: </label>

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
                                                <input id="chk_agree_boundary_loader" type="checkbox"> I Agree
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary pull-right" ng-enabled="chk_agree_boundary_loader" ng-disabled="!chk_agree_boundary_loader">Submit</button>
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

