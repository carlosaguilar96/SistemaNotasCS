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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

    <script src="{{asset('js/secciones/showModals.js')}}"></script>
</head>
<body>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json'
                },
                pagingType: 'simple_numbers'
            });
        });
    </script>
    @include('sitioAdmin.navbar')
    <div class="container" style="width:100%; margin-top:100pt;">
        @if (session('errorSeccion'))
            <script>
                Swal.fire({
                    title: "Seccion no creada",
                    text: "{{ session('errorSeccion') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoSeccion'))
            <script>
                Swal.fire({
                    title: "Sección creada",
                    text: "{{ session('exitoSeccion') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
        <div class="row">
            <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Gestión de secciones</p>
            <p class="text-center" style="font-size:12pt; color:black">Listado de secciones con opciones para crear una nueva sección, agregar estudiantes a la sección</p>
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab">
                                <li class="nav-item mb-2">
                                    <a href="#activos" class="nav-link active link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Secciones</a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="activos">
                                <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Secciones</p>
                                <table class="table table-bordered data-table" style="width:100%">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col">Seccion</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($secciones as $seccion)
                                        <tr>
                                            <td>{{$seccion->nombreSeccion}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-12 mx-0 px-0">
                                                        <a type="button" class="btn btn-primary icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ver información" href="{{route('admin.mostrarSeccion',$seccion->idSeccion)}}"><i class="fa-solid fa-eye my-1" style="color: white"></i></a>
                                                    </div>
                                                </div>		
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-warning my-3" onclick="agregarSeccion()" style="width:auto">Agregar Sección</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para agregar sección -->
    <div class="modal fade" id="agregarSeccion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar sección</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('admin.storeSeccion')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-4" hidden>
                                <label for="año" class="form-label">Año</label>
                                <input  class="form-control" type="text" name="año" id="año" placeholder="Ingrese el año" value="{{$id}}">
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="grado" class="form-label">Grado</label>
                                <select class="form-select" aria-label="Default select example" id="grado" name="grado">
                                    <option value="0">Seleccionar grado</option>
                                    @foreach($grados as $grado)
                                    <option value="{{$grado->idGrado}}">{{$grado->nombreGrado}} @if($grado->idEtapa==2) de {{$grado->nombreEtapa}}  @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input  class="form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre de la sección, por ejemplo Séptimo A">
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="encargado" class="form-label">Profesor encargado</label>
                                <select class="form-select" aria-label="Default select example" id="encargado" name="encargado">
                                    <option value="0">Seleccionar profesor encargado</option>
                                    @foreach($encargados as $encargado)
                                    <option value="{{$encargado->DUI}}">{{$encargado->nombres}} {{$encargado->apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-warning" type="submit">Agregar Sección</button>
                      </div>
                </form>
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
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>