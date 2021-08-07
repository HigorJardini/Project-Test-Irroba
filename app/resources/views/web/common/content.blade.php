<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    @include('web.common.header')

<body>

    @auth
        @include('web.common.navbar')
    @endauth

    <div class="d-flex">
        @auth
            @include('web.common.sidebar')
        @endauth

        <section class="container-fluid" id="@yield('page')">
            @yield('content')
            <div style="height: 12px;"></div>
        </section>
    </div>
</body>
</html>
