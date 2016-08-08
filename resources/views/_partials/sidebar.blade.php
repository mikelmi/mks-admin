<aside id="sidebar">
    <div class="sidebar-wrapper">

        <div class="caption">
            <span class="lc-hide inline title">{{trans('admin::messages.title')}}</span>
            <div class="pull-right tools">
                <a href="#" class="lc-hide"><i class="fa fa-external-link"></i></a>
                <a href="javascript:void(0)" ng-click="app.leftClosed=!app.leftClosed"><i class="fa fa-exchange"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <ul class="nav sidebar-menu" role="navigation" ng-controller="MenuCtrl as menu">
            <li ng-repeat="item in menu.items" ng-class="{'expanded': item.expanded}">
                <a href="{[{ item.url }]}">
                    <i ng-if="item.icon" class="fa fa-{[{ item.icon }]}" title="{[{ item.title }]}"></i>
                    <div ng-if="!item.icon && item.firstChar" class="menu-icon lc-show" title="{[{ item.title }]}">{[{ item.firstChar }]}</div>
                    <span class="lc-hide">{[{ item.title }]}</span>
                    <i ng-if="item.children" class="expand pull-right fa fa-angle-right lc-hide" ng-click="menu.toggle(item, $event)"></i>
                </a>
                <ul ng-if="item.children">
                    <li ng-repeat="subItem in item.children">
                        <a href="{[{ subItem.url }]}">
                            <i ng-if="subItem.icon" class="fa fa-{[{ subItem.icon }]}"></i>
                            <span>{[{ subItem.title }]}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="sidebar-footer">
            @if ($locales)
                <span class="dropup lc-hide">
                    <a href="#" class="dropdown-toggle" id="localesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <a href="{{$profileUrl}}" class="lc-hide" title="{{$username}}" data-toggle="tooltip">
                <i class="fa fa-user"></i>
            </a>
            <a class="pull-right" href="{{route('admin.logout')}}">
                <i class="fa fa-power-off"></i>
                <span class="lc-hide inline">{{trans('admin::auth.Logout')}}</span>
            </a>
            <div class="clearfix"></div>
        </div>

    </div>
</aside>