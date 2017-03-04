<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="admin" class="font-sm">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@section('page-title'){{trans('admin::messages.title')}}@show</title>

    @if(config('admin.materialized'))
        <link rel="stylesheet" href="{{ asset('vendor/mikelmi/mks-admin/css/admin-m.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('vendor/mikelmi/mks-admin/css/admin.css') }}">
    @endif

    @foreach($styles as $src)
        <link rel="stylesheet" href="{{ $src }}">
    @endforeach

    <link rel="icon" href="{{ asset('vendor/mikelmi/mks-admin/favicon.ico') }}">

    <base href="{{route('admin')}}">
</head>

<body ng-controller="AppCtrl as app" ng-class="{'left-closed': app.leftClosed}">

@include('admin::_partials.sidebar')

<section id="page" ng-hide="routeError" ng-class="{'page-loading': pageLoading}" class="full-height">
    <div class="loader"></div>
    <div ng-view autoscroll="true"></div>
</section>

<toast></toast>

<script>
    window.appModules = {!! $appModules !!};
    window.materialized = {{ config('admin.materialized') ? 1 : 0 }};

    paceOptions = {
        ajax: {
            trackMethods: ['GET', 'POST', 'DELETE', 'PUT', 'PATCH']
        }
    }

</script>

<script src="{{ asset('vendor/mikelmi/mks-admin/js/admin.js') }}"></script>
@foreach($scripts as $src)
    <script src="{{ $src }}"></script>
@endforeach
</body>
</html>