@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Información de Respuestas</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Respuestas.</p>
        <footer class="blockquote-footer">Respuestas <cite title="Source Title">Registradas</cite></footer>
    </blockquote>
@stop

@section('content')
    <table cellspacing="7" cellpadding="7" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <th>Código de Usuario</th>
            <th>Pregunta</th>
            <th>Respuesta</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Respuestas)
                <tr>
                    <td>{{$Respuestas['COD_USUARIO']}}</td>   
                    <td>{{$Respuestas['PREGUNTA']}}</td> 
                    <td>{{$Respuestas['RESPUESTA']}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Respuestas-edit-{{$Respuestas['COD_USUARIO']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Respuestas['COD_USUARIO']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="Respuestas-edit-{{$Respuestas['COD_USUARIO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar datos de la pregunta/respuesta</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar nuevos datos</p>
                                <form action="{{ url('Respuestas/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_USUARIO" value="{{$Respuestas['COD_USUARIO']}}"> 
                                        
                                        <label for="LPREGUNTA">Pregunta de seguridad</label>
                                        <input type="text" readonly class="form-control" id="PREGUNTA" name="PREGUNTA" value="{{$Respuestas['PREGUNTA']}}">
                                        <select class="form-select" id="PREGUNTA" name="PREGUNTA">
                                            <option value="X" selected = "selected" disabled>- Elija una pregunta -</option>
                                            <option value="¿Nombre de su primer mascota?">¿Nombre de su primer mascota?</option>
                                            <option value="¿Nombre primer pareja?">¿Nombre primer pareja?</option>
                                            <option value="¿Ciudad donde nacio?">¿Ciudad donde nacio?</option>
                                            <option value="¿Ciudad donde vivio su adolecencia?">¿Ciudad donde vivio su adolecencia?</option>
                                            <option value="¿Cuál es el nombre de su madre?">¿Cuál es el nombre de su madre?</option>
                                        </select>
                                        
                                        <div class="mb-3">
                                            <label for="LRESPUESTA">Respuesta</label>
                                            <input type="text" id="RESPUESTA" class="form-control" name="RESPUESTA" value="{{$Respuestas['RESPUESTA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Editar</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
   <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
   <script> console.log('Hi!'); </script>
@stop