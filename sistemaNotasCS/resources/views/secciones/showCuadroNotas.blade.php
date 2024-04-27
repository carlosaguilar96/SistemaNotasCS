<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

    <title>Colegio Salarrué</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fa/css/all.css')}}" crossorigin="anonymous">
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
    @include('sitioAdmin.navbar')
    <div class="container" style="width:100%; margin-top:100pt">
        <div class="row text-center">
            <div class="col-12">
                <p class="text-center" style="font-size:16pt; font-weight:bold; color:black">{{$seccion[0]->nombreSeccion}}</p>
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
                        <h3><b>@if(isset($periodo[0])){{$periodo[0]->nombrePeriodo}}@else Periodos finalizados @endif</b></h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Encargado</h5>
                        <h4><b>{{$seccion[0]->nombres}} {{$seccion[0]->apellidos}}</b></h4>
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
                        <h5 class="card-title">Cuadro de notas</h5>
                        <table class="table table-bordered border-black align-middle justify-content-center data-table nowrap table-hover" style="width:100%;">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="table-secondary" rowspan="2">#</th>
                                    <th class="table-secondary" rowspan="2" style="border-right: 3px solid black;">Estudiante</th>
                                    @foreach($materias as $materia)
                                            <th colspan="5" class="text-center" style="border-right: 3px solid black;">{{$materia->nombreMateria}}</th>
                                    @endforeach
                                    <th rowspan="2" class="text-center" @if(isset($periodo[0])) hidden @endif>Nota Final</th>
                                    <th rowspan="2" class="text-center" @if(isset($periodo[0])) hidden @endif>Concepto</th>
                                </tr>
                                <tr class="table-secondary">
                                    @for($i=1;$i<=count($materias);$i++)
                                        <th class="px-2">Periodo I</th>
                                        <th class="px-2">Periodo II</th>
                                        <th class="px-2">Periodo III</th>
                                        <th class="px-2">Periodo IV</th>
                                        <th class="px-2" style="border-right: 3px solid black;" >Nota Final</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 0; $aprobados=0; $reprobados=0 ?>
                                @foreach($estudiantes as $estudiante)
                                <tr>
                                    <td class="table-secondary">{{ $j+1 }}</td>
                                    <td class="table-secondary" style="border-right: 3px solid black;">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</td>
                                    @for($l=0;$l<count($materias);$l++)
                                    <td class="@if(number_format($notas1[$estudiante->NIE][$l],1)>=6) bg-success-subtle @else bg-danger-subtle @endif text-center">{{number_format($notas1[$estudiante->NIE][$l],1)}}</td>
                                    <td class="@if(number_format($notas2[$estudiante->NIE][$l],1)>=6) bg-success-subtle @else bg-danger-subtle @endif text-center">{{number_format($notas2[$estudiante->NIE][$l],1)}}</td>
                                    <td class="@if(number_format($notas3[$estudiante->NIE][$l],1)>=6) bg-success-subtle @else bg-danger-subtle @endif text-center">{{number_format($notas3[$estudiante->NIE][$l],1)}}</td>
                                    <td class="@if(number_format($notas4[$estudiante->NIE][$l],1)>=6) bg-success-subtle @else bg-danger-subtle @endif text-center">{{number_format($notas4[$estudiante->NIE][$l],1)}}</td>
                                    <td class="@if(number_format($promedios[$estudiante->NIE][$l],1)>=6) bg-success-subtle @else bg-danger-subtle @endif text-center" style="border-right: 3px solid black;"><b>{{number_format($promedios[$estudiante->NIE][$l],1)}}</b></td>
                                    @endfor
                                    <td class="@if(isset($promedioFinal[$j])) @if(number_format($promedioFinal[$j]->promedio,1)>=6) bg-success-subtle @else bg-danger-subtle @endif @else bg-danger-subtle @endif text-center" @if(isset($periodo[0])) hidden @endif><b>@if(isset($promedioFinal[$j])) {{number_format($promedioFinal[$j]->promedio,1)}} @else 0.0 @endif</b></td>
                                    <td class="@if(isset($promedioFinal[$j])) @if(number_format($promedioFinal[$j]->promedio,1)>=6) bg-success-subtle @else bg-danger-subtle @endif @else bg-danger-subtle @endif text-center" @if(isset($periodo[0])) hidden @endif><b>@if(isset($promedioFinal[$j])) @if(number_format($promedioFinal[$j]->promedio,1)>=6) APROBADO @else REPROBADO @endif @else REPROBADO @endif</b></td>
                                </tr>
                                <?php if(isset($promedioFinal[$j])){ if(number_format($promedioFinal[$j]->promedio,1)>=6)$aprobados++; else $reprobados++; } $j++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(!isset($periodo[0]))
            <div class="col-md-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Aprobados: <b>{{$aprobados}}</b></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Reprobados: <b>{{$reprobados}}</b></h5>
                    </div>
                </div>
            </div>
            @endif
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
</body>

</html>