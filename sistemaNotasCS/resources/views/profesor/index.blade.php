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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

        <script src="{{asset('js/estudiante/showModals.js')}}"></script>
    </head>
    <body>
        <script>
            $(document).ready( function () {
                $('.data-table').DataTable({
                    language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json'
                    },
                    pagingType: 'simple_numbers'
                });
            } );
        </script>
        <div id="divHeader">
            <nav id="navHeader" class="navbar navbar-expand-lg border-bottom border-body">         
                <div class="container-fluid" style="height:50pt;">
                    <a class="navbar-brand" href="{{route('admin.inicio')}}">
                        <img class="img mt-lg-0 mb-2" width="50" src="http://127.0.0.1:8000/img/logo.png" alt="">
                        <p class="mt-lg-2">Colegio Salarrué</p>
                    </a>
                </div>                
            </nav>
        </div>
        <div class="container" style="width:100%; margin-top:100pt;">
            @if (session('exitoEliminacion'))
            <script>
                Swal.fire({
                    title: "Profesor eliminado",
                    text: "{{ session('exitoEliminacion') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorEliminacion'))
            <script>
                Swal.fire({
                    title: "Profesor no eliminado",
                    text: "{{ session('errorEliminacion') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoReactivar'))
            <script>
                Swal.fire({
                    title: "Profesor reactivado",
                    text: "{{ session('exitoReactivar') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorReactivar'))
            <script>
                Swal.fire({
                    title: "Profesor no reactivado",
                    text: "{{ session('errorReactivar') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            <div class="row">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Gestión de profesores</p>
                <p class="text-center" style="font-size:12pt; color:black">Listado de profesores activos e inactivos con opciones para ver información y eliminar o reactivar profesor</p>
                <div class="col-12">
                    <div class="card text-center">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <ul class="nav nav-tabs card-header-tabs" id="myTab">
                                    <li class="nav-item mb-2">
                                        <a href="#activos" class="nav-link active link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Profesores Activos</a>
                                    </li>
                                    <li class="nav-item mb-2">
                                        <a href="#inactivos" class="nav-link link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Profesores Inactivos</a>
                                    </li>
                                </ul>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="activos">
                                    <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Profesores activos</p>
                                    <table class="table table-bordered data-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Apellidos, Nombres</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profesoresActivos as $profesor)
                                            <tr>
                                                <td>{{$profesor->carnet}}</td>
                                                <td>{{$profesor->apellidos.', '.$profesor->nombres}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-6 mx-0 px-0">
                                                            <a type="button" class="btn btn-primary icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ver información" href="{{route('admin.showProfesor',$profesor->DUI)}}"><i class="fa-solid fa-eye my-1" style="color: white"></i></a>
                                                        </div>
                                                        <div class="col-6 mx-0 px-0">
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-danger icon-button"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="bottom" 
                                                                data-bs-title="Eliminar"
                                                                onclick="">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>	
                                                    </div>		
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="inactivos">
                                    <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Estudiantes inactivos</p>
                                    <table class="table table-bordered data-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Apellidos, Nombres</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profesoresInactivos as $profesor)
                                            <tr>
                                                <td>{{$profesor->carnet}}</td>
                                                <td>{{$profesor->apellidos.', '.$profesor->nombres}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-6 mx-0 px-0">
                                                            <a type="button" class="btn btn-primary icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ver información" href="{{route('admin.showProfesor', $profesor->DUI)}}"><i class="fa-solid fa-eye my-1" style="color: white"></i></a>
                                                        </div>
                                                        <div class="col-6 mx-0 px-0">
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-success icon-button"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="bottom" 
                                                                data-bs-title="Reactivar"
                                                                onclick="">
                                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                            </button>
                                                        </div>	
                                                    </div>		
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
        <!-- Modal para eliminar estudiante -->
        <div class="modal fade" id="eliminarEstudiante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar profesor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.deleteEstudiante')}}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p id="textoConfirmarEliminar"></p>
                            <div class="row">
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="id" class="form-label">DUI</label>
                                    <input type="text" class="form-control" name="id" id="id" placeholder="Número de identificación del profesor" value="{{ old('nie') }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                            <button class="btn btn-danger" type="submit">Eliminar</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal para reactivar estudiante -->
        <div class="modal fade" id="reactivarEstudiante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reactivar profesor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.restoreEstudiante')}}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <p id="textoConfirmarReactivar"></p>
                            <div class="row">
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="idR" class="form-label">DUI</label>
                                    <input type="text" class="form-control" name="idR" id="idR" placeholder="Número de identificación del profesor" value="{{ old('nie') }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                            <button class="btn btn-success" type="submit">Reactivar</button>
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
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))            
        </script>
    </body>
</html>