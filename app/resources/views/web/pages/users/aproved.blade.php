@extends('web.common.content')
@section('title', 'Aproved')
@section('page', 'aproved')
@section('content')

<div class="page-header">
    <h1>Listagem de aprovação dos usuários</h1>
</div>

<div class="row justify-content-end mr-2" style="height: 20px;">
    <p>
        Página Atual: <b>{{ json_decode($users->toJson())->from }} - {{ json_decode($users->toJson())->to }}</b> de <b>{{ json_decode($users->toJson())->total }}</b>
    </p>
</div>

<div class="table-responsive">
    <table class="table table-hover table-sm data-table" >

        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Tags</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Data</th>
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
                            {{ $user->id }}
                        </td>

                        <td class="font-default">
                            {{  $user->tags }}
                        </td>

                        <td class="font-default">
                            {{  $user->name }}
                        </td>
                    
                        <td class="font-default">
                            {{  $user->email }}
                        </td>
        
                        <td class="font-default" style="width: 125px;">
                            {{  $user->date }}
                        </td>
                        
                        <td class="indexTd" style="width: 85px;">
                            <div style="display: inline-block">
                                <a  class="btn btn-success btn-sm"
                                    onclick="aprove_user({{ $user->id }})"
                                    data-toggle="tooltip"
                                    title="Aprovar usuário"
                                    data-placement="left"
                                >
                                    <i class="fas fa-user-check"></i>
                                </a>
                            </div>
                            <div style="display: inline-block">
                                <a  class="btn btn-danger btn-sm"
                                    onclick="delete_user({{ $user->id }})"
                                    data-toggle="tooltip"
                                    title="Reprovar usuário (deletar)"
                                    data-placement="left"
                                >
                                    <i class="fas fa-user-times"></i>
                                </a>
                            </div>
                        </td>
        
                    </tr>
                @endforeach
            @else 
                <tr>
                    <td class="text-center" colspan="9">
                        Nenhum usuário aguardando aprovação
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