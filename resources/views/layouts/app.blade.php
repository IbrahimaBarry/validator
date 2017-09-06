<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        
        <div id="app">
            <nav class="navbar container">
              <div class="navbar-brand">
                <a class="navbar-item" href="{{ url('/') }}">
                  
                </a>
                
                <router-link tag="a" to="/" class="navbar-item is-hidden-desktop" exact>
                  <span class="icon" style="color: #333;">
                    <i class="fa fa-home"></i>
                  </span>
                </router-link>

                <router-link tag="a" to="/admin" class="navbar-item is-hidden-desktop">
                  <span class="icon" style="color: #55acee;">
                    <i class="fa fa-cog"></i>
                  </span>
                </router-link>

                <div class="navbar-burger burger" data-target="navMenu">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </div>

              <div id="navMenu" class="navbar-menu">
                <div class="navbar-start">
                  <router-link tag="a" to="/" class="navbar-item">
                      Accueil
                  </router-link>
                @if (Auth::user()->role === 'admin')
                  <router-link to="/admin" tagb="a" class="navbar-item">
                      Espace administration
                  </router-link>
                @endif
                </div>

                <div class="navbar-end">
                  <div class="navbar-item">
                    <div :class="{'navbar-item': true, 'has-dropdown': true, 'is-active': dropdownUser}"
                     @mouseover.prevent="dropdownUser = true" @mouseleave.prevent="dropdownUser= false">
                    <a class="navbar-link">
                      {{ Auth::user()->name }}
                    </a>

                    <div v-if="dropdownUser" class="navbar-dropdown">
                      <a class="navbar-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();">
                        Déconnexion
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                              </form>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </nav>

            <section class="hero is-info is-bold">
              <div class="hero-body container">
                <p class="title">
                  {{ config('app.name', 'Laravel') }}
                </p>
                <p class="subtitle">
                  Application de  <strong>gestion du processus</strong> de clipping
                </p>
              </div>
            </section>

            <router-view></router-view>
            
        </div>

        <script src="{{ asset('js/app.js' )}}"></script>
    </body>
</html>
