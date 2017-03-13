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
    <div class="card shd">

        {!! $form->open(['class' => 'card-block p-a-3']) !!}
        {{ csrf_field() }}
        @foreach($form->getFields() as $field)
            {!! $field->render() !!}
        @endforeach
        {!! $form->close() !!}

    </div>
@endsection