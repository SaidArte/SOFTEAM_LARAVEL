@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Información de Usuarios</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Usuarios.</p>
        <footer class="blockquote-footer">Usuarios <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Usuarios">+ Nuevo</button>
    <div class="modal fade bd-example-modal-sm" id="Usuarios" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar un nuevo usuario</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Favor, ingrese los datos solicitados:</p>
                    <form action="{{ url('Usuarios/insertar') }}" method="post">
                        @csrf
                            
                            <div class="mb-3 mt-3">
                                <label for="NOM_ROL">Rol</label>
                                <select class="form-select" id="NOM_ROL" name="NOM_ROL">
                                    <option value="X">- Elija el rol -</option>
                                    <option value="Adminstrador">Adminstrador</option>
                                    <option value="Usuario">Usuario</option>
                                    <option value="Secretario">Secretario</option>
                                </select>
                            </div>
                       
                            <div class="mb-3">
                                <label for="COD_PERSONA">Código de la persona</label>
                                <input type="text" id="COD_PERSONA" class="form-control" name="COD_PERSONA" placeholder="Ingresar el código de la persona">
                            </div>
                            <div class="mb-3">
                                <label for="PAS_USUARIO">Contraseña</label>
                                <input type="password" id="PAS_USUARIO" class="form-control" name="PAS_USUARIO" placeholder="Ingresar una contraseña">
                            </div>
                            <div class="mb-3">
                                <label for="IND_USUARIO">Estado del usuario</label>
                                <select class="form-select" id="IND_USUARIO" name="IND_USUARIO">
                                    <option value="X">- Elija un estado -</option>
                                    <option value="ACTIVO">Activo</option>
                                    <option value="INACTIVO">Inactivo</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="LIM_INTENTOS">Intentos permitidos (Login)</label>
                                <input type="text" id="LIM_INTENTOS" class="form-control" name="LIM_INTENTOS" placeholder="Ingrese el número de intentos permitidos">
                            </div>
                            <div class="mb-3">
                                <label for="NUM_INTENTOS_FALLIDOS">Intentos fallidos</label>
                                <input type="text" id="NUM_INTENTOS_FALLIDOS" class="form-control" name="NUM_INTENTOS_FALLIDOS" placeholder="Ingresar el número de intentos fallidos">
                            </div>
                            <div class="mb-3">
                                <label for="FEC_VENCIMIENTO">Fecha de Vencimiento de contraseña</label>
                                <input type="date" id="FEC_VENCIMIENTO" class="form-control" name="FEC_VENCIMIENTO" placeholder="Ingrese la fecha de vencimiento.">
                            </div>
                            <div class="mb-3">
                                <label for="PREGUNTA">Pregunta de seguridad</label>
                                <select class="form-select" id="PREGUNTA" name="PREGUNTA">
                                    <option value="X">- Elija una pregunta -</option>
                                    <option value="¿Nombre de su primer mascota?">¿Nombre de su primer mascota?</option>
                                    <option value="¿Nombre primer pareja?">¿Nombre primer pareja?</option>
                                    <option value="¿Ciudad donde nacio?">¿Ciudad donde nacio?</option>
                                    <option value="¿Ciudad donde vivio su adolecencia?">¿Ciudad donde vivio su adolecencia?</option>
                                    <option value="¿Cuál es el nombre de su madre?">¿Cuál es el nombre de su madre?</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="RESPUESTA">Respuesta</label>
                                <input type="text" id="RESPUESTA" class="form-control" name="RESPUESTA" placeholder="Ingrese la respuesta a la pregunta elejida">
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
            <th>Código</th>
            <th>Nombre</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Ultimo Cambio</th>
            <th>Ultimo Acceso</th>
            <th>Límite de Intentos</th>
            <th>Intentos Fallidos</th>
            <th>Vencimiento de contraseña</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Usuarios)
                <tr>
                    <td>{{$Usuarios['COD_USUARIO']}}</td>
                    <td>{{$Usuarios['NOM_PERSONA']}}</td>   
                    <td>{{$Usuarios['NOM_ROL']}}</td> 
                    <td>{{$Usuarios['IND_USUARIO']}}</td>
                    <td>{{date('d-m-y', strtotime($Usuarios['FEC_ULTIMO_CAMBIO']))}}</td>
                    <td>{{date('d-m-y', strtotime($Usuarios['FEC_ULTIMO_ACCESO']))}}</td>
                    <td>{{$Usuarios['LIM_INTENTOS']}}</td>
                    <td>{{$Usuarios['NUM_INTENTOS_FALLIDOS']}}</td>
                    <td>{{date('d-m-y', strtotime($Usuarios['FEC_VENCIMIENTO']))}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Usuarios-edit-{{$Usuarios['COD_USUARIO']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Usuarios['COD_USUARIO']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="Usuarios-edit-{{$Usuarios['COD_USUARIO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar datos del usuario</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar nuevos datos</p>
                                <form action="{{ url('Usuarios/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_USUARIO" value="{{$Usuarios['COD_USUARIO']}}">
                                        
                                        <div class="mb-3 mt-3">
                                            <label for="Usuarios" class="form-label">Rol</label>
                                            <input type="text" readonly class="form-control" id="NOM_ROL" name="NOM_ROL" value="{{$Usuarios['NOM_ROL']}}">
                                            <select class="form-select" id="NOM_ROL" name="NOM_ROL">
                                                <option value="X">- Elija el rol -</option>
                                                <option value="Adminstrador">Adminstrador</option>
                                                <option value="Usuario">Usuario</option>
                                                <option value="Secretario">Secretario</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="Usuarios" class="form-label">Estado del usuario</label>
                                            <input type="text" readonly class="form-control" id="IND_USUARIO" name="IND_USUARIO" value="{{$Usuarios['IND_USUARIO']}}">
                                            <select class="form-select" id="IND_USUARIO" name="IND_USUARIO">
                                                <option value="X">- Elija un estado -</option>
                                                <option value="ACTIVO">Activo</option>
                                                <option value="INACTIVO">Inactivo</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Usuarios">Fecha de ultimo cambio</label>
                                            <input type="text" readonly class="form-control" id="FEC_ULTIMO_CAMBIO" name="FEC_ULTIMO_CAMBIO" value="{{date('d-m-y', strtotime($Usuarios['FEC_ULTIMO_CAMBIO']))}}">
                                            <input type="date" class="form-control" id="FEC_ULTIMO_CAMBIO" name="FEC_ULTIMO_CAMBIO" value="{{$Usuarios['FEC_ULTIMO_CAMBIO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuarios">Fecha de ultimo acceso</label>
                                            <input type="text" readonly class="form-control" id="FEC_ULTIMO_ACCESO" name="FEC_ULTIMO_ACCESO" value="{{date('d-m-y', strtotime($Usuarios['FEC_ULTIMO_ACCESO']))}}">
                                            <input type="date" class="form-control" id="FEC_ULTIMO_ACCESO" name="FEC_ULTIMO_ACCESO" value="{{$Usuarios['FEC_ULTIMO_ACCESO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="Usuarios">Intentos permitidos (Login)</label>
                                            <input type="text" class="form-control" id="LIM_INTENTOS" name="LIM_INTENTOS" placeholder="Ingrese los intentos permitidos" value="{{$Usuarios['LIM_INTENTOS']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="Usuarios">Intentos fallidos</label>
                                            <input type="text" class="form-control" id="NUM_INTENTOS_FALLIDOS" name="NUM_INTENTOS_FALLIDOS" placeholder="Ingrese los intentos fallidos" value="{{$Usuarios['NUM_INTENTOS_FALLIDOS']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="Usuarios">Fecha de vencimiento de contraseña</label>
                                            <input type="text" readonly class="form-control" id="FEC_VENCIMIENTO" name="FEC_VENCIMIENTO" value="{{date('d-m-y', strtotime($Usuarios['FEC_VENCIMIENTO']))}}">
                                            <input type="date" class="form-control" id="FEC_VENCIMIENTO" name="FEC_VENCIMIENTO" value="{{$Usuarios['FEC_VENCIMIENTO']}}">
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

