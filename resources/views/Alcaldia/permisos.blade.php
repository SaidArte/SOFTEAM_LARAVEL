@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Información de Permisos</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Permisos.</p>
        <footer class="blockquote-footer">Permisos <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
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
                                <label for="LPRM_INSERTAR">Insertar</label>
                                <select class="form-select" id="PRM_INSERTAR" name="PRM_INSERTAR">
                                <option value="X" selected = "selected" disabled>- Elija una opción -</option>
                                    <option value="S">Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="LPRM_ACTUALIZAR">Actualizar</label>
                                <select class="form-select" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR">
                                <option value="X" selected = "selected" disabled>- Elija una opción -</option>
                                    <option value="S">Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="LPRM_CONSULTAR">Consultar</label>
                                <select class="form-select" id="PRM_CONSULTAR" name="PRM_CONSULTAR">
                                <option value="X" selected = "selected" disabled>- Elija una opción -</option>
                                    <option value="S">Si</option>
                                    <option value="N">No</option>
                                </select>
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

    <table cellspacing="7" cellpadding="7" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <th>Código Rol</th>
            <th>Rol</th>
            <th>Código del Objeto</th>
            <th>Objeto</th>
            <th>Permisos Insertar</th>
            <th>Permisos Actualizar</th>
            <th>Permisos Consultar</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Permisos)
                <tr>
                    <td>{{$Permisos['COD_ROL']}}</td>
                    <td>{{$Permisos['NOM_ROL']}}</td>
                    <td>{{$Permisos['COD_OBJETO']}}</td>
                    <td>{{$Permisos['OBJETO']}}</td>
                    <td>{{$Permisos['PRM_INSERTAR']}}</td>   
                    <td>{{$Permisos['PRM_ACTUALIZAR']}}</td> 
                    <td>{{$Permisos['PRM_CONSULTAR']}}</td>
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
                                <h5 class="modal-title">Actualizar datos del permisos</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar nuevos datos</p>
                                <form action="{{ url('Permisos/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_ROL" value="{{$Permisos['COD_ROL']}}"> 
                                        <input type="hidden" class="form-control" name="COD_OBJETO" value="{{$Permisos['COD_OBJETO']}}">
                                        
                                        <div class="mb-3">
                                            <label for="LPRM_INSERTAR">Insertar</label>
                                            <input type="text" readonly class="form-control" id="PRM_INSERTAR" name="PRM_INSERTAR" value="{{$Permisos['PRM_INSERTAR']}}">
                                            <div class="mb-3">
                                                <select class="form-select" id="PRM_INSERTAR" name="PRM_INSERTAR">
                                                    <option value="X" selected = "selected" disabled>- Elija una opción -</option>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="LPRM_ACTUALIZAR">Actualizar</label>
                                            <input type="text" readonly class="form-control" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR" value="{{$Permisos['PRM_ACTUALIZAR']}}">
                                            <div class="mb-3">
                                                <select class="form-select" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR">
                                                    <option value="X" selected = "selected" disabled>- Elija una opción -</option>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="LPRM_CONSULTAR">Consultar</label>
                                            <input type="text" readonly class="form-control" id="PRM_CONSULTAR" name="PRM_CONSULTAR" value="{{$Permisos['PRM_CONSULTAR']}}">
                                            <div class="mb-3">
                                                <select class="form-select" id="PRM_CONSULTAR" name="PRM_CONSULTAR">
                                                    <option value="X" selected = "selected" disabled>- Elija una opción -</option>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                </select>
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
@stop

@section('css')
   <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
   <script> console.log('Hi!'); </script>
@stop