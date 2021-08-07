@extends('web.common.content')
@section('title', 'Login')
@section('page', 'login')
@section('content')

{{-- <img class="mb-3" src="{{ asset('image/logo.svg') }}"/> --}}

<div class="panel-content" 
     style="border-radius: 5px;"
>
    <div class="panel-header">
        <i class="fas fa-lock"></i>
        <span>
            Digite seus dados de acesso.
        </span>
    </div>

    <div class="panel-body" 
         style="box-shadow: 0 5px 10px rgb(0 0 0 / 0.2)">
        <form method="POST" 
              action="{{ route('login.access') }}"
        >
            @CSRF

            <div class="input-content">
                <label for="email"><i class="fas fa-at"></i> Login</label>
                <input  type="text"
                        class="form-control"
                        name="email"
                        placeholder="exemplo@app.com"
                        value="{{ old('email') }}"
                        maxlength="255"
                />
            </div>

            <div class="input-content">
                <label for="password"><i class="fas fa-key"></i> Senha</label>
                <div>
                    <div class="input-group">
                        <input  type="password"
                                class="form-control"
                                name="password"
                                id="password"
                                placeholder="*****"
                                maxlength="255"
                      />
                      <div class="input-group-prepend">
                        <div class="input-group-text" 
                             style="background-color: black; border-radius: 0px 5px 5px 0px;">
                            <a class="text-light" 
                               type="button" 
                               onclick="showPassword()"
                            >
                                <i class="far fa-eye-slash" 
                                   id="iconEye"></i>
                            </a>
                        </div>
                      </div>
                      
                    </div>
                  </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center mt-4">
                    <div>
                        <button type="submit"
                                class="btn btn-dark btn-lg"
                                id="loginButton"
                                onclick="loginAnimation()">
                                <b>LOGIN</b>
                        </button>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center mt-1">
                    <div> 
                        <a  type="submit"
                            class="text-dark"
                            style="font-size: 10px;"
                            id="log inButton"
                            href="{{ route('register.index') }}"
                        >
                            <b>Registrar <i class="fas fa-share"></i></b>
                        </a>
                    </div>
                </div>
            </div>

            

        </form>
    </div>

</div>

<div class="errors mt-2">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
            </ul>
        </div>
    @endif
</div>

{{-- #0f1318 Side --}}
{{-- #595b5d Side Up box --}}

<script>

    function loginAnimation() {
        
        var span = document.createElement('span');
        span.classList.add('spinner-border', 'spinner-border-sm');
        span.setAttribute('role', 'status');
        span.setAttribute('aria-hidden', 'true');
        span.setAttribute('style', 'margin-right: 3px;');

        document.getElementById('loginButton').innerText = '';
        document.getElementById('loginButton').append(span, 'Carregando...');

    }

    function showPassword() {

        const inputPassword = $('#password');
        const iconEye       = $('#iconEye');

        if (inputPassword.prop('type') === 'password') {
            inputPassword.prop('type', 'text');
            iconEye.removeClass().addClass('far fa-eye');
        } else {
            inputPassword.prop('type', 'password');
            iconEye.removeClass().addClass('far fa-eye-slash');
        }
    }
</script>

@endsection