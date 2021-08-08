@extends('web.common.content')
@section('title', 'Matérias')
@section('page', 'metters')
@section('content')

<div class="page-header">
    <h1>Listagem de matérias</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="disabled text-secondary">Aulas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a class="text-dark" href="{{ route('admin.metters.index') }}">Matérias</a></li>
        </ol>
    </div>

</div>

@permission('create-metters')

    <div class="row justify-content-end mr-2 mb-4" 
         style="height: 20px;"
    >
        <a class="btn btn-primary btn-sm"
           href="{{route('admin.metters.create')}}"
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
        Página Atual: <b>{{ json_decode($metters->toJson())->from ?? 0 }} - {{ json_decode($metters->toJson())->to ?? 0 }}</b> de <b>{{ json_decode($metters->toJson())->total }}</b>
    </p>
</div>

<div class="table-responsive">
    <table class="table table-hover table-sm data-table" >

        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th colspan="1"
                    scope="col"
                    class="text-center"
                    >
                        Ação
                </th>
            </tr>
        </thead>
    
        <tbody>
            @if(count($metters) > 0)
                @foreach($metters as $metter)
                    <tr id="tr-user-id-{{ $metter->id }}">

                        <td class="font-default">
                            {{ $metter->id }}
                        </td>

                        <td class="font-default">
                            {{  $metter->name }}
                        </td>
                        
                        <td class="indexTd" style="width: 85px;">

                            @permission('update-metters')
                                <div style="display: inline-block">
                                    <a  class="btn btn-primary btn-sm"
                                        href="{{route('admin.metters.view', $metter->id)}}"
                                        data-toggle="tooltip"
                                        title="Editar matéria"
                                        data-placement="left"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            @endpermission

                            @permission('delete-users')
                                <div style="display: inline-block">
                                    <a  class="btn btn-danger btn-sm"
                                        onclick="delete_metter({{ $metter->id }})"
                                        data-toggle="tooltip"
                                        title="Deletar matéria"
                                        data-placement="left"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            @endpermission

                        </td>

                    </tr>
                @endforeach
            @else 
                <tr>
                    <td class="text-center" colspan="9">
                        Nenhuma matéria cadastrada
                    </td>
                </tr>
            @endif
    
        </tbody>
    
    </table>

    <div class="row" style="width: 100%;">
        <div class="col-12 d-flex justify-content-center">
            {{ $metters->withQueryString()->links() }}
        </div>
    </div>

</div>

@endsection