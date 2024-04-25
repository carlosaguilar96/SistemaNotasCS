<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

        <title>Colegio Salarrué</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://unpkg.com/imask"></script>
        <script src="{{ asset('js/estudiante/validarFormCrear.js') }}"></script>
        <script src="https://kit.fontawesome.com/e359753675.js" crossorigin="anonymous"></script>

    </head>
    <body>
        @include('sitioAdmin.navbar')
        <div class="container" style="width:100%; margin-top:100pt;">
            @if (session('errorAgregarEstudiante'))
            <script>
                Swal.fire({
                    title: "Estudiante no agregado",
                    text: "{{ session('errorAgregarEstudiante') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
    <div class="row">
        <div class="col-12">
            <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Nuevo estudiante</p>
            <p class="text-center" style="font-size:12pt; color:black">Ingresar la información solicitada en el formulario para agregar un nuevo estudiante</p>
        </div>
        <div class="col-12">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                    @if ($errors->any())
						<div class="alert alert-danger my-2 pb-0">
							<ul style="list-style-position: inside;">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    <form method="POST" action="{{route('admin.guardarEstudiante')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="nie" class="form-label">NIE</label>
                                <input type="text" class="form-control" name="nie" id="nie" placeholder="Número de identificación del estudiante" value="{{ old('nie') }}">
                            </div>
                            <div class="col-lg-6 mb-4">
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
                            <div class="col-lg-6 mb-4">
                                <label for="grado" class="form-label">Grado académico</label>
                                <select class="form-select" aria-label="Default select example" id="grado" name="grado" value="{{ old('grado') }}">
                                    <option value="0">Seleccionar grado académico a cursar</option>
                                    @foreach ($grados as $grado)
                                        @if ($grado->idEtapa == 1)
                                            <option value="{{$grado->idGrado}}">{{$grado->nombreGrado}}</option>
                                        @else
                                            <option value="{{$grado->idGrado}}">{{$grado->nombreGrado}} de {{$grado->nombreEtapa}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="foto" class="form-label">Foto</label>
                                <input class="form-control" type="file" id="foto" name="foto">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning mt-2 mx-auto d-block " style="width:auto;" type="submit">Agregar Estudiante</button>
                            </div>                             
                        </div>									
                    </form>
                </div>
            </div>
        </div>
    </div>    
@include('sitioAdmin.footer')