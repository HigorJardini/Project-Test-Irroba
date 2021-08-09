<nav id="navbar-admin">
    <div class="brand">
    </div>

    <div class="profile-section">

        <div class="profile-content">
            <div class="">
            </div>

            <div class="logout-content mr-2">
                <a id="alertNotificationMessageExt" 
                   data-toggle="dropdown" 
                   aria-haspopup="true" 
                   aria-expanded="false"
                   onclick="alertNotificationMessageExtLoadingContent()"
                >
                    <div style="z-index: 1">
                        <i class="fas fa-bell alert-notification-message-ext" style="font-size: 14pt; margin-top: 5px;"></i>
                    </div>
                    <div class="alert-notification-message-ext-number" 
                         onmousedown="return false" 
                         onselectstart="return false">
                        <span id="alert-notification-message-ext-count">0</span>
                    </div>
                </a>
                <div class="dropdown-menu p-4" aria-labelledby="alertNotificationMessageExt" id="alertNotificationMessageExtContent">
                    <div class="text-nowrap user-msg user-fix">
                        Nenhuma notificação recente encontrada.
                    </div>
                </div>
            </div>

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


