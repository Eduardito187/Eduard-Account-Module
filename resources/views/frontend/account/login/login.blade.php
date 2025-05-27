@extends('frontend.account.components.body-login')

@section('title', 'Login')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div id="container-login" class="container">
        <div class="login-form">
            <div class="avatar">
                <img src="{{ asset('img/picture-logo.png') }}" alt="Avatar">
            </div>
            <h2 v-html="appName"></h2>
            <div id="loginForm">
                @if (session('message-success'))
                <div class="alert alert-success" role="alert">
                    {{ session('message-success') }}
                </div>
                @endif
                @if (session('error-danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error-danger') }}
                </div>
                @endif
                @if (session('error-warning'))
                <div class="alert alert-warning" role="alert">
                    {{ session('error-warning') }}
                </div>
                @endif
                <div v-if="messageInfo.length > 0" :class="'alert '+classMessageInfo" role="alert" v-html="messageInfo"></div>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="email" name="mail" v-model="mail" placeholder="Mail" required>
                </div>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" v-model="password" placeholder="Password" required>
                </div>
                <button type="button" class="btn-eduard-search" :disabled="mail.length == 0 || password.length == 0 ? true : false" @click="validateData">
                    <small>Inicio de sesión</small>
                </button>
                <div class="row">
                    <small class="other-login">O Inicia sesión con:</small>
                </div>
                <button type="button" class="btn-github" @click="redirectGitHub">
                    <small>GitHub</small>
                    <i class="fa fa-github"></i>
                </button>
                <button type="button" class="btn-google mt-2" @click="redirectGoogle">
                    <small>Google</small>
                    <i class="fa fa-google"></i>
                </button>
                <a href="/restore-password" class="forgot-password">¿Has olvidado tu contraseña?</a>
            </div>
            <div>
                <small><strong v-html="versionApp"></strong></small>
            </div>
        </div>
    </div>
@endsection

@section('custom-footer')
    <script src="{{ asset('js/login/form-login.js') }}"></script>
@endsection