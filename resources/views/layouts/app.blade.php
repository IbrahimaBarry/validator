<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/app.css">

    </head>
    <body>
        
        <div id="app">
            <nav class="navbar">
              <div class="navbar-brand">
                <a class="navbar-item" href="http://bulma.io">
                  <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">
                </a>

                <a class="navbar-item is-hidden-desktop">
                  <span class="icon" style="color: #333;">
                    <i class="fa fa-github"></i>
                  </span>
                </a>

                <a class="navbar-item is-hidden-desktop" href="https://twitter.com/jgthms" target="_blank">
                  <span class="icon" style="color: #55acee;">
                    <i class="fa fa-twitter"></i>
                  </span>
                </a>

                <div class="navbar-burger burger" data-target="navMenuExample">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </div>

              <div id="navMenu" class="navbar-menu">
                <div class="navbar-start">
                  <router-link tag="a" to="/" class="navbar-item">
                      Home
                  </router-link>
                  <div :class="{'navbar-item': true, 'has-dropdown': true, 'is-active': dropdown}"
                     @mouseover.prevent="dropdown = true" @mouseleave.prevent="dropdown = false">
                  <a class="navbar-link">
                    Docs
                  </a>

                  <div v-if="dropdown" class="navbar-dropdown">
                    <a class="navbar-item">
                      Overview
                    </a>
                    <a class="navbar-item">
                      Elements
                    </a>
                    <a class="navbar-item">
                      Components
                    </a>
                    <hr class="navbar-divider">
                    <div class="navbar-item">
                      Version 1.0.0
                    </div>
                  </div>
                </div>
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

            <section class="hero is-primary">
              <div class="hero-body">
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

        <script src="js/app.js"></script>

        <!-- <script>
            iziToast.info({
                title: 'Hello',
                message: 'Welcome!',
                position: 'topCenter'
            });
        </script> -->
    </body>
</html>
