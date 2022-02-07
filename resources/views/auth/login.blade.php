@extends('layouts.app')

<!-- title -->
@section('pagina')Login @endsection

@section('content')

<div class="col-md-12 col-lg-10 col-12">

    <div class="wrap d-md-flex">
        <div class="img" style="background-image: url({{ asset('asset/img/login.png') }});">
        </div>
        <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
                <div class="w-100">
                    <h3 class="mb-4">Iniciar Sesión</h3>
                </div>
            </div>
            <form class="signin-form needs-validation" id="formulario_login" method="POST" novalidate>
                @csrf
                <div class="form-group mb-3">
                    <label class="label" for="name">Usuario</label>
                    <input type="text" class="form-control" name="email" placeholder="Correo Electronico" required>
                </div>
                <div class="form-group mb-3">
                    <label class="label" for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Ingresar</button>
                </div>
            </form>

            <p class="text-center">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                     </a>
                @endif
            </p>

        </div>
    </div>
</div>

@endsection
