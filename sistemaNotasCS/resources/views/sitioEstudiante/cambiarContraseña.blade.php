@include('sitioEstudiante.header')
<div class="row d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <h4 class="card-title mb-4" style="font-weight: bold">Cambiar contraseña de estudiante</h4>
                @if ($errors->any())
                <div class="alert alert-danger my-2 pb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('repetirContra'))
                <div class="alert alert-danger my-2 pb-0">
                    {{session('repetirContra')}}
                </div>
                @endif
                @if (session('errorCambiar'))
                <script>
                    Swal.fire({
                        title: "Error al cambiar contraseña",
                        text: "{{ session('errorCambiar') }}",
                        icon: "error",
                        button: "OK",
                        confirmButtonColor: "#B84C4C",
                    });
                </script>
                @endif
                @if (session('exitoCambiar'))
                <script>
                    Swal.fire({
                        title: "Contraseña cambiada",
                        text: "{{ session('exitoCambiar') }}",
                        icon: "success",
                        button: "OK",
                        confirmButtonColor: "#B84C4C",
                    });
                </script>
                @endif
                <form method="POST" action="{{route('estudiante.cambiarContraseñaEstudiante')}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-12 mb-3 mt-3">
                            <label for="dui" class="form-label">Contraseña actual</label>
                            <input type="password" class="form-control" name="ContraseñaActual" id="ContraseñaActual" placeholder="Escriba su contraseña actual" value="{{ old('actualPass') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="carnet" class="form-label">Contraseña nueva</label>
                            <input type="password" class="form-control" name="NuevaContraseña" id="NuevaContraseña" placeholder="Escriba su nueva contraseña" value="{{ old('newPass') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nombre" class="form-label">Contraseña nueva</label>
                            <input type="password" class="form-control" id="NuevaContraseña_confirmation" name="NuevaContraseña_confirmation" placeholder="Escriba su nueva contraseña nuevamente" value="{{ old('newPass1') }}">
                        </div>
                        <div class="col-12 mt-lg-0 mt-4">
                            <button class="btn btn-warning mt-2 mx-auto d-block " style="width:auto;" type="submit">Cambiar contraseña</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('footer')