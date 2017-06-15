{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'Map Viewer'}}
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>

<section class="content">
    <div class="container width100">
        <div id="map" class="map">
        <div class="row select-boundary-wrapper floating-dropdown">
            <form action="" id="exportBoundary">
                <label class="col-sm-3 align-label">Select Boundary:</label>
                <div class="col-sm-3">
                    <select class="form-control" id="boundaryType" name="boundaryType" required>
                        <option value="" selected="selected">Boundary Type</option>
                        <option value="FSA">FSA</option>
                        <option value="SAM">SAM</option>
                        <option value="ADA">ADA</option>
                        <option value="TLS_INT">TLS_INT</option>
                    </select>
                    <div class="boundary-loading-wrapper">
                        <i class="fa fa-refresh fa-spin boundary-loading display-none"></i>
                    </div>
                </div>

                <div class="col-sm-3">
                    <select class="form-control" id="boundaryCode" name="boundaryCode" required disabled="disabled">
                        <option value="">Boundary Code</option>
                    </select>
                    {{--TODO extract boundary name from database --}}

                </div>
                <div class="col-sm-1">
                    <a id="submit" class="btn btn-primary ">Export</a>
                </div>
        </div>
        </div>
        <div class="row goemetry-type-selection display-none">
            <label class="col-sm-3 align-label">Draw Boundary:</label>
            <div class="col-sm-3">
                <select class="form-control" id="geometryType">
                    <option value="" selected="selected">Select Geometry type</option>
                    <option value="Point">Point</option>
                    <option value="LineString">LineString</option>
                    <option value="Polygon">Polygon</option>
                    <option value="Circle">Circle</option>
                    <option value="None">None</option>
                </select>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-primary ">Export</button>
            </div>
            </form>
        </div>

    </div>
</section>
<link rel="stylesheet" href="https://openlayers.org/en/v4.1.1/css/ol.css" type="text/css">
<!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
<script src="https://openlayers.org/en/v4.1.1/build/ol.js"></script>
<script src="{{ asset("/js/map_viewer.js")}}" type="text/javascript"></script>
@endsection