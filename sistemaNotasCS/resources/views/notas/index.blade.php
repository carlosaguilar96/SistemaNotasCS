<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

    <title>Colegio Salarrué</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fa/css/all.css')}}" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
</head>

<body>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json'
                },
                pagingType: 'simple_numbers'
            });
        });
    </script>
    @include('sitioProfesor.navbar')
    <div class="container" style="width:100%; margin-top:100pt">
        <div class="row text-center mb-4">
            <div class="col-12">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">
                    {{ $eval[0]->nombreEvaluacion }}</p>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Materia</h5>
                        <h4><b>{{ $grupo[0]->nombreMateria }}</b></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Sección</h5>
                        <h4><b>{{ $grupo[0]->nombreSeccion }}</b></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Periodo</h5>
                        <h4><b>{{ $periodo[0]->nombrePeriodo }}</b></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Porcentaje Valorativo</h5>
                        <h4><b>{{ $eval[0]->porcentaje }} %</b></h4>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger my-2 pb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-12">
                <div class="card mb-3" style="max-widt: 100%;">
                    <div class="card-body mt-3">
                        <h5 class="card-title">Asignar notas</h5>
                        <form method="POST" action="{{ route('profesor.insertarNotas') }}">
                            @csrf
                            <table class="table table-bordered align-middle justify-content-center data-table"
                                style="width:100%">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>#</th>
                                        <th>Estudiante</th>
                                        <th>Actividad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="text" value="{{ $evaluacion }}" name="idEvaluacion" hidden>
                                    <input type="number" value="{{ $grupo[0]->idDetalle }}" name="idDetalleMateria"
                                        hidden>
                                    <input type="text" value="{{ $periodo[0]->idPeriodo }}" name="idPeriodo" hidden>
                                    <?php $i = 1; ?>
                                    @foreach ($estudiantes as $students)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td scope="col">{{ $students->apellidos }}, {{ $students->nombres }}
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $students->idDetalle }}" name="estudiantes[]" hidden>
                                                <input maxlength="3" type="text" class="form-control" placeholder="Nota evaluacion" name="notas[]" id="txtNota" aria-describedby="addon-wrapping">
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-warning mb-4">Agregar Calificaciones</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="divFooter" style="margin-top: 40pt">
        <nav id="navFooter" class="navbar navbar-expand-lg border-bottom border-body pt-4">
            <div class="container-fluid mx-auto d-block">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-2 mt-4"><img class="img mx-auto d-block" width="175"
                            src="http://127.0.0.1:8000/img/logo.png" alt=""></div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <p><span id="titulo">Redes sociales:</span><br><br><a
                                class="link-body-emphasis link-underline link-underline-opacity-0"
                                href="#">Facebook</a><br><br><a
                                class="link-body-emphasis link-underline link-underline-opacity-0"
                                href="#">Instagram</a><br><br><a
                                class="link-body-emphasis link-underline link-underline-opacity-0"
                                href="#">Twitter</a></p>
                    </div>
                    <div class="col-xl-5 col-sm-6 mt-4">
                        <p><span id="titulo">Horarios de atención:</span><br><br>Lunes a viernes: 7:00-11:50 -
                            13:15-17:50<br><br>Dirección: Barrio Mejicano, avenida Morazán, #7-17, Sonsonate, El
                            Salvador<br><br>Teléfonos: 2429-7500, 2429-7502</p>
                    </div>
                    <div class="col-12 text-center" style="font-style: italic">
                        <p><br>Copyright ©2024 Colegio Salarrué, All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <script src="{{asset('js/nota/validarNota.js')}}"></script>
</body>

</html>
