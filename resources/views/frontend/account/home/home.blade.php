@extends('frontend.account.components.body-login')

@section('title', 'Inicio | EduardSearch')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<div class="container-screen" id="home-container">
    <aside class="sidebar" v-if="loadedPage">
      <div class="sidebar-header" @click="redirecHome">
        <img src="/img/default-user.png" alt="Logo" class="logo">
        <span class="brand" v-if="customer != null">@{{customer.first_name}}</span>
      </div>
      <nav class="menu">
        <ul>
          <li>
            <router-link to="/dashboard">
              <i class="fa fa-tachometer"></i> Monitoreo
            </router-link>
          </li>
          <li>
            <router-link to="/data">
              <i class="fa fa-database"></i> Data
            </router-link>
          </li>
          <li>
            <router-link to="/search">
              <i class="fa fa-search"></i> Busquedas
            </router-link>
          </li>
          <li>
            <router-link to="/analitycs">
              <i class="fa fa-bar-chart"></i> Analiticas
            </router-link>
          </li>
          <li>
            <router-link to="/mailing">
              <i class="fa fa-envelope"></i> Mailing
            </router-link>
          </li>
          <li>
            <router-link to="/whasapp-sender">
              <i class="fa fa-whatsapp"></i> Whatsapp Sender
            </router-link>
          </li>
          <li class="configuration-item-nav">
            <router-link to="/settings">
              <i class="fa fa-cog"></i> Configuracion
            </router-link>
          </li>
        </ul>
      </nav>
      <div class="close-session" @click="closeSession()">
  	    <i class="fa fa-sign-out"></i> Close session
      </div>
    </aside>
    <main class="content-page" v-if="loadedPage">
      <header id="header-page">
        <div v-if="isBackAction()" @click="backPage()" class="section-back">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </div>
        <h1>@{{$route.name}}</h1>
      </header>
      <section class="dashboard-content" id="content-page">
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
        <div class="container">
          <router-view></router-view>
        </div>
      </section>
      <div class="footer">
        <div class="pull-right">
          <span style="margin-right:8px;" class="text-muted font-bold welcome-message">@{{$appName}}</span>  <a class="text-muted" href="/"><strong>@{{$versionApp}}</strong> </a> 
        </div>
        <div>
          <strong>Copyright</strong> @{{$appName}} © @{{$currentYear}}
        </div>
      </div>
    </main>
  </div>
@endsection

@section('custom-footer')
    <script src="{{ asset('js/home/components/home.js') }}"></script>
    <script src="{{ asset('js/home/components/nav-header.js') }}"></script>
    <script src="{{ asset('js/home/components/sections/conectores.js') }}"></script>
    <script src="{{ asset('js/home/components/sections/eventos.js') }}"></script>
    <script src="{{ asset('js/home/components/sections/indices.js') }}"></script>
    <script src="{{ asset('js/home/components/nav-col.js') }}"></script>
    <script src="{{ asset('js/home/components/nav-drop.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard/record-search.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard/limit-search.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard/limit-batch.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard/detail-usage-search.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard/detail-usage-batch.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard/usage-operations-search.js') }}"></script>
    <script src="{{ asset('js/home/components/dashboard.js') }}"></script>
    <script src="{{ asset('js/home/components/data.js') }}"></script>
    <script src="{{ asset('js/home/components/settings.js') }}"></script>
    <script src="{{ asset('js/home/components/search.js') }}"></script>
    <script src="{{ asset('js/home/components/support.js') }}"></script>
    <script src="{{ asset('js/home/components/contacts.js') }}"></script>
    <script src="{{ asset('js/home/components/notifications.js') }}"></script>
    <script src="{{ asset('js/home/components/account.js') }}"></script>
    <script src="{{ asset('js/home/components/team.js') }}"></script>
    <script src="{{ asset('js/home/components/key.js') }}"></script>
    <script src="{{ asset('js/home/components/application.js') }}"></script>
    <script src="{{ asset('js/home/components/infraestructura.js') }}"></script>
    <script src="{{ asset('js/home/components/analitycs.js') }}"></script>
    <script src="{{ asset('js/home/components/mailing.js') }}"></script>
    <script src="{{ asset('js/home/components/whatsapp-sender.js') }}"></script>
    <script src="{{ asset('js/home/components/create-mail.js') }}"></script>
    <script src="{{ asset('js/home/components/mail-sender.js') }}"></script>
    <script src="{{ asset('js/home/eduard-search.js') }}"></script>
@endsection