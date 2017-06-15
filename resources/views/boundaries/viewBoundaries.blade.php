{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'View Loaded Boundaries'}}
        <small>{{ $page_description or 'View all the boundaries loaded to database' }}</small>
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4 class="box-title">View Boundaries v1.0</h4>
                    </div>
                    <div class="panel-body">
                        <!-- form-start -->

                        <div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="view_boundary_data_table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="view_boundary_data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="view_boundary_data_table_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 167px;" aria-label="Rendering engine: activate to sort column ascending">Job Code</th>
                                                        <th class="sorting" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 167px;" aria-label="Rendering engine: activate to sort column ascending">Boundary Type</th>
                                                        <th class="sorting_desc" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 207px;" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Boundary Name</th>
                                                        <th class="sorting" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 183px;" aria-label="Platform(s): activate to sort column ascending">Added By</th>
                                                        <th class="sorting" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 143px;" aria-label="Engine version: activate to sort column ascending">When</th>
                                                        <th class="sorting" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 101px;" aria-label="CSS grade: activate to sort column ascending">View in Map</th>
                                                        <th class="sorting" tabindex="0" aria-controls="view_boundary_data_table" rowspan="1" colspan="1" style="width: 101px;" aria-label="CSS grade: activate to sort column ascending">Export KML</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $row)
                                                    <tr role="row" class="even">
                                                        <td class="">{!! $row->job_code !!}</td>
                                                        <td class="">{!! $row->boundary_type !!}</td>
                                                        <td class="">{!! $row->boundary_name  !!}</td>
                                                        <td class="">{!! $row->added_by !!}</td>
                                                        <td class="">{!! $row->created_at !!}</td>
                                                        <td><a href="/map?boundaryType={!! $row->boundary_type !!}&boundaryCode={!! $row->boundary_name  !!}">View</a> </td>
                                                        <td><a href="/export/kml/{!! $row->boundary_type !!}/{!! $row->boundary_name  !!}/{!! $row->job_code !!}">Export</a> </td>
                                                    </tr>
                                                @endforeach


                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">Job Code</th>
                                                    <th rowspan="1" colspan="1">Boundary Type</th>
                                                    <th rowspan="1" colspan="1">Boundary Name</th>
                                                    <th rowspan="1" colspan="1">Added By</th>
                                                    <th rowspan="1" colspan="1">When</th>
                                                    <th rowspan="1" colspan="1">View in Map</th>
                                                    <th rowspan="1" colspan="1">Export KML</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <div class="modal fade" id="viewBoundariesMapModal" tabindex="-1" role="dialog" aria-labelledby="viewBoundariesMapModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="viewBoundariesMapModalLabel">View Boundary in Map</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="info-box">
                                                                <span class="info-box-icon bg-aqua"><i class="fa fa-gears"></i><i class="fa fa-globe"></i> </span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">&nbsp;</span>
                                                                    <span class="info-box-number">This page is under construction.</span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                        </div>

                        <!-- form-end -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

