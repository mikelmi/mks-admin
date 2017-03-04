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
    {!! $grid->renderAddButton() !!}
    <div class="btn btn-group">
        {!! $grid->renderDeleteButton() !!}
    </div>
@endsection

@section('content')
    <div class="card shd">
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
                                @verbatim
                                    {{ grid.start }} - {{ grid.end }} / {{ grid.total }}<br />
                                @endverbatim
                                @lang('admin::messages.selected_count'): @{{ grid.hasSelected }}
                            </div>
                            <div class="pull-right" st-pagination="" st-items-by-page="{{$grid->getPerPage()}}"></div>
                            <div class="clearfix"></div>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection