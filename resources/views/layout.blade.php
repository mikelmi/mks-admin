<!DOCTYPE html>
<html lang="{{ app()->getLocale() or 'en' }}" ng-app="admin">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@section('page-title'){{trans('admin::messages.title')}}@show</title>

    <link rel="stylesheet" href="{{ asset('vendor/mikelmi/mks-admin/css/admin.css') }}">

    @foreach($styles as $src)
        <link rel="stylesheet" href="{{ $src }}">
    @endforeach

    <base href="{{route('admin')}}">
</head>

<body ng-controller="AppCtrl as app" ng-class="{'left-closed': app.leftClosed}">

@include('admin::_partials.sidebar')

<section id="page" ng-hide="routeError" ng-class="{'page-loading': pageLoading}" class="full-height">
    <div class="loader"></div>
    <div ng-view class="container-fluid" autoscroll="true"></div>
</section>

<toast></toast>

<script>
    window.appModules = {!! $appModules !!};

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