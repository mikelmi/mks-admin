<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@section('page-title'){{trans('admin::messages.title')}}@show</title>

    @if(config('admin.materialized'))
        <link rel="stylesheet" href="{{ asset('vendor/mikelmi/mks-admin/css/auth-m.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('vendor/mikelmi/mks-admin/css/auth.css') }}">
    @endif

    <link rel="icon" href="{{ asset('vendor/mikelmi/mks-admin/favicon.ico') }}">

    <base href="{{route('admin')}}">
</head>

<body class="container-fluid{{config('admin.materialized') ? ' materialized' : ''}}">

<div class="row justify-content-md-center full-height">
    <div class="col-md-6 col-lg-5 col-xl-4 col-md-auto align-self-center">
        @yield('content')
    </div>
</div>

<script src="{{ asset('vendor/mikelmi/mks-admin/js/auth.js') }}"></script>
</body>
</html>