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

            <section class="hero is-info is-bold is-medium">
              <!-- Hero header: will stick at the top -->
              <div class="hero-head">
                <header class="nav">
                  <div class="container">
                    <div class="nav-left">
                      <router-link to="/" exact>
                          <a class="nav-item">
                            DOCUMENTS MANAGEMENT
                          </a>
                      </router-link>
                    </div>
                    <span class="nav-toggle">
                      <span></span>
                      <span></span>
                      <span></span>
                    </span>
                    <div class="nav-right nav-menu">
                      <router-link to="/">
                        <a class="nav-item">Accueil</a>
                      </router-link>
                      @if (Auth::user()->role === 'admin')
                        <router-link to="/admin">
                          <a class="nav-item">Espace d'administration</a>
                        </router-link>
                      @endif
                      <a class="nav-item">
                        {{ Auth::user()->name }}
                      </a>
                      <span class="nav-item">
                        <a class="button is-small is-info is-inverted" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                          <span class="icon">
                            <i class="fa fa-sign-out"></i>
                          </span>
                          <span>Déconnexion</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                      </span>
                    </div>
                  </div>
                </header>
              </div>

              <!-- Hero content: will be in the middle -->
              <div class="hero-body">
                <div class="container has-text-centered">
                  <h1 class="title">
                    DOCUMENTS MANAGEMENT
                  </h1>
                  <h2 class="subtitle">
                    Application de management des documents OXDATA
                  </h2>
                </div>
              </div>

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
