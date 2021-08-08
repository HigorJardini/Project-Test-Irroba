@extends('web.common.content')
@section('title', 'Matéria')
@section('page', 'metter')
@section('content')

<div class="page-header">
    <h1>@if($type == 'edit') Editar Matéria - {{ $users->name??'' }} @elseif($type == 'create') Criar Matéria @endif</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.dashboard') }}">Aulas</a></li>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.metters.index') }}">Matérias</a></li>
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
            action="{{route('admin.metters.update', $metters->id)}}"
        @elseif($type == 'create')
            action="{{route('admin.metters.create.store')}}"
        @endif
            method="POST"
    >
        @if($type == 'edit')
            @METHOD('PUT')
        @endif

        @CSRF

        <div class="row">

            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <label for="name">Nome <b class="red">*</b></label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $metters->name??'' }}"
                       id="name"
                       required>
            </div>
            
        </div>

        <div class="row">
            <div class="form-group col-12">
                @if($type == 'edit')
                    <button type="submit"
                            class="btn btn-primary float-right">
                            Atualizar Matéria
                    </button>
                @elseif($type == 'create')
                    <button type="submit"
                            class="btn btn-success float-right">
                            Criar Matéria
                    </button>
                @endif
            </div>
        </div>

    </form>

</div>

@endsection
