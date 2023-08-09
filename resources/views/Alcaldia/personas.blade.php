@extends('adminlte::page')

@php
    use Carbon\Carbon;
@endphp
@php
    $generos =[
      'M' => 'MASCULINO',
      'F' => 'FEMENINO',
    ];
    $tiposdirecciones =[
      'DO' => 'DOMICILIO',
      'TR' => 'TRABAJO',
    ];
    $tipostelefonos =[
      'FI' => 'FIJO',
      'MO' => 'MOVIL',
    ];
@endphp

@section('title', 'Alcaldia')

<!-- ENCABEZADO -->
@section('content_header')
    <center>
        <h1>Información de Personas</h1>
    </center>
    <br>
        <center>
            <p class="mb-0">REGISTRO DE PERSONAS</p>
            <footer class="blockquote-footer">Personas <cite title="Source Title">Registradas</cite></footer>
        </center>
    </br>
@stop

@section('content')
 <!-- Pantalla para Insertar PERSONAS -->
    <p align="right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Personas">
            <i class='fa fa-user-plus' style='font-size:13px;color:Orange'></i> Nuevo
        </button>   
    </p>
    <div class="modal fade bd-example-modal-sm" id="Personas" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">INGRESAR UNA NUEVA PERSONA</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ingrese los datos solicitados:</p>
                    <form action="{{ url('personas/insertar') }}" method="post">
                        @csrf
                            <div class="mb-3">
                                <label for="DNI_PERSONA">Número de Identidad:</label>
                                <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="NOM_PERSONA">Nombre de la Persona:</label>
                                <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre de la persona">
                            </div>
                            <div class="mb-3">
                                <label for="GEN_PERSONA">Género:</label>
                                <select class="form-select custom-select" id="GEN_PERSONA" name="GEN_PERSONA">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="M">MASCULINO</option>
                                    <option value="F">FEMENINO</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="FEC_NAC_PERSONA">Fecha de Nacimiento:</label>
                                <input type="date" id="FEC_NAC_PERSONA" class="form-control" name="FEC_NAC_PERSONA" placeholder="Seleccione la fecha de nacimiento">
                            </div>
                            <div class="mb-3">
                                <label for="IMG_PERSONA">Imagen de la Persona</label>
                                <input type="file" id="IMG_PERSONA" class="form-control-file custom-file-input" name="IMG_PERSONA" accept="image/*">
                            </div>
                            <style>/*para seleccionar archivos en PERSONAS */
                                .custom-file-input {
                                    width: 500px; /* Ajusta el ancho según tus preferencias */
                                    height: auto; /* Ajusta la altura según tus preferencias */
                                    opacity: 1;
                                }
                            </style>
                             <div class="mb-3">
                                <label for="DES_DIRECCION">Descripción de la Dirección:</label>
                                <input type="text" id="DES_DIRECCION" class="form-control" name="DES_DIRECCION" placeholder="Ingresar la dirección de la persona">
                            </div>
                            <div class="mb-3">
                                <label for="TIP_DIRECCION">Tipo de Dirección:</label>
                                <select class="form-select custom-select" id="TIP_DIRECCION" name="TIP_DIRECCION">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="DO">DOMICILIO</option>
                                    <option value="TR">TRABAJO</option>
                                </select>  
                            </div>                          
                            <div class="mb-3">
                                <label for="DIR_EMAIL">Direccion de Correo Electronico:</label>
                                <input type="text" id="DIR_EMAIL" class="form-control" name="DIR_EMAIL" placeholder="xxxx@gmail.com">
                            </div>
                            <div class="mb-3">
                                <label for="NUM_TELEFONO">Número de Telefono:</label>
                                <input type="text" id="NUM_TELEFONO" class="form-control" name="NUM_TELEFONO" placeholder="0000-0000">
                            </div>
                            <div class="mb-3">
                                <label for="TIP_TELEFONO">Tipo de Telefono:</label>
                                <select class="form-select custom-select" id="TIP_TELEFONO" name="TIP_TELEFONO">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="FI">FIJO</option>
                                    <option value="MO">MOVIL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="DES_TELEFONO">Descripción del Telefono:</label>
                                <input type="text" id="DES_TELEFONO" class="form-control" name="DES_TELEFONO" placeholder="Ingresar una descripción del telefono">
                            </div>
                            <div class="mb-3">
                                <label for="OPE_TELEFONO">Operadora de Telefono:</label>
                                <input type="text" id="OPE_TELEFONO" class="form-control" name="OPE_TELEFONO" placeholder="Ingresar una descripción del telefono">
                            </div>
                            <div class="mb-3">
                                <label for="IND_TELEFONO">Estado:</label>
                                <select class="form-select custom-select" id="IND_TELEFONO" name="IND_TELEFONO">
                                    <option value="" disabled selected>Seleccione una opción</option>    
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
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
<!-- FIN Pantalla para Insertar PERSONAS --> 
<!-- Tabla del Modulo PERSONAS -->
<table cellspacing="7" cellpadding="7" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <th>Código Persona</th>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Género</th>
            <th>Fecha de Nacimiento</th>
            <th>Imagen Persona</th>
            <th>Codigo Dirección</th>
            <th>Descripción Dirección</th>
            <th>Tipo de Dirección</th>
            <th>Codigo Correo</th>
            <th>Dirección Correo</th>
            <th>Codigo Telefono</th>
            <th>Número Telefono</th>
            <th>Tipo Telefono</th>
            <th>Descripción Telefono</th>
            <th>OPE Telefono</th>
            <th>IND Telefono</th>
            <th>Opciones de la Tabla</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($citaArreglo as $personas)
                <tr>
                    <td>{{$personas['COD_PERSONA']}}</td>
                    <td>{{$personas['DNI_PERSONA']}}</td>
                    <td>{{$personas['NOM_PERSONA']}}</td>
                    <td>{{$generos[$personas['GEN_PERSONA']]}}</td>
                    <td>{{ Carbon::parse($personas['FEC_NAC_PERSONA'])->format('Y-m-d') }}</td>
                    <td>{{$personas['IMG_PERSONA']}}</td>
                    <td>{{$personas['COD_DIRECCION']}}</td>   
                    <td>{{$personas['DES_DIRECCION']}}</td>  
                    <td>{{$tiposdirecciones[$personas['TIP_DIRECCION']]}}</td> 
                    <td>{{$personas['COD_EMAIL']}}</td>  
                    <td>{{$personas['DIR_EMAIL']}}</td> 
                    <td>{{$personas['COD_TELEFONO']}}</td>  
                    <td>{{$personas['NUM_TELEFONO']}}</td>  
                    <td>{{$tipostelefonos[$personas['TIP_TELEFONO']]}}</td>  
                    <td>{{$personas['DES_TELEFONO']}}</td>  
                    <td>{{$personas['OPE_TELEFONO']}}</td>  
                    <td>{{$personas['IND_TELEFONO']}}</td>  
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#personas-edit-{{$personas['COD_PERSONA']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>
                    </td>
                </tr>
                <!-- Pantalla para ACTUALIZAR la tabla PERSONAS -->
                <div class="modal fade bd-example-modal-sm" id="personas-edit-{{$personas['COD_PERSONA']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar Datos</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresa los Nuevos Datos</p>
                                <form action="{{ url('personas/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_PERSONA" value="{{$personas['COD_PERSONA']}}">
                                        <div class="mb-3">
                                            <label for="personas">Número de Identidad:</label>
                                            <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" value="{{$personas['DNI_PERSONA']}}">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="personas">Nombre de la Persona:</label>
                                            <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre de la persona" value="{{$personas['NOM_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Género:</label>
                                            <select class="form-select custom-select" id="GEN_PERSONA" name="GEN_PERSONA" value="{{$personas['GEN_PERSONA']}}">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="M">M</option>
                                                <option value="F">F</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Fecha de Nacimiento:</label>
                                            <input type="date" id="FEC_NAC_PERSONA" class="form-control" name="FEC_NAC_PERSONA" placeholder="Seleccione la fecha de nacimiento" value="{{$personas['FEC_NAC_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="IMG_PERSONA">Imagen de la Persona</label>
                                            <input type="file" id="IMG_PERSONA" class="form-control-file custom-file-input" name="IMG_PERSONA" accept="image/*" value="{{$personas['IMG_PERSONA']}}">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="personas" class="form-label">Codigo Dirección:</label>
                                            <input type="text" id="COD_DIRECCION" class="form-control" name="COD_DIRECCION" placeholder="Ingrese el codigo de la dirección" value="{{$personas['COD_DIRECCION']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Descripción de la Dirección:</label>
                                            <input type="text" id="DES_DIRECCION" class="form-control" name="DES_DIRECCION" placeholder="Ingresar la dirección de la persona" value="{{$personas['DES_DIRECCION']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Tipo de Dirección:</label>
                                            <select class="form-select custom-select" id="TIP_DIRECCION" name="TIP_DIRECCION" value="{{$personas['TIP_DIRECCION']}}">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="DO">DO</option>
                                                <option value="TR">TR</option>
                                            </select>  
                                        </div>  
                                        <div class="mb-3 mt-3">
                                            <label for="personas" class="form-label">Codigo Email:</label>
                                            <input type="text" id="COD_EMAIL" class="form-control" name="COD_EMAIL" placeholder="Ingrese el codigo del Correo" value="{{$personas['COD_EMAIL']}}">
                                        </div>                        
                                        <div class="mb-3">
                                            <label for="personas">Direccion de Correo Electronico:</label>
                                            <input type="text" id="DIR_EMAIL" class="form-control" name="DIR_EMAIL" placeholder="xxxx@gmail.com" value="{{$personas['DIR_EMAIL']}}">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="personas" class="form-label">Codigo Teléfono:</label>
                                            <input type="text" id="COD_TELEFONO" class="form-control" name="COD_TELEFONO" placeholder="Ingrese el codigo del teléfono" value="{{$personas['COD_TELEFONO']}}">
                                        </div>   
                                        <div class="mb-3">
                                            <label for="personas">Número de Telefono:</label>
                                            <input type="text" id="NUM_TELEFONO" class="form-control" name="NUM_TELEFONO" placeholder="0000-0000" value="{{$personas['NUM_TELEFONO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Tipo de Telefono:</label>
                                            <select class="form-select custom-select" id="TIP_TELEFONO" name="TIP_TELEFONO" value="{{$personas['TIP_TELEFONO']}}">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="FI">FI</option>
                                                <option value="MO">MO</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Descripción del Telefono:</label>
                                            <input type="text" id="DES_TELEFONO" class="form-control" name="DES_TELEFONO" placeholder="Ingresar una descripción del telefono" value="{{$personas['DES_TELEFONO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Operadora de Telefono:</label>
                                            <input type="text" id="OPE_TELEFONO" class="form-control" name="OPE_TELEFONO" placeholder="Ingresar una descripción del telefono" value="{{$personas['OPE_TELEFONO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="personas">Estado:</label>
                                            <select class="form-select custom-select" id="IND_TELEFONO" name="IND_TELEFONO" value="{{$personas['IND_TELEFONO']}}">
                                                <option value="" disabled selected>Seleccione una opción</option>    
                                                <option value="ACTIVO">ACTIVO</option>
                                                <option value="INACTIVO">INACTIVO</option>
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
<!-- MENSAJE BAJO -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        2023 &copy; SOFTEAM by <a href="">UNAH</a> 
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
<!-- FIN MENSAJE -->
@stop

@section('css')
   <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
   <script> console.log('Hi!'); </script>
@stop
