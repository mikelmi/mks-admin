@extends('admin::page')

@section('controller')
    ng-controller="TableCtrl as grid" ng-init="grid.init('{{$grid->getUrl()}}')"
@endsection

@section('title')
    {{$grid->getTitle()}}
@endsection

@section('right')
    @if ($grid->isWithSearch())
        <input class="form-control form-control-search ic-left" type="search" placeholder="@lang('admin::messages.Search')..." ng-model="gridQuery" />
    @endif
@endsection

@section('tools')
    @foreach($grid->getLinks() as $link)
        {!! $link->render() !!}
    @endforeach
    <div class="btn btn-group btn-group-sm">
        @foreach($grid->getTools() as $button)
            {!! $button->render() !!}
        @endforeach
    </div>
@endsection

@section('content')
    <div class="card shd" ng-init="grid.itemsPerPage='{{$grid->getPerPage()}}'">
        @if ($grid->hasScopes())
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs pull-xs-left">
                    @foreach($grid->getScopes() as $name => $scope)
                    <li class="nav-item">
                        <a class="nav-link{{$name == $grid->getScope() ? ' active':''}}" href="{{$grid->getBaseUrl()}}/{{$name}}">
                            @if ($scope->getIcon())
                                <i class="fa fa-{{$scope->getIcon()}}"></i>
                            @endif
                            {{ $scope->getTitle() }}
                            @if ($scope->getBadge())
                                <span class="badge badge-pill badge-default">{{$scope->getBadge()}}</span>
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-block-table">

            <table class="table table-sm table-grid table-hover" st-pipe="grid.pipeServer" st-table="grid.rows">

                <thead @if ($grid->isWithSearch()) mst-watch-query="gridQuery" @endif>
                    <tr class="bg-light">
                        @foreach($grid->getColumns() as $column)
                            {!! $column->renderHead() !!}
                        @endforeach
                    </tr>

                    @if ($grid->hasSearchableColumns())
                        <tr>
                            @foreach($grid->getColumns() as $column)
                                {!! $column->renderSearch() !!}
                            @endforeach
                        </tr>
                    @endif
                </thead>

                <tbody>
                    <tr ng-repeat="row in grid.rows" {!! html_attr($grid->getRowAttributes()) !!}>
                        @foreach($grid->getColumns() as $column)
                            {!! $column->renderCell() !!}
                        @endforeach
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="{{$grid->getColumns()->count()}}" class="p-3">
                            <div class="pull-left text-muted">
                                <div class="form-inline">
                                    <select class="form-control form-control-sm" ng-model="grid.itemsPerPage">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <label class="ml-2">
                                        @verbatim
                                        {{ grid.start }} - {{ grid.end }} / {{ grid.total }}
                                        @endverbatim
                                        |
                                    </label>
                                    <label class="ml-2">@lang('admin::messages.selected_count'): @{{ grid.hasSelected }}</label>
                                </div>
                            </div>
                            <div class="pull-right" st-pagination="" st-items-by-page="grid.itemsPerPage"></div>
                            <div class="clearfix"></div>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection