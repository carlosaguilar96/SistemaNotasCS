<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="http://127.0.0.1:8000/img/logo.png" type="image/x-icon">

        <title>Colegio Salarrué</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://unpkg.com/imask"></script>
        <script src="{{ asset('js/profesor/validarFormCrear.js') }}"></script>

    </head>
    <body>
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
            @if (session('errorAgregarAdministrador'))
            <script>
                Swal.fire({
                    title: "Administrador no agregado",
                    text: "{{ session('errorAgregarAdministrador') }}",
                    icon: "error",
                    button: "OK",
                    confirmButtonColor: "#B84C4C", 
                });       
            </script>
            @endif
            <div class="row">
                <div class="col-12">
                    <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Nuevo Administrador</p>
                    <p class="text-center" style="font-size:12pt; color:black">Ingresar la información solicitada en el formulario para agregar un nuevo administrador</p>
                </div>
                <div class="col-12">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">																		
								@if ($errors->any())
									<div class="alert alert-danger my-2 pb-0">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								<form method="POST" action="{{route('admin.guardarAdmin')}}" enctype="multipart/form-data">
									@csrf
                                    <div class="row">
                                        
                                            <div class="col-lg-6 mb-3">
                                                <label for="dui" class="form-label">DUI</label>
                                                <input type="text" class="form-control" name="dui" id="dui" placeholder="Documento único de identidad del profesor" value="{{ old('dui') }}">
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label for="carnet" class="form-label">Carnet</label>
                                                <input type="text" class="form-control" name="carnet" id="carnet" placeholder="Carnet del profesor" value="{{ old('carnet') }}">
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del profesor" value="{{ old('nombre') }}">
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label for="apellido" class="form-label">Apellidos</label>
                                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos del profesor" value="{{ old('apellido') }}">
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label for="correo" class="form-label">Correo</label>
                                                <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo del profesor" value="{{ old('correo') }}">
                                            </div>
                                            <div class="col-lg-6 mb-4">
                                                <label for="foto" class="form-label">Foto</label>
                                                <input class="form-control" type="file" id="foto" name="foto">
                                            </div>
                                        
                                        <div class="col-12 mt-lg-0 mt-4">
                                            <button class="btn btn-warning mt-2 mx-auto d-block " style="width:auto;" type="submit">Agregar Administrador</button>
                                        </div>                        
                                    </div>										
								</form>		
						</div>										
					</div>
				</div>
            </div>
        </div>
@include('sitioAdmin.footer')