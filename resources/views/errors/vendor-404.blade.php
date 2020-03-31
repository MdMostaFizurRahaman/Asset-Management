@extends('layouts.vendor')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                    <p>
                        Sorry, the page you are looking for could not be found.
                    </p>
                    <a href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                        <button class="btn bg-orange btn-flat">
                            Go Dashboard
                        </button>
                    </a>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>

@endsection
