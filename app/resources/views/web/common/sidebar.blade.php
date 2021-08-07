<nav id="sidebar-admin">

    <div class="header">
        <i class="fas fa-bars"></i>
        <span>NAVEGAÇÃO</span>
    </div>

    <ul class="menu-content">

        <li>
            <a href="">
                <i class="fas fa-home"></i>
                Home
            </a>
        </li>

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
