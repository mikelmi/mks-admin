<header class="page-header">
    <nav class="navbar navbar-fixed-top navbar-light bg-faded">
        @section('header')
            <span class="navbar-brand">@yield('title')</span>
            <span class="navbar-text text-muted">@yield('sub-title')</span>
        @show
        <div class="btn-group pull-right">
            @yield('tools')
        </div>
    </nav>
</header>

<div class="page-content">
    @yield('content')
</div>