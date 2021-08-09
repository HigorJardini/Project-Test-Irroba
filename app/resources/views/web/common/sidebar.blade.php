<nav id="sidebar-admin">

    <div class="header">
        <i class="fas fa-bars"></i>
        <span>NAVEGAÇÃO</span>
    </div>

    <ul class="menu-content">

        <li>
            <a href="{{route('admin.dashboard')}}">
                <i class="fas fa-home"></i>
                Home
            </a>
        </li>

        <li>
            <a href="#classes" onclick="handleCollapse(event, 'classes')">
                <i class="fas fa-users-class"></i>
                Aulas
                <i class="fas fa-caret-right caret"></i>
            </a>
            <ul class="sub-menu-content" id="classes" data-collapse="false">

                @permission('read-classes')

                <li>
                    <a href="{{route('admin.classes.index')}}">Listagem</a>
                </li>

                @endpermission

                @permission('read-metters')

                    <li>
                        <a href="{{route('admin.metters.index')}}">Matérias</a>
                    </li>

                @endpermission
            </ul>
        </li>

        @permission('read-config')

            <li>
                <a href="#config" onclick="handleCollapse(event, 'config')">
                    <i class="fas fa-cog"></i>
                    Configurações
                    <i class="fas fa-caret-right caret"></i>
                </a>
                <ul class="sub-menu-content" id="config" data-collapse="false">

                    @permission('read-users')

                        <li>
                            <a href="#users" onclick="handleCollapse(event, 'users')">
                                <i class="fas fa-users-cog"></i>
                                Usuários
                                <i class="fas fa-caret-right caret"></i>
                            </a>
                            <ul class="sub-menu-content" id="users" data-collapse="false">

                                @permission('read-users-aproved')
                                    <li>
                                        <a href="{{route('admin.users.aproved.index')}}">Aprovação</a>
                                    </li>
                                @endpermission
                                
                                @permission('read-users-manage')
                                    <li>
                                        <a href="{{route('admin.users.manage.index')}}">Gerenciar</a>
                                    </li>
                                @endpermission

                                @permission('access-panel-manage-user-permission')
                                    <li>
                                        <a href="{{URL::to('/admin/users/permissions')}}">Painel de permissões</a>
                                    </li>
                                @endpermission  

                            </ul>
                        </li>

                    @endpermission
                </ul>
            </li>

        @endpermission

    </ul>
</nav>


<script>
function handleCollapse(event, targetId) {
    event.preventDefault();
    const target = document.querySelector(`#${targetId}`);
    const caret = event.target.querySelector('.caret');

    caret.classList.remove('fa-caret-right');

    if (target.getAttribute('data-collapse') === 'false') {
        target.setAttribute('data-collapse', 'true')
        target.classList.add('collapsed');
        caret.classList.add('fa-caret-down');
    } else {
        target.setAttribute('data-collapse', 'false')
        target.classList.remove('collapsed');
        caret.classList.add('fa-caret-right');
    }
}
</script>
