<div id="divHeader">
    <nav id="navHeader" class="navbar border-bottom border-body">         
        <div class="container-fluid" style="height:50pt;">
            <a class="navbar-brand " href="{{route('admin.inicio')}}" style="margin-top:3px">
                <img class="img mb-2" width="50" src="http://127.0.0.1:8000/img/logo.png" alt="">
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
                            <a class="nav-link" aria-current="page" href="{{route('admin.inicio')}}">INICIO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('sitioAdmin.showPerfil')}}">MI PERFIL</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                USUARIOS
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('admin.crearEstudiante')}}">AGREGAR ESTUDIANTE</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.indexEstudiantes')}}">GESTIÓN ESTUDIANTES</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{route('admin.crearProfesor')}}">AGREGAR PROFESOR</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.indexProfesores')}}">GESTIÓN PROFESORES</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{route('admin.crearAdmin')}}">AGREGAR ADMINISTRADOR</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.indexAdministradores')}}">GESTIÓN ADMINISTRADORES</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('admin.gestionAño')}}">AÑO ESCOLAR</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                GRADOS
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('admin.showGrado',1)}}">SÉPTIMO GRADO</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.showGrado',2)}}">OCTAVO GRADO</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.showGrado',3)}}">NOVENO GRADO</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.showGrado',4)}}">PRIMER AÑO GENERAL</a></li>
                                <li><a class="dropdown-item" href="{{route('admin.showGrado',5)}}">SEGUNDO AÑO GENERAL</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('admin.indexMaterias')}}">MATERIAS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('admin.cambiarContraseña')}}">CAMBIAR CONTRASEÑA</a>
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