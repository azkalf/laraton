@extends('layouts.loginbsb')

@section('content')
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">Admin<b>BSB</b></a>
        <small>Admin BootStrap Based - Material Design</small>
    </div>
    <div class="card">
        <div class="body">
            <form action="{{ route('password.email') }}" id="forgot_password" method="POST">
                @csrf
                <div class="msg">
                    Masukkan Email yang anda daftarkan, kami akan mengirimkan link untuk me-reset password ke email anda.
                </div>
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

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Kirim Link</button>

                <div class="row m-t-20 m-b--5 align-center">
                    <a href="{{url('login')}}">Login!</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
