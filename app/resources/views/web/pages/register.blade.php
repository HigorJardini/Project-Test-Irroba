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
            Registrar seus dados de acesso.
        </span>
    </div>

    <div class="panel-body" 
         style="box-shadow: 0 5px 10px rgb(0 0 0 / 0.2)">
        <form method="POST" 
              id="register-form">
            @CSRF

            <div class="input-content">
                <label for="name"><i class="fas fa-user"></i> Nome</label>
                <input  type="text"
                        class="form-control"
                        name="name"
                        placeholder="exemplo"
                        value="{{ old('name') }}"
                        maxlength="255"
                />  
            </div>

            <div style="margin: 5px 0px 5px 0px;">
                <label for="email"><i class="fas fa-at"></i> <b>Email</b></label>
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
                        <div class="input-group-text" style="background-color: black; border-radius: 0px 5px 5px 0px;">
                            <a class="text-light" 
                               type="button" 
                               onclick="showPassword()"
                            >
                                <i class="far fa-eye-slash" 
                                   id="iconEye"
                                >
                                </i>
                            </a>
                        </div>
                      </div>
                      
                    </div>
                  </div>
            </div>

            <label class="mb-1 mt-2"><i class="fas fa-user-tag"></i> <b>Tag</b></label>
            <div class="row">
                <div class="col-4 d-flex justify-content-center"> 
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="radio" 
                               name="role" 
                               id="role1" 
                               value="1" 
                               checked 
                        />
                        <label class="form-check-label" for="role1">
                          Aluno <i class="fas fa-question-circle text-info"
                                   data-toggle="tooltip" 
                                   data-placement="top" 
                                   title="O cadastro será solicitado para acesso de aluno no sistema"
                                ></i>
                        </label>
                      </div>
                </div>
                <div class="col-4 d-flex justify-content-center"> 
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="radio" 
                               name="role" 
                               id="role2" 
                               value="2" 
                        />
                        <label class="form-check-label" 
                               for="role2">
                          Professor <i class="fas fa-question-circle text-info"
                                       data-toggle="tooltip" 
                                       data-placement="top" 
                                       title="O cadastro será solicitado para acesso de professor no sistema"
                                    ></i>
                        </label>
                      </div>
                </div>
                <div class="col-4 d-flex justify-content-center"> 
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="radio" 
                               name="role" 
                               id="role3" 
                               value="3" 
                        />
                        <label class="form-check-label" 
                               for="role3"
                        >
                          Administrador <i class="fas fa-question-circle text-info"
                                           data-toggle="tooltip" 
                                           data-placement="top" 
                                           title="O cadastro será solicitado para acessos administrativos do sistema"
                                        ></i>
                        </label>
                      </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center mt-3">
                    <div>
                        <a
                            class="btn btn-dark btn-lg"
                            id="registerButton"
                            onclick="registerSending()">
                            <b>REGISTRAR</b>
                        </a>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center mt-1">
                    <div> 
                        <a  type="submit"
                            class="text-dark"
                            style="font-size: 10px;"
                            id="loginPage"
                            href="{{route('login.index')}}"
                        >
                            <b>login <i class="fas fa-share"></i></i></b>
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

    function registerSending() {

        const Result = Swal.mixin({
            toast: true,
            width: 310,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2600,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                title: 'title-alert-size',
            },

        });

        var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/register/create`;
        var form_data = $('#register-form').serialize();
   
        $.ajax({
        
            url : url,
            type: 'POST',
            data : form_data
        
        }).done(function(response){ 
            
            var opt_alert = {
            icon: 'success',
            title: `<p>${response}</p>`
            };

            Result.fire(opt_alert);

            $('#registerButton').addClass('disabled');
            $('#loginPage').addClass('disabled');

            timerInterval = setInterval(() => {
                location.href = '/';
            }, 2600)

        }).fail(function(response) {

            var errors = '';

            Object.values(response.responseJSON.errors).forEach(item => {
                errors += "- " + item.join() + '</br>';
            });

            var opt_alert = {
            icon: 'error',
            title: `<p>${errors}</p>`
            };

            Result.fire(opt_alert);

        });

    }
</script>

@endsection