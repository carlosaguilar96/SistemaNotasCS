<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

        <title>Colegio Salarrué</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/e359753675.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body>
        @include('sitioProfesor.navbar')
        <div class="container" style="width:100%; margin-top:100pt">
            <div class="row text-center">
                <div class="col-12">
                    <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">{{$grupo[0]->nombreMateria}} - {{$grupo[0]->nombreSeccion}}</p>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Año</h5>
                            <h3><b>{{$año[0]->nombreAño}}</b></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Periodo</h5>
                            <h3><b>{{$periodo[0]->nombrePeriodo}}</b></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Total Estudiantes</h5>
                            <h3><b>{{$totalEstudiantes}}</b></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Masculinos</h5>
                            <h3><b>{{$totalEstudiantesM}}</b></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Femeninos</h5>
                            <h3><b>{{$totalEstudiantesF}}</b></h3>
                        </div>
                    </div>
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