@include('sitioEstudiante.header')
    <div class="row text-center">
        <div class="col-lg-4">
          <div class="card text-center mb-3" style="width: 100%;">
            <img height="200" width="200" src="{{asset('img/fotosE/'.$estudiante[0]->foto)}}" class="img mx-auto d-block p-4 bg-warning mt-3" alt="...">
            <div class="card-body">
              <h4 class="card-title" style="font-weight:bold">{{$estudiante[0]->nombres}} {{$estudiante[0]->apellidos}}</h4>
              <p class="card-text" style="font-style:italic">Estudiante</p>
              <a href="#" class="btn btn-warning text-center mt-2">Ver información</a>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row" style="align-items: center;display: flex;justify-content: center;">
            @if (session()->has('secciones'))
              @foreach(session()->get('secciones') as $seccion)
              <div class="col-md-4 col-6 mb-3">
                <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('estudiante.showNotas',$seccion->idSeccion)}}">
                <div class="card" style="width: 100%; height:200">
                  <h6 class="card-header @if($seccion->estadoFinalizacion==0) bg-warning @else bg-dark-subtle @endif">{{$seccion->nombreSeccion}} - {{$seccion->nombreAño}}</h6>
                  <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-list-check"></i></p>
                  </div>
                </div>
                </a>
              </div>
              @endforeach
            @endif
          </div>
        </div>
    </div>
@include('sitioEstudiante.footer')