@extends('admin::auth')

@section('page-title')
    {!! trans('admin::auth.Sign In') !!}
    - @parent
@endsection

@section('content')

    <form class="card shd" role="form" action="{{ route('admin.login.post') }}" method="post">

        {!! csrf_field() !!}

        <div class="card-header text-xs-center text-primary">
            <i class="fa fa-user fa-3x"></i>
            <div class="text-uppercase">{!! trans('admin::auth.Sign In') !!}</div>
        </div>
        <div class="card-block p-x-2">

            <div class="form-group{{ $errors->has($username) ? ' has-danger' : '' }}">
                <input type="text" class="form-control" name="{{ $username }}" value="{{ old($username) }}" placeholder="{{trans('admin::auth.Username')}}" required>
                @if ($errors->has($username))
                    <div class="form-control-feedback">{{ $errors->first($username) }}</div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="{{trans('admin::auth.Password')}}" required>
                @if ($errors->has('password'))
                    <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group row">
                <div class="form-check {{ $reset_enable ? 'col-sm-6' : 'col-sm-12' }}">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember">
                        {{trans('admin::auth.Remember me')}}
                    </label>
                </div>
                @if ($reset_enable)
                    <div class="col-sm-6 text-sm-right">
                        <a href="{{ route('admin.forgot') }}">{{trans('admin::auth.Forgot Password')}}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer text-xs-center">
            <button type="submit" class="btn btn-primary">{{trans('admin::auth.Sign In')}}</button>
        </div>
    </form>

@endsection
