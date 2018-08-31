@extends('layouts.registerbsb')

@section('content')
<div class="signup-box">
    <div class="logo">
        <a href="javascript:void(0);">Admin<b>BSB</b></a>
        <small>Admin BootStrap Based - Material Design</small>
    </div>
    <div class="card">
        <div class="body">
            <form id="sign_up" method="POST">
                {{ Form::open(['url'=>'register']) }}
                <div class="msg">Register a new membership</div>
                @include('common.errors')
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line{{ $errors->has('name') ? ' error' : '' }}">
                        {{ Form::text('name', old('name'), ['placeholder'=>'Nama User', 'class'=>'form-control', 'required'=>'required', 'autofocus'])}}
                    </div>
                    @if ($errors->has('name'))
                        <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">face</i>
                    </span>
                    <div class="form-line{{ $errors->has('fullname') ? ' error' : '' }}">
                        {{ Form::text('fullname', old('fullname'), ['placeholder'=>'Nama Lengkap', 'class'=>'form-control', 'required'=>'required', 'autofocus'])}}
                    </div>
                    @if ($errors->has('fullname'))
                        <label id="fullname-error" class="error" for="fullname">{{ $errors->first('fullname') }}</label>
                    @endif
                </div>
                <div class="form-group form-float">
                    <input type="radio" name="gender" id="male" class="with-gap" value="m">
                    <label for="male">Laki-laki</label>
                    <input type="radio" name="gender" id="female" class="with-gap" value="f">
                    <label for="female" class="m-l-20">Perempuan</label>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        {{ Form::email('email', old('email'), ['placeholder'=>'Email', 'class'=>'form-control', 'required'=>'required'])}}
                    </div>
                    @if ($errors->has('email'))
                        <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line{{ $errors->has('password') ? ' error' : '' }}">
                        {{ Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control', 'required'=>'required'])}}
                    </div>
                    @if ($errors->has('password'))
                        <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        {{ Form::password('password_confirmation', ['placeholder'=>'Password Lagi', 'class'=>'form-control', 'required'=>'required'])}}
                    </div>
                </div>
                <div class="input-group">
                    {{ Form::checkbox('terms', 'terms', 0, ['class'=>'filled-in chk-col-pink form-control', 'id'=>'terms'])}}
                    <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
                    @if ($errors->has('term'))
                        <label id="term-error" class="error" for="term">{{ $errors->first('term') }}</label>
                    @endif
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">DAFTAR</button>

                <div class="m-t-25 m-b--5 align-center">
                    <a href="{{ route('login') }}">Sudah punya Akun?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
