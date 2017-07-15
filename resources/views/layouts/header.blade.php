<section class="hero is-primary is-bold is-medium">
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
          <a class="nav-item is-active">
            {{ Auth::user()->name }}
          </a>
          <!-- <a class="nav-item">
            Examples
          </a>
          <a class="nav-item">
            Documentation
          </a> -->
          <span class="nav-item">
            <a class="button is-primary is-inverted" href="{{ route('logout') }}"
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
  <div class="hero-body" style="padding: 40px 0">
    <div class="container has-text-centered">
      <h1 class="title">
        DOCUMENTS MANAGEMENT
      </h1>
      <h2 class="subtitle">
        Application de management des documents OXDATA
      </h2>
    </div>
  </div>

  <!-- Hero footer: will stick at the bottom -->
  <div class="hero-foot">
    <nav class="tabs is-boxed is-centered">
      <div class="container">
        <ul>
            <router-link tag="li" to="/" exact>
                <a>Documents</a>
            </router-link>

            <router-link tag="li" to="/documents/reception" exact>
                <a>Documents réceptionnés</a>
            </router-link>

            <router-link tag="li" to="/documents/scan" exact>
                <a>Documents scannés</a>
            </router-link>
        </ul>
      </div>
    </nav>
  </div>
</section>