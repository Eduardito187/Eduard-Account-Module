@extends('frontend.account.components.body-login')

@section('title', 'Reset Password|EduardSearch')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div id="container-reset" class="container">
        <div class="login-form">
            <div class="avatar">
                <img src="{{ asset('img/picture-logo.png') }}" alt="Avatar">
            </div>
            <h2 v-html="appName"></h2>
            <div id="loginForm">
                <div v-if="messageInfo.length > 0" :class="'alert '+classMessageInfo" role="alert" v-html="messageInfo"></div>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="email" name="mail" v-model="mail" placeholder="Mail" required>
                </div>
                <button type="button" class="btn-eduard-search" :disabled="mail.length == 0 ? true : false" @click="validateData">
                    <small>Enviar mail de reseteo</small>
                </button>
            </div>
            <div>
                <small><strong v-html="versionApp"></strong></small>
            </div>
        </div>
    </div>
@endsection

@section('custom-footer')
    <script src="{{ asset('js/login/form-restore.js') }}"></script>
@endsection