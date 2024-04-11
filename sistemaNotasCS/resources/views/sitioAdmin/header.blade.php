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

    </head>
    <body>
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
                          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                              </a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                  <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                              </ul>
                            </li>
                          </ul>
                          <form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                          </form>
                        </div>
                  
                </div>                
            </nav>
        </div>
        <div class="container" style="width:100%; margin-top:100pt">