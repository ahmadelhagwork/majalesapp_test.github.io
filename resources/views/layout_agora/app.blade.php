<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Audio Mixing & Audio Effect -- Agora</title>
    <link rel="stylesheet" href="{{ asset('public/agora/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/agora/css/index.css') }}">
    @yield('style')
</head>

<body>
    @yield('content')

    <script src="{{ asset('public/agora/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/agora/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    @yield('script')
</body>

</html>
