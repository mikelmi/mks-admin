@extends('admin::page')

@if ($form->hasBreadcrumbs())
    @section('header')
        <div class="breadcrumb mr-auto">
            @foreach($form->getBreadcrumbs() as $item)
                @if ($item['url'])
                    <a href="{{$item['url']}}" class="breadcrumb-item">{{$item['title']}}</a>
                @else
                    <span class="breadcrumb-item">{{$item['title']}}</span>
                @endif
            @endforeach
            @if ($form->getTitle())
                <span class="breadcrumb-item">
                    {{$form->getTitle()}}
                </span>
            @endif
        </div>
    @endsection
@else
    @section('title')
        {{$form->getTitle()}}
    @endsection
@endif

@section('tools')
    <div class="btn-group">
        <button type="button" class="btn btn-primary" mks-submit>@lang('admin::messages.Save')</button>
        @if ($form->getNewUrl())
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#" mks-submit data-flag="1">@lang('admin::messages.Save and New')</a>
            </div>
        @endif
    </div>
    @if($form->getDeleteUrl())
        <button type="button" class="btn btn-danger" mks-action
                data-url="{{$form->getDeleteUrl()}}"
                data-back-url="{{$form->getBackUrl()}}"
                title="@lang('admin::messages.Delete')"
                data-confirm="@lang('admin::messages.confirm_delete')"
            >
            <i class="fa fa-remove"></i>
        </button>
    @endif
    @if($form->getBackUrl())
        <a class="btn btn-secondary" href="{{$form->getBackUrl()}}">@lang('admin::messages.Cancel')</a>
    @endif
@endsection

@section('content')

    @if ($form->hasAlerts())
        @foreach($form->getAlerts() as $alert)
            @component('admin::components.alert', ['type' => $alert['type'], 'icon' => $alert['icon']])
            {!! $alert['message'] !!}
            @endcomponent
        @endforeach
    @endif

    <div class="card shd">
        {!! $form->open() !!}
        {{ csrf_field() }}

        @if ($form->hasGroups())
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs pull-xs-left">
                    @foreach($form->getGroups() as $group)
                        {!! $group->navLink() !!}
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-block p-a-3">
            @foreach($form->getFields() as $field)
                {!! $field->render() !!}
            @endforeach

            @if ($form->hasGroups())
                <div class="tab-content">
                    @foreach($form->getGroups() as $group)
                        <div{!! html_attr($group->paneAttributes()) !!}>
                            @foreach($group->getFields() as $field)
                                {!! $field->render() !!}
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        {!! $form->close() !!}

    </div>
@endsection