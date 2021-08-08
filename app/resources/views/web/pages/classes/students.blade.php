@extends('web.common.content')
@section('title', 'Gerenciamento de Alunos')
@section('page', 'studentsList')
@section('content')

<div class="page-header">
    <h1>Gerenciamento de alunos - Aula: {{$class->name}}</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="disabled text-secondary">Aulas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a class="text-dark" href="{{ route('admin.classes.index') }}">Listagem</a></li>
        </ol>
    </div>

</div>

<div class="row justify-content-end mr-2" style="height: 20px;">
    <p>
        Página Atual: <b>{{ json_decode($users->toJson())->from ?? 0 }} - {{ json_decode($users->toJson())->to ?? 0 }}</b> de <b>{{ json_decode($users->toJson())->total }}</b>
    </p>
</div>

<div class="table-responsive">
    <table class="table table-hover table-sm data-table" >

        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th colspan="1"
                    scope="col"
                    class="text-center"
                    >
                        Ação
                </th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) > 0)
                @foreach($users as $user)
                    <tr id="tr-user-id-{{ $user->id }}">
                        <td class="font-default">
                            {{ $user->user->id }}
                        </td>

                        <td class="font-default">
                            {{  $user->user->name }}
                        </td>
                        
                        <td class="font-default">
                            {{  $user->user->email }}
                        </td>
                        
                        <td class="indexTd" style="width: 85px;">

                            @if($user->accept)
                                <div style="display: inline-block">
                                    <div data-toggle="tooltip"
                                        title="Inscrição aceita"
                                        data-placement="left"
                                    >
                                        <a  class="btn btn-success btn-sm text-light disabled"
                                            id="btn-{{ $user->id }}"
                                        >
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                    </div>
                                </div>

                            @elseif(!$user->accept && $user->reason === null)

                                <div style="display: inline-block">
                                    <a  class="btn btn-success btn-sm"
                                        onclick="accept_request_class({{$user->id}})"
                                        data-toggle="tooltip"
                                        title="Aceitar aluno"
                                        data-placement="left"
                                        id="btn-{{ $user->id }}"
                                    >
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                </div>

                                <div style="display: inline-block">
                                    <a  class="btn btn-danger btn-sm"
                                        onclick="deny_request_class({{$user->id}})"
                                        data-toggle="tooltip"
                                        title="Recusar Aluno"
                                        data-placement="left"
                                        id="btn-aux-{{ $user->id }}"
                                    >
                                        <i class="fas fa-user-times"></i>
                                    </a>
                                </div>

                            @elseif(!$user->accept && $user->reason !== null)
                                <div style="display: inline-block">
                                    <div data-toggle="tooltip"
                                        title="Inscrição aceita"
                                        data-placement="left"
                                    >
                                        <a  class="btn btn-danger btn-sm text-light disabled"
                                            id="btn-{{ $user->id }}"
                                        >
                                            <i class="fas fa-user-times"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </td>

                    </tr>
                @endforeach
            @else 
                <tr>
                    <td class="text-center" colspan="9">
                        Nenhuma aluno cadastrado
                    </td>
                </tr>
            @endif
    
        </tbody>
    
    </table>

    <div class="row" style="width: 100%;">
        <div class="col-12 d-flex justify-content-center">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

</div>

@endsection