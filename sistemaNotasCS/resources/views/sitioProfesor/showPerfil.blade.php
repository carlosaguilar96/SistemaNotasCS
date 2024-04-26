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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/imask"></script>

</head>

<body>
    @include('sitioProfesor.navbar')
    <div class="container" style="width:100%; margin-top:90pt">
        <div class="row text-center">
            <div class="col-12">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Perfil de Profesor</p>
            </div>
            <div class="container py-3">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img src="{{asset('img/fotosP/'.$user[0]->foto)}}" style="height: 200px; width:200px" class="img-fluid rounded-start my-4" alt="Foto del administrador">
                                <h5 class="my-3">{{$user[0]->carnet}}</h5>
                                <p class="text-muted mb-1"><b>Profesor</b></p>
                                <p class="text-muted mb-4">Colegio Salarrue</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nombre</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$user[0]->nombres.' '.$user[0]->apellidos}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Correo</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"> {{$user[0]->correo}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">DUI</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$user[0]->DUI}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Carnet</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$user[0]->carnet}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Sección</p>
                                    </div>
                                    @if(empty($seccionEncargado[0]))
                                    <div class="col-sm-9">
                                        <b><p class="text-muted mb-0">Sin sección asignada</p></b>
                                    </div>
                                    @else
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$seccionEncargado[0]->nombreSeccion}}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 mb-md-0">
                                    <div class="card-body">
                                        <b>
                                            <p class="mb-4"><span class="text-danger font-italic me-1">Materias</span> Asignadas
                                            </p>
                                        </b>
                                        <ul class="list-group list-group-flush rounded-3">
                                            @if(empty($materias[0]))
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <i class="fa-solid fa-xmark fa-lg text-danger"></i>
                                                <p class="mb-0">Sin materias asignadas</p>
                                            </li>
                                            @else
                                            @foreach ($materias as $mate)
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <i class="fa-solid fa-book-bookmark fa-lg text-danger"></i>
                                                <p class="mb-0">{{$mate->nombreMateria}}</p>
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4 mb-md-0">
                                    <div class="card-body">
                                        <b>
                                            <p class="mb-4"><span class="text-danger font-italic me-1">Grupos</span> Asignados
                                            </p>
                                        </b>
                                        <ul class="list-group list-group-flush rounded-3">
                                            @if(empty($grupos[0]))
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <i class="fa-solid fa-xmark fa-lg text-danger"></i>
                                                <p class="mb-0">Sin grupos asignados</p>
                                            </li>
                                            @else
                                            @foreach ($grupos as $group)
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <i class="fa-solid fa-people-group fa-lg text-danger"></i>
                                                <p class="mb-0">{{$group->nombreSeccion}}</p>
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="divFooter" style="margin-top: 40pt">
        <nav id="navFooter" class="navbar navbar-expand-lg border-bottom border-body pt-4">
            <div class="container-fluid mx-auto d-block">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-2 mt-4"><img class="img mx-auto d-block" width="175" src="http://127.0.0.1:8000/img/logo.png" alt=""></div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <p><span id="titulo">Redes sociales:</span><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Facebook</a><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Instagram</a><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Twitter</a></p>
                    </div>
                    <div class="col-xl-5 col-sm-6 mt-4">
                        <p><span id="titulo">Horarios de atención:</span><br><br>Lunes a viernes: 7:00-11:50 - 13:15-17:50<br><br>Dirección: Barrio Mejicano, avenida Morazán, #7-17, Sonsonate, El Salvador<br><br>Teléfonos: 2429-7500, 2429-7502</p>
                    </div>
                    <div class="col-12 text-center" style="font-style: italic">
                        <p><br>Copyright ©2024 Colegio Salarrué, All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>