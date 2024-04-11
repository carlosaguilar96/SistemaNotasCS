@include('header')
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">			
                    <img class="img mx-auto d-block" width="175" src="http://127.0.0.1:8000/img/logo.png" alt="">                          
                    <div class="my-4" style="background-color:black; height: 1px; border-radius: 2rem"></div>
                    @if ($errors->any())
                        <div class="alert alert-danger my-2 pb-0">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Usuario" aria-label="user" name="user">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" placeholder="Contraseña" aria-label="password" name="password">
                        </div>	
                        <div class="row">
                            <button class="btn btn-warning mt-2 mx-auto d-block " style="width:50%;" type="submit">Iniciar Sesión</button>
                        </div>	
                        <div class="row">
                            <p class="mt-3"><a href="#" class="link-body-emphasis link-underline link-underline-opacity-0"">Olvidé mi contraseña</a></p>
                        </div>											
                    </form>		
                </div>										
            </div>
        </div>
    </div>
@include('footer')
