<div @yield('controller')>

    <header class="page-header">
        <nav class="navbar navbar-fixed-top navbar-light bg-faded">
            @section('header')
                <span class="navbar-brand">@yield('title')</span>
                <span class="navbar-text text-muted">@yield('sub-title')</span>
            @show
            <div class="pull-right tools">
                @yield('tools')
            </div>
            <div class="pull-right hidden-xs-down">
                @yield('right')
            </div>
        </nav>
    </header>

    <div class="page-content">
        @yield('content')
    </div>

</div>