@extends('adminlte::page')
@php
    $tiposFierro = [
        'L' => 'Letra',
        'F' => 'Figura',
        'N' => 'Numero',
        'S' => 'Simbolo',
    ];
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Informacion de Fierro</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de fierro.</p>
        <footer class="blockquote-footer">Fierro <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
<p align="right">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#fierro">+ Nuevo</button>
</p>

    <div class="modal fade bd-example-modal-sm" id="fierro" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresa un Nuevo Fierro</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ingrese los Datos:</p>
                    <form action="{{ url('fierro/insertar') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-3">
                            <label for="COD_PERSONA">Codigo de Persona</label>
                            <input type="text" id="COD_PERSONA" class="form-control" name="COD_PERSONA" placeholder="Ingrese el codigo del dueño del fierro">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="FEC_TRAMITE_FIERRO">Fecha de Tramite</label>
                            <input type="date" id="FEC_TRAMITE_FIERRO" class="form-control" name="FEC_TRAMITE_FIERRO" placeholder="inserte la fecha de tramite.">
                        </div>
                        <div class="mb-3">
                            <label for="NUM_FOLIO_FIERRO">Numero de Folio</label>
                            <input type="text" id="NUM_FOLIO_FIERRO" class="form-control" name="NUM_FOLIO_FIERRO" placeholder="Ingrese el numero de folio del fierro">
                        </div>
                        <div class="mb-3">
                            <label for="TIP_FIERRO" class="form-label">Tipo de Fierro</label>
                            <select class="form-select" id="TIP_FIERRO" name="TIP_FIERRO">
                                <option value="L">Letra</option>
                                <option value="F">Figura</option>
                                <option value="N">Numero</option>
                                <option value="S">Simbolo</option>
                            </select>
                        </div>
                         
                        <div class="mb-3">
                            <label for="MON_CERTIFICO_FIERRO">Monto del Certifico</label>
                            <input type="text" id="MON_CERTIFICO_FIERRO" class="form-control" name="MON_CERTIFICO_FIERRO" placeholder="Ingrese el monto del certifico">
                        </div> 

                        
                    <!--  <div class="mb-3">
                            <label for="IMG_FIERRO">Imagen del Fierro</label>
                            <input type="text" id="IMG_FIERRO" class="form-control" name="IMG_FIERRO" placeholder="Ingrese la imagen del fierro">
                        </div> -->
                        
 <div class="card">
    <div class="col">
        <label for="IMG_FIERRO">Subir Imagen del Fierro</label>
        <form action="{{ url('fierro/insertar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="file" id="" accept="image/*">
            </div>
           </form>
           <button type="submit" class="btn btn-primary">Guardar</button>
           <button type="reset" class="btn btn-danger">Cancelar</button>
    </div>
</div>
                   <!--      <p align="right">
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Registrar</button>
                            <button class="btn btn-danger" type="reset">Cancelar</button>
                        
                        </div>
                        </p>-->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table cellspacing="7" cellpadding="7" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <th> N°</th>
            <th>Dueño Fierro</th>
            <th>Fecha Tramite</th>
            <th>Numero Folio</th>
            <th>Tipo Fierro</th>
            <th>Monto Certifico</th>
            <th>Img Fierro</th>
            <th>Opciones de la Tabla</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $fierro)
            
                <tr>
                     <td>{{$fierro['COD_FIERRO']}}</td>
                    <td>{{$fierro['NOM_PERSONA']}}</td>
                    <td>{{date('d-m-Y', strtotime($fierro['FEC_TRAMITE_FIERRO']))}}</td>   
                    <td>{{$fierro['NUM_FOLIO_FIERRO']}}</td>
                    <td>{{ $tiposFierro[$fierro['TIP_FIERRO']] }}</td>
                    <td>{{$fierro['MON_CERTIFICO_FIERRO']}}</td>
                    <td> <img src="{{ $fierro['IMG_FIERRO'] }}" alt="Imagen del Fierro" style="max-height: 100px;"></td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#fierro-edit-{{$fierro['COD_FIERRO']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="fierro-edit-{{$fierro['COD_FIERRO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualiza Datos del Fierro</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresa los Nuevos Datos</p>
                                <form action="{{ url('fierro/actualizar') }}" method="post">
                                    @csrf
                                    <input type="hidden" class="form-control" name="COD_FIERRO" value="{{$fierro['COD_FIERRO']}}">
                                    <div class="mb-3 mt-3">
                                        <label for="fierro" class="form-label">Codigo de Persona</label>
                                        <input type="text" class="form-control" id="COD_PERSONA" name="COD_PERSONA" placeholder="Ingrese el codigo del dueño del fierro" value="{{$fierro['COD_PERSONA']}}">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="fierro" class="form-label">Fecha de Tramite</label>
                                        <input type="date" class="form-control" id="FEC_TRAMITE_FIERRO" name="FEC_TRAMITE_FIERRO" placeholder="Ingrese la Fecha de Tramite" value="{{$fierro['FEC_TRAMITE_FIERRO']}}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fierro">Numero de Folio</label>
                                        <input type="text" class="form-control" id="NUM_FOLIO_FIERRO" name="NUM_FOLIO_FIERRO" placeholder="Ingrese el numero de folio del fierro" value="{{$fierro['NUM_FOLIO_FIERRO']}}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="fierro" class="form-label">Tipo de Fierro</label>
                                        <select class="form-select" id="TIP_FIERRO" name="TIP_FIERRO">
                                            <option value="L" {{ $fierro['TIP_FIERRO'] === 'L' ? 'selected' : '' }}>Letra</option>
                                            <option value="F" {{ $fierro['TIP_FIERRO'] === 'F' ? 'selected' : '' }}>Figura</option>
                                            <option value="N" {{ $fierro['TIP_FIERRO'] === 'N' ? 'selected' : '' }}>Numero</option>
                                            <option value="S" {{ $fierro['TIP_FIERRO'] === 'S' ? 'selected' : '' }}>Simbolo</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fierro">Monto del Certifico</label>
                                        <input type="text" class="form-control" id="MON_CERTIFICO_FIERRO" name="MON_CERTIFICO_FIERRO" placeholder="Ingrese el Monto del Certifico" value="{{$fierro['MON_CERTIFICO_FIERRO']}}">
                                    </div>
                                
                                     <!-- <div class="mb-3">
                                        <label for="fierro">Imagen del Fierro</label>
                                        <input type="text" class="form-control" id="IMG_FIERRO" name="IMG_FIERRO" placeholder="Ingrese la imagen del fierro" value="{{$fierro['IMG_FIERRO']}}">
                                    </div> -->
                                    <div class="card">
                        <div class="col">
                        <label for="IMG_FIERRO">Subir Imagen del Fierro</label>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                          <div class= "form-group">
                                         <input type="file" name="file" id="" accept= "image/*">
                                         </div>
                                           </form>

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

