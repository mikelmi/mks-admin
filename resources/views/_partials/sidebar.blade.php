<aside id="sidebar" class="shd-right"
       ng-init="sidebarInverse={{config('admin.sidebar_inverse') ? 1:0}}"
       ng-class="{'sidebar-inverse': sidebarInverse}">
    <div class="sidebar-wrapper">

        <div class="caption">
            {!! config('admin.home_button', '<a class="lc-hide inline title" href="#/home">Admin</a>') !!}
            <div class="pull-right tools">
                <a href="{{ $siteUrl }}" target="_blank" class="lc-hide" title="{{trans('admin::messages.View Site')}}" aria-label="{{trans('admin::messages.View Site')}}"><i class="fa fa-external-link"></i></a>
                <a href="#" class="lc-hide" title="{{trans('admin::messages.Refresh')}}" ng-click="app.refresh($event)"><i class="fa fa-refresh"></i></a>
                <a href="javascript:void(0)" ng-click="app.leftClosed=!app.leftClosed" title="{{trans('admin::messages.Toggle menu')}}" alia-label="{{trans('admin::messages.Toggle menu')}}"><i class="fa fa-exchange"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>

        @verbatim
            <ul class="nav flex-column sidebar-menu" role="navigation" ng-controller="MenuCtrl as menu">
                <li ng-repeat="item in menu.items" ng-class="{'expanded': item.expanded, 'active': app.isCurrentPath(item.hash)}">
                    <a ng-if="item.url" href="{{ item.url }}">
                        <i ng-if="item.icon" class="fa fa-{{ item.icon }}" title="{{ item.title }}"></i>
                        <div ng-if="!item.icon && item.firstChar" class="menu-icon lc-show" title="{{ item.title }}">{{ item.firstChar }}</div>
                        <span class="lc-hide">&nbsp;{{ item.title }}</span>
                        <i ng-if="item.children" class="expand pull-right fa fa-angle-right lc-hide" ng-click="menu.toggle(item, $event)"></i>
                    </a>
                    <a ng-if="!item.url && item.children" href="{{ item.url }}" ng-click="menu.toggle(item, $event)">
                        <i ng-if="item.icon" class="fa fa-{{ item.icon }}" title="{{ item.title }}"></i>
                        <div ng-if="!item.icon && item.firstChar" class="menu-icon lc-show" title="{{ item.title }}">{{ item.firstChar }}</div>
                        <span class="lc-hide">&nbsp;{{ item.title }}</span>
                        <i ng-if="item.children" class="expand pull-right fa fa-angle-right lc-hide"></i>
                    </a>
                    <ul ng-if="item.children">
                        <li ng-repeat="subItem in item.children" ng-class="{'active': app.isCurrentPath(subItem.hash)}">
                            <a href="{{ subItem.url }}">
                                <i class="fa fa-{{ subItem.icon || 'angle-right' }}"></i> &nbsp;
                                <span>{{ subItem.title }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @endverbatim

        <div class="sidebar-footer">
            @if ($locales)
                <span class="dropup lc-hide">
                    <a href="#" class="dropdown-toggle" id="localesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{trans('admin::messages.Language')}}">
                        <img src="{{asset('vendor/mikelmi/mks-admin/img/lang/'.$locale.'.gif')}}" alt="{{$locale}}" />
                    </a>
                    <div class="dropdown-menu" aria-labelledby="localesDropdown">
                        @foreach ($locales as $lc => $title)
                            <a class="dropdown-item" href="{{route('admin', ['_lang' => $lc])}}">
                                <img src="{{asset('vendor/mikelmi/mks-admin/img/lang/'.$lc.'.gif')}}" alt="{{$lc}}" />
                                {{$title}}
                            </a>
                        @endforeach
                    </div>
                </span>
            @endif
            @if($profileUrl)
                <a href="{{$profileUrl}}" class="lc-hide" title="{{$username}}" data-toggle="tooltip">
                    <i class="fa fa-user-circle"></i>
                </a>
            @endif
            <a href="javascript:void(0)" class="lc-hide" title="" data-toggle="tooltip" ng-click="sidebarInverse=!sidebarInverse">
                <i class="fa" ng-class="{'fa-toggle-on': !sidebarInverse, 'fa-toggle-off': sidebarInverse}"></i>
            </a>
            <a class="pull-right" href="{{route('admin.logout')}}" title="{{trans('admin::auth.Logout')}}">
                <i class="fa fa-power-off"></i>
                &nbsp;
            </a>
            <div class="clearfix"></div>
        </div>

    </div>
</aside>
