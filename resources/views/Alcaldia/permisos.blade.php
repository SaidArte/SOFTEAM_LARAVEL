@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
        <center>
            <h1>Información de Permisos</h1>
        </center>
        <blockquote class="blockquote text-center">
            <p class="mb-0">Registro de Permisos.</p>
            <footer class="blockquote-footer">Permisos <cite title="Source Title">Registrados</cite></footer>
        </blockquote>
    @endif
@stop

@section('content')
    @if(session()->has('user_data'))
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Permisos">+ Nuevo</button>
        <div class="modal fade bd-example-modal-sm" id="Permisos" tabindex="-1">
        <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo permiso</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Permisos/insertar') }}" method="post">
                                @csrf              
                                    <div class="mb-3">
                                        <label for="LNOM_ROL">Rol</label>
                                        <select class="form-select" id="NOM_ROL" name="NOM_ROL">
                                            <option value="X" selected = "selected" disabled>- Elija el rol -</option>
                                            
                                            @foreach ($rolesArreglo as $roles)
                                                <option value="{{$roles['COD_ROL']}}">{{$roles['NOM_ROL']}}</option>
                                            @endforeach 

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="LROL">OBJETO</label>
                                        <select class="form-select" id="OBJETO" name="OBJETO">
                                            <option value="X" selected = "selected" disabled>- Elija un objeto -</option>
                                            <option value="Principal">Principal</option>
                                            <option value="Mant. General">Mant. General</option>
                                            <option value="Permisos Alcaldía">Permisos Alcaldía</option>
                                            <option value="Tablas Seguridad">Tablas Seguridad</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                    <p>Seleccione las funciones que desea que realice este permiso</p>
    <label for="LPRM_INSERTAR">Permiso de Insertar</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="PRM_INSERTAR" name="PRM_INSERTAR" value="S">
        <label class="form-check-label" for="PRM_INSERTAR">Insertar</label>
    </div>
</div>

<!-- Actualizar -->
<div class="mb-3">
    <label for="LPRM_ACTUALIZAR">Permiso de Actualizar</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR" value="S">
        <label class="form-check-label" for="PRM_ACTUALIZAR">Actualizar</label>
    </div>
</div>

<!-- Consultar -->
<div class="mb-3">
    <label for="LPRM_CONSULTAR">Permiso de Consultar</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="PRM_CONSULTAR" name="PRM_CONSULTAR" value="S">
        <label class="form-check-label" for="PRM_CONSULTAR">Consultar</label>
    </div>
</div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover table-responsive table-verde-claro table-striped mt-1" style="border: 2px solid lime;">
            <thead>
                <tr>
                    <th>Código Rol</th>
                    <th>Rol</th>
                    <th>Código del Objeto</th>
                    <th>Objeto</th>
                    <th>Permisos Insertar</th>
                    <th>Permisos Actualizar</th>
                    <th>Permisos Consultar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through $citaArreglo and show data -->
                @foreach($citaArreglo as $Permisos)
                    <tr>
                        <td>{{$Permisos['COD_ROL']}}</td>
                        <td>{{$Permisos['NOM_ROL']}}</td>
                        <td>{{$Permisos['COD_OBJETO']}}</td>
                        <td>{{$Permisos['OBJETO']}}</td>
                        <td>
                            @if ($Permisos['PRM_INSERTAR'] === 'S')
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($Permisos['PRM_ACTUALIZAR'] === 'S')
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($Permisos['PRM_CONSULTAR'] === 'S')
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Permisos-edit-{{$Permisos['COD_ROL']}}">
                                <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                            </button>
                            <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Permisos['COD_OBJETO']}})">
                                <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                            </button>
                        </td>
                    </tr>
                   <!-- Modal for editing goes here -->
                   <div class="modal fade bd-example-modal-sm" id="Permisos-edit-{{$Permisos['COD_ROL']}}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualizar datos del permiso</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Si desea agregar un permiso, marque la casilla; en caso contrario, déjela desmarcada.</p>
                        <form action="{{ url('Permisos/actualizar') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="COD_ROL" value="{{$Permisos['COD_ROL']}}"> 
                            <input type="hidden" class="form-control" name="COD_OBJETO" value="{{$Permisos['COD_OBJETO']}}">
                            
                            <!-- Insertar -->
<div class="mb-3">
    <label for="LPRM_INSERTAR">Insertar</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="PRM_INSERTAR" name="PRM_INSERTAR" value="S" {{$Permisos['PRM_INSERTAR'] === 'S' ? 'checked' : ''}}>
        <label class="form-check-label" for="PRM_INSERTAR">Insertar</label>
    </div>
</div>

<!-- Actualizar -->
<div class="mb-3">
    <label for="LPRM_ACTUALIZAR">Actualizar</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR" value="S" {{$Permisos['PRM_ACTUALIZAR'] === 'S' ? 'checked' : ''}}>
        <label class="form-check-label" for="PRM_ACTUALIZAR">Actualizar</label>
    </div>
</div>

<!-- Consultar -->
<div class="mb-3">
    <label for="LPRM_CONSULTAR">Consultar</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="PRM_CONSULTAR" name="PRM_CONSULTAR" value="S" {{$Permisos['PRM_CONSULTAR'] === 'S' ? 'checked' : ''}}>
        <label class="form-check-label" for="PRM_CONSULTAR">Consultar</label>
    </div>
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
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop