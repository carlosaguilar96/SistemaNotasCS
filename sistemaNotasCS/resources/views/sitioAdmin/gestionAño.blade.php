<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

        <title>Colegio Salarrué</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('fa/css/all.css')}}" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="{{asset('js/gestionAño/showModals.js')}}"></script>

    </head>
    <body>
        @include('sitioAdmin.navbar')
        <div class="container" style="width:100%; margin-top:100pt">
            @if (session('AñoIniciado'))
            <script>
                Swal.fire({
                    title: "Año Iniciado",
                    text: "{{ session('AñoIniciado') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C",
                });
            </script>
            @endif
            @if (session('PeriodoFinalizado'))
            <script>
                Swal.fire({
                    title: "Periodo finalizado",
                    text: "{{ session('PeriodoFinalizado') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C",
                });
            </script>
            @endif
            @if (session('PeriodoNoFinalizado'))
            <script>
                Swal.fire({
                    title: "Periodo no finalizado",
                    text: "{{ session('PeriodoNoFinalizado') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C",
                });
            </script>
            @endif
<div class="row text-center">
    <div class="col-12">
        <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Gestión de año escolar</p>
        <p class="text-center" style="font-size:12pt; color:black">Opciones para la gestión de secciones, años y periodos</p>
    </div>
</div>
@if(count($año)!=0)
<div class="row text-center" style="align-items: center;display: flex;justify-content: center;">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Año</h6>
            <div class="card-body">
                <p class="card-text" style="font-size:15pt"><b>{{$año[0]->nombreAño}}</b></p>
                <p class="card-text" style="font-size:15pt"><b>{{$periodo[0]->nombrePeriodo}}</b></p>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row text-center" style="align-items: center;display: flex;justify-content: center;">
    @if(count($año)==0)
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" type="button" data-bs-toggle="modal" data-bs-target="#iniciarAño">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Iniciar año</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-calendar-plus"></i></p>
                </div>
            </div>
        </a>
    </div>
    @else
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.indexSecciones',$año[0]->idAño)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión de secciones</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-people-line"></i></p>
                </div>
            </div>
        </a>
    </div>
    @if(count($periodo)!=0)
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Finalizar periodo</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-calendar-week"></i></p>
                </div>
            </div>
        </a>
    </div>
    @endif
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Finalizar año</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-calendar-check"></i></p>
                </div>
            </div>
        </a>
    </div>
    @endif
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Historial</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-table-list"></i></p>
                </div>
            </div>
        </a>
    </div>
</div>
</div>
<!-- Modal para iniciar año -->
<div class="modal fade" id="iniciarAño" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Iniciar Año</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('admin.iniciarAño')}}">
                @csrf
                <div class="modal-body">
                    <p id="textoConfirmarEliminar">¿Está seguro que desea iniciar un nuevo año escolar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                    <button class="btn btn-warning" type="submit">Iniciar</button>
                  </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal para terminar periodo -->
<div class="modal fade" id="terminarPeriodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Terminar Periodo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('admin.deleteEstudiante')}}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p id="textoConfirmarEliminar"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                    <button class="btn btn-danger" type="submit">Terminar</button>
                  </div>
            </form>
        </div>
    </div>
</div>
<div id="divFooter" style="margin-top: 40pt">
    <nav id="navFooter" class="navbar navbar-expand-lg border-bottom border-body pt-4" >         
        <div class="container-fluid mx-auto d-block">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-2 mt-4"><img class="img mx-auto d-block" width="175" src="http://127.0.0.1:8000/img/logo.png" alt=""></div>
                <div class="col-xl-2 col-sm-6 mt-4"><p><span id="titulo">Redes sociales:</span><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Facebook</a><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Instagram</a><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Twitter</a></p></div>
                <div class="col-xl-5 col-sm-6 mt-4"><p><span id="titulo">Horarios de atención:</span><br><br>Lunes a viernes: 7:00-11:50 - 13:15-17:50<br><br>Dirección: Barrio Mejicano, avenida Morazán, #7-17, Sonsonate, El Salvador<br><br>Teléfonos: 2429-7500, 2429-7502</p></div>
                <div class="col-12 text-center" style="font-style: italic"><p><br>Copyright ©2024 Colegio Salarrué, All Rights Reserved.</p></div>
            </div>
        </div>                
    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>