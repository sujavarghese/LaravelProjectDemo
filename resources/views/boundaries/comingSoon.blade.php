{{--@extends('layouts.app')--}}

@extends('_template')

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or 'Coming Soon'}}
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <!-- form-start -->

                        <div>
                            This page is under construction..
                        </div>

                        <!-- form-end -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

