@extends('adminlte::page')

@section('title', 'Alcaldia')

<!-- confirmDelete -->
@section('js')
    <script>
        function confirmDelete(id) {
            $('#psacrificio-delete-confirm').modal('show');
            $('#delete-form').attr('action', '{{ url("psacrificio/eliminar") }}/' + id);
        }
    </script>
@stop


@section('content_header')

    <center>
        <h1>INFORMACIÓN DE LOS PERMISOS DE SACRIFICIO</h1>
    </center>

    <br>
        <center>
            <p class="mb-0">Permiso de Sacrificio</p>
            <footer class="blockquote-footer">Permisos <cite title="Source Title"> Otorgados</cite></footer>
        </center>
    </br>

@stop

@section('content')
    <p align="right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#psacrificio">+ Nuevo</button>
    </p>
    <div class="modal fade bd-example-modal-sm" id="psacrificio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title">Ingresa un Nuevo Permiso de Sacrificio</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                   
                </div>
                <div class="modal-body">
                    <p>Ingresar Datos Solicitados:</p>
                    <form action="{{ url('psacrificio/insertar') }}" method="post">
                        @csrf
                            
                            <div class="mb-3 mt-3">
                                <label for="NOM_PERSONA">Nombre de la Persona</label>
                                <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre de la persona">
                            </div>
                       
                            <div class="mb-3">
                                <label for="DNI_PERSONA">Numero de Identidad</label>
                                <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="Ingresar el numero de identidad">
                            </div>
                            <div class="mb-3">
                                <label for="TEL_PERSONA">Numero de Telefono</label>
                                <input type="text" id="TEL_PERSONA" class="form-control" name="TEL_PERSONA" placeholder="Ingresar el numero de telefono">
                            </div>
                            <div class="mb-3">
                                <label for="FEC_SACRIFICIO">Fecha del Sacrificio</label>
                                <input type="date" id="FEC_SACRIFICIO" class="form-control" name="FEC_SACRIFICIO" placeholder="Inserte la fecha del sacrificio">
                            </div>
                            <div class="mb-3">
                                <label for="COD_ANIMAL">Codigo del Animal</label>
                                <input type="text" id="COD_ANIMAL" class="form-control" name="COD_ANIMAL" placeholder="Inserte el codigo del animal">
                            </div>
                            <div class="mb-3">
                                <label for="DIR_PSACRIFICIO">Direccion del Sacrificio</label>
                                <input type="text" id="DIR_PSACRIFICIO" class="form-control" name="DIR_PSACRIFICIO" placeholder="Ingresar la direccion del sacrificio">
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

    <table cellspacing="8" cellpadding="8" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" >
        <thead>
            <th>Nº</th>
            <th>Nombre</th>
            <th>Numero de Identidad</th>
            <th>Telefono</th>
            
            <th>Fecha del Sacrificio</th>
            <th>Direccion del Sacrificio</th>
            <th>Registro del Animal</th>
            <th>Opciones de la Tabla</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $psacrificio)
                <tr>
                    <td>{{$psacrificio['COD_PSACRIFICIO']}}</td>  
                    <td>{{$psacrificio['NOM_PERSONA']}}</td> 
                    <td>{{$psacrificio['DNI_PERSONA']}}</td>
                    <td>{{$psacrificio['TEL_PERSONA']}}</td>
                    
                    <td>{{$psacrificio['FEC_SACRIFICIO']}}</td>
                    <td>{{$psacrificio['DIR_PSACRIFICIO']}}</td>
                    <td>{{$psacrificio['COD_ANIMAL']}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$psacrificio['COD_PSACRIFICIO']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar Datos</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresa los Nuevos Datos</p>
                                <form action="{{ url('psacrificio/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_PSACRIFICIO" value="{{$psacrificio['COD_PSACRIFICIO']}}">
                                        
                                        <div class="mb-3 mt-3">
                                            <label for="psacrificio" class="form-label">Nombre de la Persona</label>
                                            <input type="text" class="form-control" id="NOM_PERSONA" name="NOM_PERSONA" placeholder="Ingrese el nombre de la persona" value="{{$psacrificio['NOM_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Numero de Identidad</label>
                                            <input type="text" class="form-control" id="DNI_PERSONA" name="DNI_PERSONA" placeholder="Ingrese el numero de identidad" value="{{$psacrificio['DNI_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Numero de Telefono</label>
                                            <input type="text" class="form-control" id="TEL_PERSONA" name="TEL_PERSONA" placeholder="Ingrese el numero de telefono" value="{{$psacrificio['TEL_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Fecha de Sacrificio</label>
                                            <input type="date" class="form-control" id="FEC_SACRIFICIO" name="FEC_SACRIFICIO" placeholder="Ingrese la fecha del sacrificio" value="{{$psacrificio['FEC_SACRIFICIO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Codigo del Animal</label>
                                            <input type="text" class="form-control" id="COD_ANIMAL" name="COD_ANIMAL" placeholder="Ingrese el codigo del animal" value="{{$psacrificio['COD_ANIMAL']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Direccion del Sacrificio</label>
                                            <input type="text" class="form-control" id="DIR_PSACRIFICIOL" name="DIR_PSACRIFICIO" placeholder="Ingrese la direccion del sacrificio" value="{{$psacrificio['DIR_PSACRIFICIO']}}">
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

                <!-- Modal Eliminar -->
                <div class="modal fade" id="psacrificio-delete-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar este registro?
                                </div>
                                    <div class="modal-footer">
                                        <form id="delete-form" method="post">
                                            @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

