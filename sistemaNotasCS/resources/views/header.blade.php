<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

        <title>Colegio Salarrué</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
        <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('fa/css/all.css')}}" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/imask"></script>
        <script src="{{ asset('js/profesor/validarFormCrear.js') }}"></script>

    </head>
    <body>
        <div id="divHeader">
            <nav id="navHeader" class="navbar navbar-expand-lg border-bottom border-body">         
                <div class="container-fluid" style="height:50pt;">
                    <a class="navbar-brand" href="{{route('welcome')}}">
                        <img class="img mt-lg-0 mb-2" width="50" src="http://127.0.0.1:8000/img/logo.png" alt="">
                        <p class="mt-lg-2">Colegio Salarrué</p>
                    </a>
                </div>                
            </nav>
        </div>
        <div class="container" style="width:100%; margin-top:100pt">
            @if (session('errorAgregarAdministrador'))
            <script>
                Swal.fire({
                    title: "Primer administrador no agregado",
                    text: "{{ session('errorAgregarAdministrador') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoAgregarAdministrador'))
            <script>
                Swal.fire({
                    title: "Primer administrador registrado",
                    text: "{{ session('exitoAgregarAdministrador') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif