@extends('layouts.loginbsb')

<?php
    $setting = App\Setting::first();
?>
@section('content')
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">{{$setting->appname}}</a>
        <small>{{$setting->subname}}</small>
    </div>
    <div class="card">
        <div class="body">
            {{ Form::open(['url'=>'login']) }}
                @csrf
                <div class="msg">Masukkan email dan password.</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        {{ Form::email('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Email', 'required'=>'required', 'autofocus']) }}
                    </div>
                    @if ($errors->has('email'))
                        {{ Form::label('email', $errors->first('email'), ['id'=>'email-error', 'class'=>'error']) }}
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'required'=>'required']) }}
                    </div>
                    @if ($errors->has('password'))
                        {{ Form::label('password', $errors->first('password'), ['id'=>'password-error', 'class'=>'error']) }}
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        {{ Form::checkbox('remember', 1, old('remember') ? true : false, ['class'=>'filled-in chk-col-green']) }}
                        <label for="rememberme">Ingat Saya</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-green waves-effect" type="submit">LOGIN</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-6">
                        <a href="{{ route('register') }}">Daftar Sekarang!</a>
                    </div>
                    <div class="col-xs-6 align-right">
                        <a href="{{ route('password.request') }}">Lupa Password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
