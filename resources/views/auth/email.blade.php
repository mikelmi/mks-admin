@extends('admin::auth')

@section('page-title')
    {!! trans('admin::auth.Reset Password') !!}
    - @parent
@endsection

@section('content')
    <form class="card shd" role="form" method="post" action="{{ route('admin.reset.email') }}">
        {!! csrf_field() !!}
        <div class="card-header text-xs-center text-primary">
            <i class="fa fa-unlock fa-3x"></i>
            <div class="text-uppercase">{{trans('admin::auth.Reset Password')}}</div>
        </div>

        <div class="card-block p-x-2">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                @endif
            </div>
        </div>
        <div class="card-footer text-xs-center">
            <button type="submit" class="btn btn-primary">{{trans('admin::auth.send_reset')}}</button>
            <a class="btn btn-secondary" href="{{ route('admin.login') }}">{{trans('admin::messages.Cancel')}}</a>
        </div>
    </form>
@endsection
