<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('files/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('files/css/admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('files/css/config.css') }}" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    {{-- JS --}}
    <script src="{{ asset('files/js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files/js/mask.min.js') }}"></script>
    {{-- <script src="{{ asset('files/js/popper.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('files/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('files/js/bootstrap.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('files/js/index.js') }}"></script>
    <script src="{{ asset('files/js/notification.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const ntc = new notification();
    </script>

</head>
