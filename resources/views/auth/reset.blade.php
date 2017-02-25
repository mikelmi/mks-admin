@extends('admin::auth')

@section('page-title')
    {!! trans('admin::auth.Reset Password') !!}
    - @parent
@endsection

@section('content')

    <form class="card shd" role="form" method="post" action="{{ route('admin.reset.post') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="card-header text-center text-primary">
            <i class="fa fa-unlock fa-3x"></i>
            <div class="text-uppercase">{{trans('admin::auth.Reset Password')}}</div>
        </div>

        <div class="card-block p-x-2">

            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="E-Mail" required>
                @if ($errors->has('email'))
                    <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="{{trans('admin::auth.Password')}}" required>
                @if ($errors->has('password'))
                    <small class="form-control-feedback">{{ $errors->first('password') }}</small>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                <input type="password" class="form-control" name="password_confirmation" placeholder="{{trans('admin::passwords.Confirm')}}" required>
                @if ($errors->has('password_confirmation'))
                    <small class="form-control-feedback">{{ $errors->first('password_confirmation') }}</small>
                @endif
            </div>
        </div>

        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">{{trans('admin::auth.Reset Password')}}</button>
            <a class="btn btn-secondary" href="{{ route('admin.login') }}">{{trans('admin::messages.Cancel')}}</a>
        </div>
    </form>

@endsection
