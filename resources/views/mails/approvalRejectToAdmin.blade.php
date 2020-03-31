@extends('layouts.email')

@section('content')
    {{--<h1 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;">Dear {{ $user->name }}</h1>--}}
    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
        Greetings from {{ env('APP_NAME') }} <br><br>
        Dear Admin User {{ $user->name }}
        <br><br>
        An Assessment is rejected from all permitted users.
        <br><br>
        Please follow this link for more details:
        <br><br>
        <a href="{{ route('client.assessments.index', [$user->client->client_url]) }}">Link</a>
    </p>

@endsection
