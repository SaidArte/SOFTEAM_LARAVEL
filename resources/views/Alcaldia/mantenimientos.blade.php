@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Información de Mantenimientos</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Mantenimientos.</p>
        <footer class="blockquote-footer">Mantenimientos <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Mantenimientos">+ Nuevo</button>
    <div class="modal fade bd-example-modal-sm" id="Mantenimientos" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar un nuevo mantenimiento</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Favor, ingrese los datos solicitados:</p>
                    <form action="{{ url('Mantenimientos/insertar') }}" method="post">
                        @csrf
                            
                            <div class="mb-3">
                                <label for="LFEC_HR_MANTENIMIENTO">Fecha y hora de mantenimiento</label>
                                <input type="datetime-local" id="FEC_HR_MANTENIMIENTO" class="form-control" name="FEC_HR_MANTENIMIENTO">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="LTIP_MANTENIMIENTO">Tipo de Mantenimiento</label>
                                <select class="form-select" id="TIP_MANTENIMIENTO" name="TIP_MANTENIMIENTO">
                                    <option value="X" selected = "selected" disabled>- Elija el tipo -</option>
                                    <option value="Mantenimiento predictivo">Mantenimiento predictivo</option>
                                    <option value="Mantenimiento preventivo">Mantenimiento preventivo</option>
                                    <option value="Mantenimiento correctivo">Mantenimiento correctivo</option>
                                    <option value="Mantenimiento evolutivo">Mantenimiento evolutivo</option>
                                </select>
                            </div>
                       
                            <div class="mb-3">
                                <label for="LDES_MANTENIMIENTO">Descripción del Mantenimiento</label>
                                <input type="text" id="DES_MANTENIMIENTO" class="form-control" name="DES_MANTENIMIENTO" placeholder="Ingresar la descripción del mantenimiento">
                            </div>
                            <div class="mb-3">
                                <label for="LCOD_USUARIO">Código de Usuario</label>
                                <input type="text" id="COD_USUARIO" class="form-control" name="COD_USUARIO" placeholder="Ingresar el código de usuario">
                            </div>
                            <div class="mb-3">
                                <label for="LMON_MANTENIMIENTO">Monto del Mantenimiento</label>
                                <input type="number" prefix="L. " id="MON_MANTENIMIENTO" class="form-control" name="MON_MANTENIMIENTO" placeholder="Ingrese el costo del mantenimiento" min="1" step="any">
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
            <th>Código de Mantenimiento</th>
            <th>Fecha de Registro Mantenimiento</th>
            <th>Fecha y hora Mantenimiento</th>
            <th>Tipo de Mantenimiento</th>
            <th>Descripción Mantenimiento</th>
            <th>Código de Usuario</th>
            <th>Nombre de Usuario</th>
            <th>Monto Mantenimiento</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Mantenimientos)
                <tr>
                    <td>{{$Mantenimientos['COD_MANTENIMIENTO']}}</td>
                    <td>{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_REG_MANTENIMIENTO']))}}</td>   
                    <td>{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_HR_MANTENIMIENTO']))}}</td> 
                    <td>{{$Mantenimientos['TIP_MANTENIMIENTO']}}</td>
                    <td>{{$Mantenimientos['DES_MANTENIMIENTO']}}</td>
                    <td>{{$Mantenimientos['COD_USUARIO']}}</td>
                    <td>{{$Mantenimientos['NOMBRE_USUARIO']}}</td>
                    <td>{{$Mantenimientos['MON_MANTENIMIENTO']}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Mantenimientos-edit-{{$Mantenimientos['COD_MANTENIMIENTO']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Mantenimientos['COD_MANTENIMIENTO']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="Mantenimientos-edit-{{$Mantenimientos['COD_MANTENIMIENTO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar datos del mantenimiento</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar nuevos datos</p>
                                <form action="{{ url('Mantenimientos/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_MANTENIMIENTO" value="{{$Mantenimientos['COD_MANTENIMIENTO']}}">
                                        
                                        <div class="mb-3">
                                            <label for="Mantenimientos">Fecha y hora de mantenimiento</label>
                                            <input type="text" readonly class="form-control" id="FEC_HR_MANTENIMIENTO" name="FEC_HR_MANTENIMIENTO" value="{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_HR_MANTENIMIENTO']))}}">
                                            <input type="datetime-local" class="form-control" id="FEC_HR_MANTENIMIENTO" name="FEC_HR_MANTENIMIENTO" value="{{$Mantenimientos['FEC_HR_MANTENIMIENTO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="LTIP_MANTENIMIENTO">Tipo de Mantenimiento</label>
                                            <input type="text" readonly class="form-control" id="TIP_MANTENIMIENTO" name="TIP_MANTENIMIENTO" value="{{$Mantenimientos['TIP_MANTENIMIENTO']}}">
                                            <select class="form-select" id="TIP_MANTENIMIENTO" name="TIP_MANTENIMIENTO">
                                                <option value="X" selected = "selected" disabled>- Elija el tipo -</option>
                                                <option value="Mantenimiento predictivo">Mantenimiento predictivo</option>
                                                <option value="Mantenimiento preventivo">Mantenimiento preventivo</option>
                                                <option value="Mantenimiento correctivo">Mantenimiento correctivo</option>
                                                <option value="Mantenimiento evolutivo">Mantenimiento evolutivo</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="LDES_MANTENIMIENTO">Descripción del Mantenimiento</label>
                                            <input type="text" class="form-control" id="DES_MANTENIMIENTO" name="DES_MANTENIMIENTO" value="{{$Mantenimientos['DES_MANTENIMIENTO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="LCOD_USUARIO">Código de Usuario</label>
                                            <input type="text" class="form-control" id="COD_USUARIO" name="COD_USUARIO" value="{{$Mantenimientos['COD_USUARIO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="LMON_MANTENIMIENTO">Monto del Mantenimiento</label>
                                            <input type="number" prefix="L. " class="form-control" id="MON_MANTENIMIENTO" name="MON_MANTENIMIENTO" value="{{$Mantenimientos['MON_MANTENIMIENTO']}}" min="1" step="any">
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

