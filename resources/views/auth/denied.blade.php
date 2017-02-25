@extends('admin::auth')

@section('page-title')
    {{trans('admin::auth.Access Denied')}}
    - @parent
@endsection

@section('content')

    <div class="card shd card-inverse card-danger text-center">
        <div class="card-block p-x-3">
            <div class="card-title">
                <i class="fa fa-lock fa-3x"></i>
                <div class="text-uppercase">{{trans('admin::auth.Access Denied')}}</div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{route('admin.logout')}}" class="btn btn-danger active">{{trans('admin::auth.Sign In')}}</a>
        </div>
    </div>

@endsection
