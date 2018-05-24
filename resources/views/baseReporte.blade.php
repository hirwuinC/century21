<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('css/reportes.css')}}">

</head>
<body>
    @yield('contenido')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/materialize.min.js')}}"></script>
    <script src="{{asset('js/reporteDiario.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
</body>
</html>