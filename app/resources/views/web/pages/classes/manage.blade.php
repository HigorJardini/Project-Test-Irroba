@extends('web.common.content')
@section('title', 'Aulas')
@section('page', 'classes')
@section('content')

<div class="page-header">
    <h1>Listagem de aulas</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="disabled text-secondary">Aulas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a class="text-dark" href="{{ route('admin.classes.index') }}">Listagem</a></li>
        </ol>
    </div>

</div>

@permission('create-classes')

    <div class="row justify-content-end mr-2 mb-4" 
         style="height: 20px;"
    >
        <a class="btn btn-primary btn-sm"
           href="{{route('admin.classes.create')}}"
           data-toggle="tooltip"
           title="Criar nova matéria"
           data-placement="left"
        >
            <i class="fas fa-layer-plus" 
               style="font-size: 16px;"
            >
            </i>
        </a>
    </div>

@endpermission

<div class="row justify-content-end mr-2" style="height: 20px;">
    <p>
        Página Atual: <b>{{ json_decode($classes->toJson())->from ?? 0 }} - {{ json_decode($classes->toJson())->to ?? 0 }}</b> de <b>{{ json_decode($classes->toJson())->total }}</b>
    </p>
</div>

<div class="table-responsive">
    <table class="table table-hover table-sm data-table" >

        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Professor(a)</th>
                <th scope="col">Matéria</th>
                <th colspan="1"
                    scope="col"
                    class="text-center"
                    >
                        Ação
                </th>
            </tr>
        </thead>
        <tbody>
            @if(count($classes) > 0)
                @foreach($classes as $classe)
                    <tr id="tr-user-id-{{ $classe->id }}">
                        <td class="font-default">
                            {{ $classe->id }}
                        </td>

                        <td class="font-default">
                            {{  $classe->name }} <i class="fas fa-align-right text-info" data-toggle="tooltip" data-placement="top" title="Descrição: {{$classe->description}}"></i>
                        </td>
                        
                        <td class="font-default">
                            {{  $classe->user->name }}
                        </td>

                        <td class="font-default">
                            {{  $classe->metters->name }}
                        </td>
                        
                        <td class="indexTd" style="width: 155px;">

                            @permission('update-classes')
                                <div style="display: inline-block">
                                    <a  class="btn btn-primary btn-sm"
                                        href="{{route('admin.classes.view', $classe->id)}}"
                                        data-toggle="tooltip"
                                        title="Editar matéria"
                                        data-placement="left"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            @endpermission

                            @permission('delete-classes')
                                <div style="display: inline-block">
                                    <a  class="btn btn-danger btn-sm"
                                        onclick="delete_class({{ $classe->id }})"
                                        data-toggle="tooltip"
                                        title="Deletar Aula"
                                        data-placement="left"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            @endpermission

                            @permission('request-classes')

                                @if(!$classe->solicitation_exist['status'])

                                    <div style="display: inline-block">
                                        <a  class="btn btn-success btn-sm"
                                            onclick="request_class({{ $classe->id }})"
                                            data-toggle="tooltip"
                                            title="Solicitar entrada"
                                            data-placement="left"
                                            id="btn-{{ $classe->id }}"
                                        >
                                            <i class="fas fa-user-plus"></i>
                                        </a>
                                    </div>

                                @elseif($classe->solicitation_exist['status'] && $classe->solicitation_exist['accept'] && $classe->solicitation_exist['reason'] === null)
                                    
                                    <div style="display: inline-block">
                                        <div data-toggle="tooltip"
                                             title="Inscrição aceita"
                                             data-placement="left"
                                        >
                                            <a  class="btn btn-success btn-sm text-light disabled"
                                                id="btn-{{ $classe->id }}"
                                            >
                                                <i class="fas fa-user-check"></i>
                                            </a>
                                        </div>
                                    </div>

                                    @permission('request-cancel-classes')

                                        <div style="display: inline-block">
                                            <a  class="btn btn-danger btn-sm text-light"
                                                onclick="cancel_class({{ $classe->id }})"
                                                data-toggle="tooltip"
                                                title="Cancelar inscrição"
                                                data-placement="left"
                                                id="btn-aux-{{ $classe->id }}"
                                            >
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </a>
                                        </div>

                                    @endpermission

                                @elseif($classe->solicitation_exist['status'] && !$classe->solicitation_exist['accept'] && $classe->solicitation_exist['reason'] !== null)
                                    
                                    <div style="display: inline-block">
                                        <div data-toggle="tooltip"
                                             title="Inscrição recusada (motivo: {{$classe->solicitation_exist['reason']}})"
                                             data-placement="left"
                                        >
                                            <a  class="btn btn-danger btn-sm text-light disabled"
                                                id="btn-{{ $classe->id }}"
                                            >
                                                <i class="fas fa-user-times"></i>
                                            </a>
                                        </div>
                                    </div>

                                @else

                                    <div style="display: inline-block">
                                        <a  class="btn btn-warning btn-sm text-light disabled"
                                            data-toggle="tooltip"
                                            title="Solicitação em análise"
                                            data-placement="left"
                                            id="btn-{{ $classe->id }}"
                                        >
                                            <i class="fas fa-user-clock"></i>
                                        </a>
                                    </div>

                                @endif

                                
                            @endpermission
                        </td>

                    </tr>
                @endforeach
            @else 
                <tr>
                    <td class="text-center" colspan="9">
                        Nenhuma aula cadastrada
                    </td>
                </tr>
            @endif
    
        </tbody>
    
    </table>

    <div class="row" style="width: 100%;">
        <div class="col-12 d-flex justify-content-center">
            {{ $classes->withQueryString()->links() }}
        </div>
    </div>

</div>

@endsection