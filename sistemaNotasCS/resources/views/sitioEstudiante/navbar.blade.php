<div id="divHeader">
    <nav id="navHeader" class="navbar border-bottom border-body">         
        <div class="container-fluid" style="height:50pt;">
            <a class="navbar-brand " href="{{route('estudiante.inicio')}}" style="margin-top:3px">
                <img class="img mb-2" width="50" src="{{asset('img/logo.png')}}" alt="">
                <p>Colegio Salarrué</p>
            </a>
            <button  class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation" style="border-color:aliceblue; margin-top:-10px">
                <span style="color:white; font-size:26pt"><i class="fa-solid fa-bars"></i></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">MENÚ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('estudiante.inicio')}}">INICIO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('estudiante.perfil')}}">MI PERFIL</a>
                        </li>
                        @if (session()->has('secciones'))
                            @foreach(session()->get('secciones') as $seccion)
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{route('estudiante.showNotas',$seccion->idSeccion)}}" style="text-transform:uppercase">{{$seccion->nombreSeccion}} - {{$seccion->nombreAño}}</a>
                                </li>
                            @endforeach
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('estudiante.cambiarContraseñaEstudent')}}">CAMBIAR CONTRASEÑA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('logout')}}">CERRAR SESIÓN</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>                
    </nav>
</div>