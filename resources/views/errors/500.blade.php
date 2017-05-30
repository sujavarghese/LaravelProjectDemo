{{--@extends('layouts.app')--}}

@extends('_template')

@section('sidebar')

    <section class="sidebar">
        test sidebar
        {{-- Include nothing --}}
    </section>

@endsection

@section('content')


<div id="navbar" class="collapse navbar-collapse">

</div>

<section class="content-header">
    <h1>
        {{ $page_title or '500 Error Page'}}
        <small>{{ $page_description or '' }}</small>
    </h1>
    <!-- You can dynamically generate breadcrumbs here -->
</section>
    <section class="content">

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Looks like something went wrong.</h3>
            <p>
                Meanwhile, you may <a class="text-blue" href="/login">return to Login</a>.
            </p>
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h4 class="box-title">Message: {{$exception_message}}</h4>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    {{$exception}}
                </div>
                <!-- /.box-body -->
            </div>

        </div>
        <!-- /.error-content -->
    </section>
@endsection
