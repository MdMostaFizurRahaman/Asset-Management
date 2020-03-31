@extends('layouts.client')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <section class="content-header">
{{--                <button type="button" id="loader" class="btn btn-success btn-lg">--}}
{{--                    Loader--}}
{{--                </button>--}}
            </section>
        </section>
    </div>

@endsection
@section('scripts')

    <script>

        $(function () {
            $('#loader').click(function(){
                $('.loader').addClass('active-loader')
            })


        });


    </script>

@endsection
