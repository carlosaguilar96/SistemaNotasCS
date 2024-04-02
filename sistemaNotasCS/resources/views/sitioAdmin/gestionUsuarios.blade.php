@include('sitioAdmin.header')
@if (session('exitoAgregarEstudiante'))
    <script>
        Swal.fire({
            title: "Estudiante agregado",
            text: "{{ session('exitoAgregarEstudiante') }}",
            icon: "success",
            button: "OK",
            confirmButtonColor: "#B84C4C",
        });       
    </script>
@endif
    <div class="row text-center">
        <div class="col-12">
            <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Gestión de usuarios</p>
            <p class="text-center" style="font-size:12pt; color:black">Opciones para la gestión de estudiantes, profesores y administradores</p>
          </div>
    </div>
    <div class="row text-center" style="align-items: center;display: flex;justify-content: center;">
      <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.crearEstudiante')}}">
          <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Agregar estudiante</h6>
            <div class="card-body">
              <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-user-plus"></i></p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
          <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Gestión de estudiantes</h6>
            <div class="card-body">
              <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-list"></i></i></p>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="row text-center" style="align-items: center;display: flex;justify-content: center;">
      <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.crearProfesor')}}">
          <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Agregar profesor</h6>
            <div class="card-body">
              <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-user-plus"></i></p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
          <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Gestión de profesores</h6>
            <div class="card-body">
              <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-list"></i></i></p>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="row text-center" style="align-items: center;display: flex;justify-content: center;">
      <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
          <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Agregar administrador</h6>
            <div class="card-body">
              <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-user-plus"></i></p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
          <div class="card" style="width: 100%; height:200">
            <h6 class="card-header bg-warning">Gestión de administradores</h6>
            <div class="card-body">
              <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-list"></i></i></p>
            </div>
          </div>
        </a>
      </div>
    </div>
@include('sitioAdmin.footer')