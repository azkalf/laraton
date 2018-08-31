@extends('layouts.loginbsb')

@section('content')
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">Admin<b>BSB</b></a>
        <small>Admin BootStrap Based - Material Design</small>
    </div>
    <div class="card">
        <div class="body">
            <form action="{{ route('password.request') }}" id="forgot_password" method="POST">
                @csrf
                <div class="msg">
                    Enter your email address and your new password.
                </div>
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <label class="error" for="email" id="email-error">{{ $errors->first('email') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line{{ $errors->has('password') ? ' error' : '' }}">
                        <input type="password" class="form-control" name="password" placeholder="New Password" required autofocus>
                    </div>
                    @if ($errors->has('password'))
                        <label class="error" for="password" id="password-error">{{ $errors->first('password') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line{{ $errors->has('password_confirmation') ? ' error' : '' }}">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password" required autofocus>
                    </div>
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">RESET MY PASSWORD</button>
            </form>
        </div>
    </div>
</div>
@endsection
