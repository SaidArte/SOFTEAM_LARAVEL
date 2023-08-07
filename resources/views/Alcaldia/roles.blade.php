@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Información de Roles</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Roles.</p>
        <footer class="blockquote-footer">Roles <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Roles">+ Nuevo</button>
    <div class="modal fade bd-example-modal-sm" id="Roles" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar un nuevo rol</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Favor, ingrese los datos solicitados:</p>
                    <form action="{{ url('Roles/insertar') }}" method="post">
                        @csrf
                            
                            <div class="mb-3 mt-3">
                                <label for="LNOM_ROL">Rol</label>
                                <input type="text" id="NOM_ROL" class="form-control" name="NOM_ROL" placeholder="Ingresar el nombre del rol">
                            </div>
                            <div class="mb-3">
                                <label for="LDES_ROL">Descripción del rol</label>
                                <input type="text" id="DES_ROL" class="form-control" name="DES_ROL" placeholder="Ingrese la descripción del rol">
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
            <th>Nombre del Rol</th>
            <th>Descripción</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Roles)
                <tr>
                    <td>{{$Roles['COD_ROL']}}</td>
                    <td>{{$Roles['NOM_ROL']}}</td>   
                    <td>{{$Roles['DES_ROL']}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Roles-edit-{{$Roles['COD_ROL']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Roles['COD_ROL']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="Roles-edit-{{$Roles['COD_ROL']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar datos del rol</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar nuevos datos</p>
                                <form action="{{ url('Roles/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_ROL" value="{{$Roles['COD_ROL']}}">
                                        
                                        <div class="mb-3 mt-3">
                                            <label for="LNOM_ROL" class="form-label">Rol</label>
                                            <input type="text" class="form-control" id="NOM_ROL" name="NOM_ROL" value="{{$Roles['NOM_ROL']}}">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="LDES_ROL" class="form-label">Descripción del rol</label>
                                            <input type="text" class="form-control" id="DES_ROL" name="DES_ROL" value="{{$Roles['DES_ROL']}}">
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


