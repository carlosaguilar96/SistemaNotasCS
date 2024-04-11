@include('sitioAdmin.header')
<div class="row text-center">
    <div class="col-12">
        <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">Gestión de grados</p>
        <p class="text-center" style="font-size:12pt; color:black">Opciones para la gestión de planes académicos y materias</p>
    </div>
</div>
<div class="row text-center d-md-flex d-none" style="align-items: center;display: flex;justify-content: center;">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',1)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Séptimo Grado</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-7"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',2)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Octavo Grado</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-8"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',3)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Noveno Grado</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-9"></i></p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row text-center d-md-flex d-none" style="align-items: center;display: flex;justify-content: center;">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',4)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Primer Año</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-1"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',5)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Segundo Año</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-2"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.indexMaterias')}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión de materias</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-list"></i></i></p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row text-center d-flex d-md-none" style="align-items: center;display: flex;justify-content: center;">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',1)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Séptimo Grado</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-7"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',2)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Octavo Grado</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-8"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',3)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Noveno Grado</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-9"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',4)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Primer Año</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-1"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.showGrado',5)}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Segundo Año</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-2"></i></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <a class="link-body-emphasis link-underline link-underline-opacity-0" href="{{route('admin.indexMaterias')}}">
            <div class="card" style="width: 100%; height:200">
                <h6 class="card-header bg-warning">Gestión de materias</h6>
                <div class="card-body">
                    <p class="card-text" style="font-size:70pt"><i class="fa-solid fa-list"></i></i></p>
                </div>
            </div>
        </a>
    </div>
</div>
@include('sitioAdmin.footer')