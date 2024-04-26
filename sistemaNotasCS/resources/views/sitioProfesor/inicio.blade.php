@include('sitioProfesor.header')
    <div class="row text-center">
        <div class="col-lg-4">
          <div class="card text-center mb-3" style="width: 100%;">
            <img height="200" width="200" src="{{asset('img/fotosP/'.$profesor[0]->foto)}}" class="img mx-auto d-block p-4 bg-warning mt-3" alt="...">
            <div class="card-body">
              <h4 class="card-title" style="font-weight:bold">{{$profesor[0]->nombres}} {{$profesor[0]->apellidos}}</h4>
              <p class="card-text" style="font-style:italic">Profesor</p>
              <a href="{{route('profesor.showPerfil')}}" class="btn btn-warning text-center mt-2">Ver información</a>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row" style="align-items: center;display: flex;justify-content: center;">
            @if (session()->has('SeccionEncargado'))
            <div class="col-md-4 col-6 mb-3">
              <a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">
              <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Mi sección</h6>
                <div class="card-body">
                  <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-people-line"></i></p>
                </div>
              </div>
              </a>
            </div>
            @endif
            @if (session()->has('grupos'))
              @foreach(session()->get('grupos') as $grupo)
              <div class="col-md-4 col-6 mb-3">
                <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('profesor.showGrupo',$grupo->idDetalle)}}">
                <div class="card" style="width: 100%; height:200">
                  <h6 class="card-header bg-warning">{{$grupo->nombreMateria}} - {{$grupo->nombreSeccion}}</h6>
                  <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-chalkboard-user"></i></p>
                  </div>
                </div>
                </a>
              </div>
              @endforeach
            @endif
          </div>
        </div>
    </div>
@include('sitioProfesor.footer')