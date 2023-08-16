@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
            <center>
                <h1>Información de Objetos</h1>
            </center>
            <blockquote class="blockquote text-center">
                <p class="mb-0">Registro de Objetos.</p>
                <footer class="blockquote-footer">Objetos <cite title="Source Title">Registrados</cite></footer>
            </blockquote>

        @section('content')
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Objetos">+ Nuevo</button>
            <div class="modal fade bd-example-modal-sm" id="Objetos" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo objeto</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Objetos/insertar') }}" method="post">
                                @csrf              
                                    <div class="mb-3">
                                        <label for="LOBJETO">Nombre del objeto</label>
                                        <input type="text" id="OBJETO" class="form-control" name="OBJETO" placeholder="Ingresar el nombre del objeto">
                                    </div>
                                    <div class="mb-3">
                                        <label for="LDES_OBJETO">Descripción del objeto</label>
                                        <input type="text" id="DES_OBJETO" class="form-control" name="DES_OBJETO" placeholder="Ingresar la descripción del objeto">
                                    </div>
                                    <div class="mb-3">
                                        <label for="LTIP_OBJETO">Tipo del objeto</label>
                                        <select class="form-select" id="TIP_OBJETO" name="TIP_OBJETO">
                                            <option value=0>- Elija el tipo -</option>
                                            <option value="Primordial">Primordial</option>
                                            <option value="Servicio">Servicio</option>
                                            <option value="Seguridad">Seguridad</option>
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
                    <th>Código</th>
                    <th>Nombre del Objeto</th>
                    <th>Descripción del Objeto</th>
                    <th>Tipo de Objeto</th>
                    <th></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Objetos)
                        <tr>
                            <td>{{$Objetos['COD_OBJETO']}}</td>
                            <td>{{$Objetos['OBJETO']}}</td>   
                            <td>{{$Objetos['DES_OBJETO']}}</td> 
                            <td>{{$Objetos['TIP_OBJETO']}}</td>
                            <td>
                                <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Objetos-edit-{{$Objetos['COD_OBJETO']}}">
                                    <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                                </button>
                                <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Objetos['COD_OBJETO']}})">
                                    <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                                </button>


                            </td>
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-sm" id="Objetos-edit-{{$Objetos['COD_OBJETO']}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Actualizar datos del objetos</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ingresar nuevos datos</p>
                                        <form action="{{ url('Objetos/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_OBJETO" value="{{$Objetos['COD_OBJETO']}}">
                                                
                                                <div class="mb-3">
                                                    <label for="LOBJETO">Nombre del objeto</label>
                                                    <input type="text" class="form-control" id="OBJETO" name="OBJETO" value="{{$Objetos['OBJETO']}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LDES_OBJETO">Descripción del objeto</label>
                                                    <input type="text" class="form-control" id="DES_OBJETO" name="DES_OBJETO" value="{{$Objetos['DES_OBJETO']}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LTIP_OBJETO">Tipo de objeto</label>
                                                    <input type="text" readonly class="form-control" id="TIP_OBJETO" name="TIP_OBJETO" value="{{$Objetos['TIP_OBJETO']}}">
                                                    <select class="form-select" id="TIP_OBJETO" name="TIP_OBJETO">
                                                        <option value=0>- Elija el tipo -</option>
                                                        <option value="Primordial">Primordial</option>
                                                        <option value="Servicio">Servicio</option>
                                                        <option value="Seguridad">Seguridad</option>
                                                    </select>
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
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop