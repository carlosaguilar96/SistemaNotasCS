<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

    <title>Colegio Salarrué</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e359753675.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="{{asset('css/dtstyles.css')}}" />
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/fixedColumns.dataTables.js"></script>

    <style>
        .dtfc-fixed-start .dtfc-fixed-left{
            background-color: #6c757d;
        }
    </style>
    

</head>

<body>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json'
                },
                pagingType: 'simple_numbers',
                scrollX: true,
                ordering: false,
                paging:false,
                fixedColumns: true,
                fixedColumns: {
                    start: 2
                },
                scrollCollapse: true,
            });
        });
    </script>
    @include('sitioProfesor.navbar')
    @if (session('exitoAgregarNotas'))
    <script>
        Swal.fire({
            title: "Notas agregadas",
            text: "{{ session('exitoAgregarNotas') }}",
            icon: "success",
            button: "OK",
            confirmButtonColor: "#B84C4C",
        });
    </script>
    @endif
    @if (session('errorAgregarNotas'))
    <script>
        Swal.fire({
            title: "Error al ingresar notas",
            text: "{{ session('errorAgregarNotas') }}",
            icon: "error",
            button: "OK",
            confirmButtonColor: "#B84C4C",
        });
    </script>
    @endif
    <div class="container" style="width:100%; margin-top:100pt">
        <div class="row text-center">
            <div class="col-12">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">{{$grupo[0]->nombreMateria}} - {{$grupo[0]->nombreSeccion}}</p>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Año</h5>
                        <h3><b>{{$año[0]->nombreAño}}</b></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Periodo</h5>
                        <h3><b>{{$periodo[0]->nombrePeriodo}}</b></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Total Estudiantes</h5>
                        <h3><b>{{$totalEstudiantes}}</b></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Masculinos</h5>
                        <h3><b>{{$totalEstudiantesM}}</b></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Femeninos</h5>
                        <h3><b>{{$totalEstudiantesF}}</b></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Evaluaciones</h5>
                        <div class="row justify-content-center">
                            <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                                @if($verificarEvaluacion1 == 0)
                                <a href="{{route('profesor.agregarNotas',[1,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-warning fw-bold" style="width: 100%">Actividad 1</button></a>
                                @else
                                <a href="{{route('profesor.mostrarNotas',[1,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-secondary fw-bold" style="width: 100%">Actividad 1</button></a>
                                @endif
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                                @if($verificarEvaluacion2 == 0)
                                <a href="{{route('profesor.agregarNotas',[2,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-warning fw-bold" style="width: 100%">Actividad 2</button></a>
                                @else
                                <a href="{{route('profesor.mostrarNotas',[2,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-secondary fw-bold" style="width: 100%">Actividad 2</button></a>
                                @endif
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                                @if($verificarEvaluacion3 == 0)
                                <a href="{{route('profesor.agregarNotas',[3,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-warning fw-bold" style="width: 100%">Actividad 3</button></a>
                                @else
                                <a href="{{route('profesor.mostrarNotas',[3,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-secondary fw-bold" style="width: 100%">Actividad 3</button></a>
                                @endif
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                                @if($verificarEvaluacion4 == 0)
                                <a href="{{route('profesor.agregarNotas',[4,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-warning fw-bold" style="width: 100%">Laboratorio</button></a>
                                @else
                                <a href="{{route('profesor.mostrarNotas',[4,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-secondary fw-bold" style="width: 100%">Laboratorio</button></a>
                                @endif
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                                @if($verificarEvaluacion5 == 0)
                                <a href="{{route('profesor.agregarNotas',[5,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-warning fw-bold" style="width: 100%">Examen</button></a>
                                @else
                                <a href="{{route('profesor.mostrarNotas',[5,$grupo[0]->idDetalle])}}"><button type="button" class="btn btn-secondary fw-bold" style="width: 100%">Examen</button></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Cuadro de notas</h5>
                        <table class="table table-bordered border-black align-middle justify-content-center data-table nowrap table-hover" style="width:100%;">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="table-secondary" rowspan="2">#</th>
                                    <th class="table-secondary" rowspan="2" style="border-right: 3px solid black;">Estudiante</th>
                                    <th colspan="7" class="text-center" style="border-right: 3px solid black;">Periodo I</th>
                                    <th colspan="7" class="text-center" style="border-right: 3px solid black;">Periodo II</th>
                                    <th colspan="7" class="text-center" style="border-right: 3px solid black;">Periodo III</th>
                                    <th colspan="7" class="text-center" style="border-right: 3px solid black;">Periodo IV</th>
                                    <th rowspan="2" class="text-center">Nota Final</th>
                                    <th rowspan="2" class="text-center">Concepto</th>
                                </tr>
                                <tr class="table-secondary">
                                    @for($i=1;$i<=4;$i++)
                                    <th class="px-2" style="writing-mode: vertical-rl;">Actividad 1</th>
                                    <th class="px-2" style="writing-mode: vertical-rl;">Actividad 2</th>
                                    <th class="px-2" style="writing-mode: vertical-rl;">Actividad 3</th>
                                    <th class="px-2" style="writing-mode: vertical-rl;">Laboratorio</th>
                                    <th class="px-2" style="writing-mode: vertical-rl;">Examen</th>
                                    <th class="px-2" style="writing-mode: vertical-rl;">Nota Final</th>
                                    <th class="px-2" style="writing-mode: vertical-rl; border-right: 3px solid black;">Concepto</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 0; ?>
                                @foreach($estudiantes as $estudiante)
                                <tr>
                                    <td class="table-secondary">{{ $j+1 }}</td>
                                    <td class="table-secondary" style="border-right: 3px solid black;">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</td>
                                    <td class="text-center">@if(isset($notas11[$j])){{$notas11[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas12[$j])){{$notas12[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas13[$j])){{$notas13[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas14[$j])){{$notas14[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas15[$j])){{$notas15[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="bg-warning-subtle text-center"><b><?php $promedio1 = 0.0;
                                                                 if(isset($notas11[$j])) $promedio1 += $notas11[$j]->porcentajeGanado;
                                                                 if(isset($notas12[$j])) $promedio1 += $notas12[$j]->porcentajeGanado;
                                                                 if(isset($notas13[$j])) $promedio1 += $notas13[$j]->porcentajeGanado;
                                                                 if(isset($notas14[$j])) $promedio1 += $notas14[$j]->porcentajeGanado;
                                                                 if(isset($notas15[$j])) $promedio1 += $notas15[$j]->porcentajeGanado;
                                                                 echo number_format($promedio1,1); 
                                                                 ?></b></td>
                                    <td class="@if($promedio1>=6) bg-success-subtle @else bg-danger-subtle @endif text-center" style="border-right: 3px solid black;"><b>@if($promedio1>=6) A @else R @endif</b></td>
                                    <td class="text-center">@if(isset($notas21[$j])){{$notas21[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas22[$j])){{$notas22[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas23[$j])){{$notas23[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas24[$j])){{$notas24[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas25[$j])){{$notas25[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="bg-warning-subtle text-center"><b><?php $promedio2 = 0.0;
                                                                 if(isset($notas21[$j])) $promedio2 += $notas21[$j]->porcentajeGanado;
                                                                 if(isset($notas22[$j])) $promedio2 += $notas22[$j]->porcentajeGanado;
                                                                 if(isset($notas23[$j])) $promedio2 += $notas23[$j]->porcentajeGanado;
                                                                 if(isset($notas24[$j])) $promedio2 += $notas24[$j]->porcentajeGanado;
                                                                 if(isset($notas25[$j])) $promedio2 += $notas25[$j]->porcentajeGanado;
                                                                 echo number_format($promedio2,1); 
                                                                 ?></b></td>
                                    <td class="@if($promedio2>=6) bg-success-subtle @else bg-danger-subtle @endif text-center" style="border-right: 3px solid black;"><b>@if($promedio2>=6) A @else R @endif</b></td>
                                    <td class="text-center">@if(isset($notas31[$j])){{$notas31[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas32[$j])){{$notas32[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas33[$j])){{$notas33[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas34[$j])){{$notas34[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas35[$j])){{$notas35[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="bg-warning-subtle text-center"><b><?php $promedio3 = 0.0;
                                                                 if(isset($notas31[$j])) $promedio3 += $notas31[$j]->porcentajeGanado;
                                                                 if(isset($notas32[$j])) $promedio3 += $notas32[$j]->porcentajeGanado;
                                                                 if(isset($notas33[$j])) $promedio3 += $notas33[$j]->porcentajeGanado;
                                                                 if(isset($notas34[$j])) $promedio3 += $notas34[$j]->porcentajeGanado;
                                                                 if(isset($notas35[$j])) $promedio3 += $notas35[$j]->porcentajeGanado;
                                                                 echo number_format($promedio3,1); 
                                                                 ?></b></td>
                                    <td class="@if($promedio3>=6) bg-success-subtle @else bg-danger-subtle @endif text-center" style="border-right: 3px solid black;"><b>@if($promedio3>=6) A @else R @endif</b></td>
                                    <td class="text-center">@if(isset($notas41[$j])){{$notas41[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas42[$j])){{$notas42[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas43[$j])){{$notas43[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas44[$j])){{$notas44[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="text-center">@if(isset($notas45[$j])){{$notas45[$j]->nota}}@else 0.0 @endif</td>
                                    <td class="bg-warning-subtle text-center"><b><?php $promedio4 = 0.0;
                                                                 if(isset($notas41[$j])) $promedio4 += $notas41[$j]->porcentajeGanado;
                                                                 if(isset($notas42[$j])) $promedio4 += $notas42[$j]->porcentajeGanado;
                                                                 if(isset($notas43[$j])) $promedio4 += $notas43[$j]->porcentajeGanado;
                                                                 if(isset($notas44[$j])) $promedio4 += $notas44[$j]->porcentajeGanado;
                                                                 if(isset($notas45[$j])) $promedio4 += $notas45[$j]->porcentajeGanado;
                                                                 echo number_format($promedio4,1); 
                                                                 ?></b></td>
                                    <td class="@if($promedio4>=6) bg-success-subtle @else bg-danger-subtle @endif text-center" style="border-right: 3px solid black;"><b>@if($promedio4>=6) A @else R @endif</b></td>
                                    <td class="text-center"><b>10</b></td>
                                    <td class="text-center"><b>A</b></td>
                                </tr>
                                <?php $j++; ?>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="divFooter" style="margin-top: 40pt">
        <nav id="navFooter" class="navbar navbar-expand-lg border-bottom border-body pt-4">
            <div class="container-fluid mx-auto d-block">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-2 mt-4"><img class="img mx-auto d-block" width="175" src="http://127.0.0.1:8000/img/logo.png" alt=""></div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <p><span id="titulo">Redes sociales:</span><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Facebook</a><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Instagram</a><br><br><a class="link-body-emphasis link-underline link-underline-opacity-0" href="#">Twitter</a></p>
                    </div>
                    <div class="col-xl-5 col-sm-6 mt-4">
                        <p><span id="titulo">Horarios de atención:</span><br><br>Lunes a viernes: 7:00-11:50 - 13:15-17:50<br><br>Dirección: Barrio Mejicano, avenida Morazán, #7-17, Sonsonate, El Salvador<br><br>Teléfonos: 2429-7500, 2429-7502</p>
                    </div>
                    <div class="col-12 text-center" style="font-style: italic">
                        <p><br>Copyright ©2024 Colegio Salarrué, All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>