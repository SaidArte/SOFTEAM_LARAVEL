@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
        <center>
            <h1>Información de Respuestas</h1>
        </center>
        <blockquote class="blockquote text-center">
            <p class="mb-0">Registro de Respuestas.</p>
        </blockquote>

        @section('content')
        <div class="container mt-5">
            <h1 class="mb-4">Recuperación de Contraseña</h1>

            <form method="POST" action="{{ route('Alcaldia.respuestas.submit') }}">
                @csrf
                <div class="mb-3 row">
                        <label for="ALPREGUNTA" class="col-sm-3 col-form-label">Pregunta anterior:</label>
                        <div class="col-sm-3">
                            <input type="text" readonly id="PREGUNTA" name="PREGUNTA" class="form-control" value="{{ $PREGUNTA }}" required>
                        </div>
                </div>
                <div class="mb-3 row">
                    <label for="ALPREGUNTA" class="col-sm-3 col-form-label">Seleccione la pregunta de seguridad:</label>
                        <div class="col-sm-3">
                            <select class="form-select" id="PREGUNTA" name="PREGUNTA" required>
                                <option value="X" selected = "selected" disabled>- Elija una pregunta -</option>
                                @foreach ($preguntasArreglo as $preguntas)
                                    <option value="{{$preguntas['PREGUNTA']}}">{{$preguntas['PREGUNTA']}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

            <div class="mb-3">
                <label for="secret_answer" class="form-label">Respuesta Secreta:</label>
                <input type="password" id="RESPUESTA" name="RESPUESTA" class="form-control" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
            </div>
            <br>
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <div class="text-center">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                </div>
            @endif
        </form>
    </div>
        @stop

        @section('css')
            <link rel="stylesheet" href="/css/admin_custom.css">
        @stop

        @section('js')
         <script> console.log('Hi!'); </script>
        @stop
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop
    