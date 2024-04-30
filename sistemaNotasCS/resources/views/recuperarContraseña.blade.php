@include('header')
<div class="row d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <div>
                    <p class="fs-3 text-center p-2 mt-2">
                        Olvidé mi contraseña
                    </p>
                </div>

                <div class="my-4" style="background-color:black; height: 1px; border-radius: 2rem"></div>
                @if ($errors->any())
                <div class="alert alert-danger my-2 pb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('errorRecuperarContra'))
                <script>
                    Swal.fire({
                        title: "Recuperar contraseña",
                        text: "{{ session('errorRecuperarContra') }}",
                        icon: "error",
                        button: "OK",
                        confirmButtonColor: "#B84C4C",
                    });
                </script>
                @endif
                <form method="POST" action="{{route('cambioContraseña',$id)}}">
                    @csrf
                    @Method('PUT')
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                        <input type="password" class="form-control" placeholder="Contraseña" aria-label="user" name="contraseñaNueva">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                        <input type="password" class="form-control" placeholder="Confirmar contraseña" aria-label="user1" name="contraseñaNueva_confirmation">
                    </div>
                    <div class="row">
                        <button class="btn btn-warning mt-2 mx-auto d-block " style="width:50%;" type="submit">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('footer')