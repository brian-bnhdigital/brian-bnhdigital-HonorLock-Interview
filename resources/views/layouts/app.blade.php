<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon.png')}}">
    <title>{{ $title }}</title>
    @stack('css')
</head>
<body class="fix-header">
<!-- ===== Main-Wrapper ===== -->
@yield('content')

<!-- ===== Main-Wrapper-End ===== -->
<!-- ==============================
    Required JS Files
=============================== -->
@stack('js')
</body>

</html>