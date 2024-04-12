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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="{{ asset('js/estudiante/validarFormCrear.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

    <script src="{{asset('js/profesor/showModals.js')}}"></script>

</head>

<body>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                searching: false,
                paging: false,
                info: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json'
                },
                pagingType: 'simple_numbers'
            });
        });
    </script>
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
        @if (session('errorAgregarMateria'))
        <script>
            Swal.fire({
                title: "Error al agregar materia",
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
        @if (session('exitoEliminacion'))
        <script>
            Swal.fire({
                title: "Materia eliminada",
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
                title: "Error al eliminar materia",
                text: "{{ session('errorEliminacion') }}",
                icon: "error",
                button: "OK",
                confirmButtonColor: "#B84C4C",
            });
        </script>
        @endif
        <div class="row text-center">
            <div class="col-12">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Perfil de profesor</p>
            </div>
            <div class="col-12">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="row g-0">
                        <div class="col-md-4" style="align-items: center;display: flex;justify-content: center;">
                            <img src="{{asset('img/fotosP/'.$profesor[0]->foto)}}" style="height: 200px; width:200px" class="img-fluid rounded-start my-4" alt="Foto del profesor">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><b>{{$profesor[0]->nombres.' '.$profesor[0]->apellidos}}</b></h5>
                                <p class="card-text"><b>{{$profesor[0]->carnet}}</b></p>
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <p class="card-text text-start">
                                            <b>DUI:</b> {{$profesor[0]->DUI}}
                                        </p>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <p class="card-text text-start">
                                            <b>Correo:</b> {{$profesor[0]->correo}}
                                        </p>
                                    </div>
                                    @if($profesor[0]->estadoeliminacion==0)
                                    <div class="col-lg-6 mb-2">
                                        <p class="card-text text-start mt-4">
                                            <b><strong>Profesor inactivo</strong></b>
                                        </p>
                                    </div>
                                    @endif
                                    @if($profesor[0]->estadoeliminacion==1)
                                    <div class="col-sm-6 col-12 mb-2">
                                        <button type="button" class="btn btn-warning" onclick="actualizarDatosModal('{{$profesor[0]->DUI}}')" style="width:75%">Actualizar información</button>
                                    </div>
                                    <div class="col-sm-6 col-12 mb-2">
                                        <button type="button" class="btn btn-warning" onclick="actualizarFotoModal('{{$profesor[0]->DUI}}')" style="width:75%">Actualizar foto de perfil</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($profesor[0]->estadoeliminacion==1)
                        <div style="background-color:#CFCBCB; height: 1px; border-radius: 2rem"></div>
                        <div class="col-md-12">
                            <p class="text-center mt-4" style="font-size:16pt; font-weight:bold; color:black">Materias</p>
                            <p class="text-center" style="font-size:12pt; color:black">Listado de materias que imparte el profesor</p>
                            <table class="table table-bordered data-table mb-4" style="width:95%">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col">Nombre Materia</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($informacion as $materias)
                                    <tr>
                                        <td>{{$materias->nombreMateria}}</td>
                                        <td>
                                            <div class="d-grid col-2 mx-auto">
                                                <button type="button" class="btn btn-danger icon-button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Eliminar" onclick="eliminarMateria({{$materias->idDetalle}})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 col-lg-4 col-md-6 col-8 mx-auto">
                            <button type="button" class="btn btn-warning btn-lg mb-4" onclick="agregarMaterias()">
                                <i class="fa-solid fa-square-plus"> Agregar materia</i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para actualizar información de profesor -->
    <div class="modal fade" id="modalDatosProfesor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar información del profesor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('admin.updateProfesor')}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-4" hidden>
                                <label for="nie" class="form-label">DUI</label>
                                <input type="text" class="form-control" name="dui" id="dui" placeholder="Número de identificación del profesor" value="{{ old('dui') }}">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del profesor" value="{{ old('nombre') }}">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="apellido" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos del profesor" value="{{ old('apellido') }}">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo del profesor" value="{{ old('correo') }}">
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
    <!-- Modal para actualizar foto de profesor -->
    <div class="modal fade" id="modalFotoProfesor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar foto de perfil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('admin.updateProfesorFoto')}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-4" hidden>
                                <label for="id" class="form-label">DUI</label>
                                <input type="text" class="form-control" name="id" id="id" placeholder="Número de identificación del profesor" value="{{ old('dui') }}">
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
    <!-- Modal para agregar materias -->
    <div class="modal fade" id="modalAddMateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:5000">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar materia</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('admin.agregarMateria')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-4" hidden>
                                <input type="text" class="form-control" name="idProfesor" id="idProfesor" placeholder="Número de identificación del profesor" value="{{$profesor[0]->DUI}}">
                            </div>
                            <label for="materias" class="form-label">Materias disponibles</label>
                            <select class="form-select" aria-label="Default select example" name="materias" id="materias">
                                <option value="0">Seleccionar materia</option>
                                @foreach($materiasDisponibles as $materia)
                                <option value="{{$materia->idMateria}}">{{$materia->nombreMateria}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                        <button class="btn btn-warning" type="submit">Agregar materia</button>
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
                <form method="POST" action="{{route('admin.deleteMateriaProfesor')}}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p id="textoConfirmarEliminar"></p>
                        <div class="row">
                            <div class="col-lg-6 mb-4" hidden>
                                <label for="id" class="form-label">materia</label>
                                <input type="text" class="form-control" name="dui" id="dui" value="{{$profesor[0]->DUI}}" placeholder="Número de identificación del profesor">
                            </div>
                            <div class="col-lg-6 mb-4" hidden>
                                <label for="id" class="form-label">materia</label>
                                <input type="text" class="form-control" name="id" id="id" placeholder="Número de identificación del profesor">
                            </div>
                            <div class="col-lg-6 mb-4" hidden>
                                <label for="id" class="form-label">detalle</label>
                                <input type="text" class="form-control" name="idA" id="idA" placeholder="Número de identificación del profesor">
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