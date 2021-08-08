@extends('web.common.content')
@section('title', 'Usuários')
@section('page', 'Users')
@section('content')

<div class="page-header">
    <h1>@if($type == 'edit') Editar Usuário - {{ $users->name??'' }} @elseif($type == 'create') Criar Usuário @endif</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="disabled text-secondary">Usuários</a></li>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.users.manage.index') }}">Gerenciamento</a></li>
            @if($type == 'edit')
                <li class="breadcrumb-item active" 
                    aria-current="page"
                >
                    Atualizar
                </li>
            @elseif($type == 'create')
                <li class="breadcrumb-item active" 
                    aria-current="page"
                >
                    <a  class="text-dark"
                        href="{{ route('admin.users.manage.create') }}"
                    >
                        Adicionar
                    </a>
                </li>
            @endif
        </ol>
    </div>

</div>

<div class="container">
    
    @if(isset($result['errors']))
        <div class="alert alert-danger">

            @foreach ($result['errors'] as $error)
                <li class="ms-2">{{ $error }}</li>
            @endforeach

        </div>
    @elseif(isset($result['success']))
        <div class="alert alert-success">
                <li class="ms-2">{{ $result['success'] }}</li>
        </div>
    @endif

    @isset($messages)  
            @dd($messages);
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>            
    @endisset

    <form
        @if($type == 'edit')
            action="{{route('admin.users.manage.update', $users->id)}}"
        @elseif($type == 'create')
            action="{{route('admin.users.manage.create.store')}}"
        @endif
            method="POST"
    >
        @if($type == 'edit')
            @METHOD('PUT')
        @endif

        @CSRF

        <div class="row">

            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <label for="name">Nome <b class="red">*</b></label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $users->name??'' }}"
                       id="name"
                       required>
            </div>

            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <label for="name">Email <b class="red">*</b></label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ $users->email??'' }}"
                       id="email"
                       required>

            </div>
        </div>

        <div class="row">
            <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <label> Senha <i class="fas fa-key"></i> </label>
                <input type="password"
                       name="password"
                       class="form-control"
                       id="password"
                       @if($type == 'create')
                       required
                       @endif>
            </div>
            <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <label> <b class="red">*</b> Tag <i class="fas fa-user-tag"></i> </label>
                <select class="form-control"
                        name="role"
                        id="role"
                        required
                >
                    <option value="1" @if(isset($users) && $users->roles[0]->id == 1) selected @endif>Aluno</option>
                    <option value="2" @if(isset($users) && $users->roles[0]->id == 2) selected @endif>Professor</option>
                    <option value="3" @if(isset($users) && $users->roles[0]->id == 3) selected @endif>Administrador</option>
                </select>
            </div>

            @if($type == 'edit')
                <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label> <b class="red">*</b> Status <i class="fas fa-user-lock"></i> </label>
                    <select class="form-control"
                            name="status"
                            id="status"
                            required
                    >
                        <option value="0" @if(isset($users) && $users->active == 0) selected @endif>Inativo</option>
                        <option value="1" @if(isset($users) && $users->active == 1) selected @endif>Ativo</option>
                    </select>
                </div>
            @endif

        </div>

        <div class="row">
            <div class="form-group col-12">
                @if($type == 'edit')
                    <button type="submit"
                            class="btn btn-primary float-right">
                            Atualizar Uuário
                    </button>
                @elseif($type == 'create')
                    <button type="submit"
                            class="btn btn-success float-right">
                            Criar Usuário
                    </button>
                @endif
            </div>
        </div>

    </form>

</div>

@endsection
