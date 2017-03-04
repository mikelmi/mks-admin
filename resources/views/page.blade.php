<div @yield('controller')>

    <header class="page-header">
        <nav class="navbar fixed-top navbar-light bg-light d-flex align-content-stretch flex-wrap flex-sm-row">
            @section('header')
                <span class="navbar-brand">@yield('title')</span>
                <span class="navbar-text text-muted mr-auto">@yield('sub-title')</span>
            @show
            <div class="hidden-xs-down">
                @yield('right')
            </div>
            <div class="tools">
                @yield('tools')
            </div>
        </nav>
    </header>

    <div class="container-fluid page-content">
        @yield('content')
    </div>

</div>