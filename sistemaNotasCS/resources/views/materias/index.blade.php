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
        <script src="{{asset('js/materia/showModals.js')}}"></script>

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
        @include('sitioAdmin.navbar')
        <div class="container" style="width:100%; margin-top:100pt">
            @if (session('errorAgregarMateria'))
            <script>
                Swal.fire({
                    title: "Materia no agregada",
                    text: "{{ session('errorAgregarMateria') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoAgregarMateria'))
            <script>
                Swal.fire({
                    title: "Materia agregada",
                    text: "{{ session('exitoAgregarMateria') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorModificarMateria'))
            <script>
                Swal.fire({
                    title: "Materia no modificada",
                    text: "{{ session('errorModificarMateria') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoModificarMateria'))
            <script>
                Swal.fire({
                    title: "Materia modificada",
                    text: "{{ session('exitoModificarMateria') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorEliminarMateria'))
            <script>
                Swal.fire({
                    title: "Materia no eliminada",
                    text: "{{ session('errorEliminarMateria') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoEliminarMateria'))
            <script>
                Swal.fire({
                    title: "Materia eliminada",
                    text: "{{ session('exitoEliminarMateria') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('errorRestoreMateria'))
            <script>
                Swal.fire({
                    title: "Materia no reactivada",
                    text: "{{ session('errorRestoreMateria') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            @if (session('exitoRestoreMateria'))
            <script>
                Swal.fire({
                    title: "Materia reactivada",
                    text: "{{ session('exitoRestoreMateria') }}",
                    icon: "success",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            <div class="row text-center">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Gestión de materias</p>
                <p class="text-center" style="font-size:12pt; color:black">Listado de materias impartidas por la institución, con opciones de agregar, editar y eliminar materia</p>
                <div class="col-12">
                    <div class="card mb-3 text-center" style="max-width: 100%;">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <ul class="nav nav-tabs card-header-tabs" id="myTab">
                                    <li class="nav-item mb-2">
                                        <a href="#activos" class="nav-link active link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Materias</a>
                                    </li>
                                    <li class="nav-item mb-2">
                                        <a href="#inactivos" class="nav-link link-body-emphasis link-underline link-underline-opacity-0" data-bs-toggle="tab">Materias eliminadas</a>
                                    </li>
                                </ul>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="activos">
                                    <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Materias</p>
                                    <table class="table table-bordered data-table" style="width:100%">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th scope="col">Materia</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($materias as $materia)
                                            <tr>
                                                <td>{{$materia->nombreMateria}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-6 mx-0 px-0">
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-primary icon-button"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="bottom" 
                                                                data-bs-title="Editar"
                                                                onclick="updateMateria({{$materia->idMateria}})">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </div>	
                                                        <div class="col-6 mx-0 px-0">
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-danger icon-button"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="bottom" 
                                                                data-bs-title="Eliminar"
                                                                onclick="eliminarMateria({{$materia->idMateria}})">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>	
                                                    </div>		
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-warning my-3" onclick="agregarMateria()" style="width:auto">Agregar Materia</button>
                                </div>
                                <div class="tab-pane fade" id="inactivos">
                                    <p class="card-title text-center" style="font-size:14pt; font-weight:bold; color:black">Materias Eliminadas</p>
                                    <table class="table table-bordered data-table" style="width:100%">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th scope="col">Materia</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($materiasEliminadas as $materia)
                                            <tr>
                                                <td>{{$materia->nombreMateria}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-12 mx-0 px-0">
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-success icon-button"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="bottom" 
                                                                data-bs-title="Reactivar"
                                                                onclick="restoreMateria({{$materia->idMateria}})">
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
        <!-- Modal para agregar materia -->
        <div class="modal fade" id="agregarMateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar materia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.storeMateria')}}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label for="materia" class="form-label">Nombre</label>
                                    <input  class="form-control" type="text" name="materia" id="materia" placeholder="Ingrese el nombre de la materia">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-warning" type="submit">Agregar Materia</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal para actualizar materia -->
        <div class="modal fade" id="updateMateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar materia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.updateMateria')}}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4" hidden>
                                    <label for="idU" class="form-label">id</label>
                                    <input  class="form-control" type="text" name="idU" id="idU" placeholder="Ingrese el id">
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label for="nombreU" class="form-label">Nombre</label>
                                    <input  class="form-control" type="text" name="nombreU" id="nombreU" placeholder="Ingrese el nombre de la materia">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-warning" type="submit">Actualizar Materia</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal para eliminar materia -->
        <div class="modal fade" id="eliminarMateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar materia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.deleteMateria')}}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p id="textoConfirmarEliminar"></p>
                            <div class="row">
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="idE" class="form-label">id materia</label>
                                    <input type="text" class="form-control" name="idE" id="idE" placeholder="id materia eliminar">
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
        <!-- Modal para reactivar materia -->
        <div class="modal fade" id="reactivarMateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reactivar materia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{route('admin.restoreMateria')}}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <p id="textoConfirmarReactivar"></p>
                            <div class="row">
                                <div class="col-lg-6 mb-4" hidden>
                                    <label for="idR" class="form-label">id materia</label>
                                    <input type="text" class="form-control" name="idR" id="idR" placeholder="id materia eliminar">
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