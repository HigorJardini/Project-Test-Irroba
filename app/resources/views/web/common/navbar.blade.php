<nav id="navbar-admin">
    <div class="brand">
    </div>

    <div class="profile-section">

        <div class="profile-content">
            <div class="">
            </div>
            <span></span>
        </div>

        <div class="logout-content">

              <div class="dropdown">
                <a class="dropbtn">
                        <i class="fas fa-user-circle user-color user-icon"></i>
                </a>

                <div class="dropdown-content">
                    @auth
                        <div class="text-nowrap user-msg user-fix">
                            Seja Bem Vindo(a)
                        <br>{{ Auth::user()->name }}</div>
                    @endauth
                    <hr class="user-bar">
                    <a class="user-fix user-exit-color-text" href="{{ route('login.logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        Sair
                    </a>
                </div>
              </div>
        </div>

    </div>
</nav>
