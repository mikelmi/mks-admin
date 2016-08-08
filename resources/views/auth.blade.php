<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@section('page-title'){{trans('admin::messages.title')}}@show</title>

    <link rel="stylesheet" href="{{ asset('vendor/mikelmi/mks-admin/css/auth.css') }}">

    <base href="{{route('admin')}}">
</head>

<body class="container-fluid">

<div class="row flex-items-xs-center full-height">
    <div class="column flex-xs-middle col-md-6 col-lg-5 col-xl-4">
        @yield('content')
    </div>
</div>

<script src="{{ asset('vendor/mikelmi/mks-admin/js/auth.js') }}"></script>
</body>
</html>