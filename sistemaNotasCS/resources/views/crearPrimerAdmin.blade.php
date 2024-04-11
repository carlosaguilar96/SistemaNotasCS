@include('header')
<div class="row d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <h4 class="card-title mb-4" style="font-weight: bold">Creación de primer administrador</h4>
                @if ($errors->any())
					<div class="alert alert-danger my-2 pb-0">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form method="POST" action="{{route('primerAdmin')}}" enctype="multipart/form-data">
					@csrf
                    <div class="row">
                        
                            <div class="col-12 mb-3 mt-3">
                                <label for="dui" class="form-label">DUI</label>
                                <input type="text" class="form-control" name="dui" id="dui" placeholder="Documento único de identidad del administrador" value="{{ old('dui') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="carnet" class="form-label">Carnet</label>
                                <input type="text" class="form-control" name="carnet" id="carnet" placeholder="Carnet del administrador" value="{{ old('carnet') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del administrador" value="{{ old('nombre') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="apellido" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos del administrador" value="{{ old('apellido') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo del administrador" value="{{ old('correo') }}">
                            </div>
                            <div class="col-12 mb-4">
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
@include('footer')