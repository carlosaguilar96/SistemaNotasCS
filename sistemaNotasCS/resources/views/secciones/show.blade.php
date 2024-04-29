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
                pagingType: 'simple_numbers',
                paging:false,
            });
        });
    </script>
    @include('sitioAdmin.navbar')
    <div class="container" style="width:100%; margin-top:100pt;">
            @if (session('errorAgregar'))
            <script>
                Swal.fire({
                    title: "Estudiantes no agregados",
                    text: "{{ session('errorAgregar') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoAgregar'))
            <script>
                Swal.fire({
                    title: "Estudiantes agregados",
                    text: "{{ session('exitoAgregar') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorAsignar'))
            <script>
                Swal.fire({
                    title: "Profesor no asignado",
                    text: "{{ session('errorAsignar') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoAsignar'))
            <script>
                Swal.fire({
                    title: "Profesor asignado",
                    text: "{{ session('exitoAsignar') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
        <div class="row">
            <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">{{$seccion[0]->nombreSeccion}} {{$seccion[0]->nombreAño}}</p>
            <p class="text-center" style="font-size:12pt; color:black">Encargado: {{$seccion[0]->nombres}} {{$seccion[0]->apellidos}}</p>
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab">
                                <li class="nav-item mb-2">
                                    <a href="#activos" class="nav-link active link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Estudiantes</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#inactivos" class="nav-link link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Profesores</a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="activos">
                                <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Estudiantes</p>
                                <table class="table table-bordered data-table" style="width:100%">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col">#</th>
                                            <th scope="col">Carnet</th>
                                            <th scope="col">Apellidos, Nombres</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1 ?>
                                        @foreach ($estudiantes as $estudiante)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$estudiante->carnet}}</td>
                                            <td>{{$estudiante->apellidos.', '.$estudiante->nombres}}</td>
                                        </tr>
                                        <?php $i++ ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if(count($estudiantes)==0)<button type="button" class="btn btn-warning my-3" onclick="agregarEstudiantes()" style="width:auto">Agregar Estudiantes</button>@endif
                            </div>
                            <div class="tab-pane fade" id="inactivos">
                                <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Profesores</p>
                                <table class="table table-bordered data-table" style="width:100%">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col">Materia</th>
                                            <th scope="col">Profesor</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($profesores as $profesor)
                                        <tr>
                                            <td>{{$profesor->nombreMateria}}</td>
                                            <td>@if($profesor->idProfesor==NULL)No asignado @endif</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-12 mx-0 px-0">
                                                        <a type="button" class="btn btn-warning icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Agregar profesor" onclick="asignarProfesor({{$profesor->idDetalle}})"><i class="fa-solid fa-user-plus my-1" style="color: white"></i></a>
                                                    </div>
                                                </div>		
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach ($profesores2 as $profesor)
                                        <tr>
                                            <td>{{$profesor->nombreMateria}}</td>
                                            <td>{{$profesor->nombres}} {{$profesor->apellidos}}</td>
                                            <td>Sin opciones	
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para agregar estudiantes -->
    <div class="modal fade" id="agregarEstudiantes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar estudiantes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('admin.addEstudiantes')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-4" hidden>
                                <label for="año" class="form-label">Año</label>
                                <input  class="form-control" type="text" name="seccion" id="año" placeholder="Ingrese el año" value="{{$id}}">
                            </div>
                            @if(count($estudiantesDisponibles)==0)
                            <label class="form-label">No hay estudiantes para agregar</label>
                            @else
                            @foreach ($estudiantesDisponibles as $estudiante)
                                <div class="col-12 text-start" style="text-align: center; display: flex;justify-content: center;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="estudiantes[]" value="{{$estudiante->NIE}}" id="cb{{$estudiante->carnet}}">
                                        <label class="form-check-label" for="cb{{$estudiante->carnet}}">
                                            {{$estudiante->apellidos}}, {{$estudiante->nombres}}
                                        </label>
                                    </div>                                                  
                                </div>
                            @endforeach
                            @endif  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-warning" type="submit">Agregar Estudiantes</button>
                      </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal para asignar profesor -->
    <div class="modal fade" id="asignarProfesor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar Profesor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('admin.asignarProfesor')}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-4" hidden>
                                <label for="año" class="form-label">Año</label>
                                <input  class="form-control" type="text" name="seccion2" id="año2" placeholder="Ingrese el año" value="{{$id}}">
                            </div>
                            <div class="col-lg-12 mb-4" hidden>
                                <label for="año" class="form-label">Año</label>
                                <input  class="form-control" type="text" name="detalle" id="año" placeholder="Ingrese el año">
                            </div>
                            <div class="col-lg-12 mb-4" id="selectdiv">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-warning" type="submit">Asignar profesor</button>
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