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
        <script src="{{asset('js/estudiante/showModals.js')}}"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://unpkg.com/imask"></script>
        <script src="{{ asset('js/estudiante/validarFormCrear.js') }}"></script>

    </head>
    <body>
        @include('sitioAdmin.navbar')
        <div class="container" style="width:100%; margin-top:100pt">
            @if (session('exitoModificar'))
            <script>
                Swal.fire({
                    title: "Actualización exitosa",
                    text: "{{ session('exitoModificar') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorModificar'))
            <script>
                Swal.fire({
                    title: "Actualización no exitosa",
                    text: "{{ session('errorModificar') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoModificarFoto'))
            <script>
                Swal.fire({
                    title: "Actualización exitosa",
                    text: "{{ session('exitoModificarFoto') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorModificarFoto'))
            <script>
                Swal.fire({
                    title: "Actualización no exitosa",
                    text: "{{ session('errorModificarFoto') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            <div class="row text-center">
                <div class="col-12">
                    <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Perfil de estudiante</p>
                </div>
                <div class="col-12">
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-4" style="align-items: center;display: flex;justify-content: center;">
                                <img src="{{asset('img/fotosE/'.$estudiante[0]->foto)}}" style="height: 200px; width:200px"  class="img-fluid rounded-start" alt="Foto del estudiante">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><b>{{$estudiante[0]->nombres.' '.$estudiante[0]->apellidos}}</b></h5>
                                    <p class="card-text"><b>{{$estudiante[0]->carnet}}</b></p>
                                    <div class="row">
                                        <div class="col-lg-6 mb-2">
                                            <p class="card-text text-start">
                                                <b>NIE:</b> {{$estudiante[0]->NIE}}
                                            </p>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <p class="card-text text-start">
                                                <b>Fecha de nacimiento:</b> {{  date('d-m-Y',strtotime($estudiante[0]->fechaNacimiento))  }}
                                            </p>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <p class="card-text text-start">
                                                <b>Correo:</b> {{$estudiante[0]->correo}}
                                            </p>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <p class="card-text text-start">
                                                <b>Sexo:</b> 
                                                    @if ($estudiante[0]->sexo == 1)
                                                        Masculino
                                                    @else
                                                        Femenino
                                                    @endif
                                            </p>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <p class="card-text text-start">
                                                <b>Grado:</b> {{$grado}}
                                            </p>
                                        </div>
                                        @if($estudiante[0]->estadoeliminacion==1)
                                        <div class="col-sm-6 col-12 mb-2">
                                            <button type="button" class="btn btn-warning" onclick="actualizarDatosModal({{$estudiante[0]->NIE}})" style="width:75%">Actualizar información</button>
                                        </div>
                                        <div class="col-sm-6 col-12 mb-2">
                                            <button type="button" class="btn btn-warning" onclick="actualizarFotoModal({{$estudiante[0]->NIE}})" style="width:75%">Actualizar foto de perfil</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <!-- Modal para actualizar información de estudiante -->
        <div class="modal fade" id="modalDatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar información de estudiante</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.updateEstudiante')}}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="nie" class="form-label">NIE</label>
                                    <input type="text" class="form-control" name="nie" id="nie" placeholder="Número de identificación del estudiante" value="{{ old('nie') }}">
                                </div>
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="carnet" class="form-label">Carnet</label>
                                    <input type="text" class="form-control" name="carnet" id="carnet" placeholder="Carnet del estudiante" value="{{ old('carnet') }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del estudiante" value="{{ old('nombre') }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="apellido" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos del estudiante" value="{{ old('apellido') }}">
                                </div> 
                                <div class="col-lg-6 mb-4">
                                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                                    <input type="text" class="form-control" id="fechaNacimiento" name="fechaNacimiento" placeholder="Seleccionar fecha de nacimiento" value="{{ old('fechaNacimiento') }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <select class="form-select" aria-label="Default select example" id="sexo" name="sexo" value="{{ old('sexo') }}">
                                        <option value="0">Seleccionar sexo</option>
                                        <option value="1">Masculino</option>
                                        <option value="2">Femenino</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="correo" class="form-label">Correo</label>
                                    <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo del estudiante" value="{{ old('correo') }}">
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-warning" type="submit">Actualizar Datos</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal para actualizar foto de estudiante -->
        <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar foto de perfil</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.updateEstudianteFoto')}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="id" class="form-label">NIE</label>
                                    <input type="text" class="form-control" name="id" id="id" placeholder="Número de identificación del estudiante" value="{{ old('nie') }}">
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="foto" name="foto">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                            <button class="btn btn-warning" type="submit">Actualizar foto</button>
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