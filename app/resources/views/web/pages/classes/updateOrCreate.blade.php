@extends('web.common.content')
@section('title', 'Aula')
@section('page', 'class')
@section('content')

<div class="page-header">
    <h1>@if($type == 'edit') Editar Aula - {{ $users->name??'' }} @elseif($type == 'create') Criar Aula @endif</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="disabled text-secondary">Aulas</a></li>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.classes.index') }}">Lisatagem</a></li>
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
                        href="{{ route('admin.classes.create') }}"
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
            action="{{route('admin.classes.update', $classes->id)}}"
        @elseif($type == 'create')
            action="{{route('admin.classes.create.store')}}"
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
                       value="{{ $classes->name??'' }}"
                       id="name"
                       required>
            </div>

        </div>

        <div class="row">

            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <label for="description">Descrição <b class="red">*</b></label>
                <textarea type="textarea"
                          name="description"
                          class="form-control"
                          id="description"
                          rows="3"
                          required>{{ $classes->description??'' }}</textarea>
            </div>
            
        </div>

        <div class="row">

            <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <label for="metter">Matéria <b class="red">*</b></label>
                <select class="form-control"
                        name="id"
                        id="metter"
                >
                    @foreach($metters as $metter)
                        <option value="{{$metter->id}}" @if(isset($classes) && ($metter->id == $classes->metter_id)) selected @endif">{{$metter->name}}</option>
                    @endforeach
                </select>
            </div>

            @permission('update-classes-teacher')

                <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <label for="metter">Professores <b class="red">*</b></label>
                    <select class="form-control"
                            name="teacher"
                            id="teacher"
                    >
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}" @if(isset($classes) && ($teacher->id == $classes->user_id)) selected @endif">{{$teacher->name}}</option>
                        @endforeach
                    </select>
                </div>

            @endpermission
            
        </div>

        <div class="row">
            <div class="form-group col-12">
                @if($type == 'edit')
                    <button type="submit"
                            class="btn btn-primary float-right">
                            Atualizar Aula
                    </button>
                @elseif($type == 'create')
                    <button type="submit"
                            class="btn btn-success float-right">
                            Criar Aula
                    </button>
                @endif
            </div>
        </div>

    </form>

</div>

@endsection
