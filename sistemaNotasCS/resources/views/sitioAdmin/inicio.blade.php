@include('sitioAdmin.header')
    <div class="row text-center">
        <div class="col-lg-4">
          <div class="card text-center mb-3" style="width: 100%;">
            <img height="200" width="200" src="http://127.0.0.1:8000/img/foto.png" class="img mx-auto d-block p-4 bg-warning mt-3" alt="...">
            <div class="card-body">
              <h4 class="card-title" style="font-weight:bold">Nombre del usuario</h4>
              <p class="card-text" style="font-style:italic">Administrador</p>
              <a href="#" class="btn btn-warning text-center mt-2">Ver información</a>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row" style="align-items: center;display: flex;justify-content: center;">
            <div class="col-md-4 col-6 mb-3">
              <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.gestionUsuarios')}}">
              <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión usuarios</h6>
                <div class="card-body">
                  <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-users"></i></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-4 col-6 mb-3">
              <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
              <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión año escolar</h6>
                <div class="card-body">
                  <p class="card-text" style="font-size:70pt"><i class="fa-regular fa-calendar-days"></i></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-4 col-6 mb-3">
              <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
              <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión secciones</h6>
                <div class="card-body">
                  <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-chalkboard-user"></i></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-4 col-6 mb-3">
              <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
              <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión grados</h6>
                <div class="card-body">
                  <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-school"></i></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-4 col-6 mb-3">
              <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
              <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión materias</h6>
                <div class="card-body">
                  <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-book"></i></p>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
    </div>
@include('sitioAdmin.footer')