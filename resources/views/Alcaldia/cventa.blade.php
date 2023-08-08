@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    <center>
        <h1>Información de Expedientes Cartas De Ventas</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Expediente Cartas De Ventas.</p>
        <footer class="blockquote-footer">Expedientes_Cventas <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Cventa">+ Nuevo</button>
    <div class="modal fade bd-example-modal-sm" id="Cventa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar un nuevo Expedientes_Cventas</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Favor, ingrese los datos solicitados:</p>
                    <form action="{{ url('Cventa/insertar') }}" method="post">
                        @csrf
                       
                        <div class="mb-3 mt-3">
                            <label for="COD_CVENTA">Codigo venta</label>
                            <input type="text" id="COD_CVENTA" class="form-control" name="COD_CVENTA" placeholder="Ingrese el codigo carta de venta">
                        </div>
    
                        <div class="mb-3 mt-3">
                            <label for="COD_VENDEDOR">Codigo vendedor</label>
                            <input type="text" id="COD_VENDEDOR" class="form-control" name="COD_VENDEDOR" placeholder="Ingrese el codigo del vendedor">
                        </div>
                        
                        <div class="mb-3 mt-3">
                            <label for="COD_COMPRADOR">Codigo comprador</label>
                            <input type="text" id="COD_COMPRADOR" class="form-control" name="COD_COMPRADOR" placeholder="Ingrese el codigo del comprador">
                        </div>
    
                        <div class="mb-3 mt-3">
                            <label for="COD_ANIMAL">Codigo Animal</label>
                            <input type="text" id="COD_ANIMAL" class="form-control" name="COD_ANIMAL" placeholder="Ingrese el codigo del animal">
                        </div>
    
                        <div class="mb-3 mt-3">
                            <label for="FOL_CVENTA" class="form-label">Folio de carta venta</label>
                            <input type="text" class="form-control" id="FOL_CVENTA" name="FOL_CVENTA" placeholder="Ingrese numero de folio">
                        </div>
    
                        <div class="mb-3 mt-3">
                            <label for="ANT_CVENTA" class="form-label">Antecedentes de carta venta</label>
                            <select class="form-select " id="ANT_CVENTA" name="ANT_CVENTA" >
                                <option value="SI" selected >SI</option>
                                <option value="NO" selected >NO</option>
                               
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
            <th>Código Cventas</th>
            <th>Fecha Venta</th>
            <th>Código Vendedor</th>
            <th>Código Comprador</th>
            <th>Código Animal </th>
            <th>Folio cventas</th>
            <th>Antecedentes Cventas </th>
          
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Cventa)
                <tr>
                    <td>{{$Cventa['COD_CVENTA']}}</td>
                    <td>{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}</td>
                    <td>{{$Cventa['COD_VENDEDOR']}}</td>   
                    <td>{{$Cventa['COD_COMPRADOR']}}</td> 
                    <td>{{$Cventa['COD_ANIMAL']}}</td>
                    <td>{{$Cventa['FOL_CVENTA']}}</td> 
                    <td>{{$Cventa['ANT_CVENTA']}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Cventa-edit-{{$Cventa['COD_CVENTA']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Cventa['COD_CVENTA']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="Cventa-edit-{{$Cventa['COD_CVENTA']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar datos de cartas Ventas</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar nuevos datos</p>
                                <form action="{{ url('Cventa/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_CVENTA" value="{{$Cventa['COD_CVENTA']}}">

                                        <div class="mb-3">
                                            <label for="Cventa">Fecha  Registro Cventa</label>
                                            <input type="text" readonly class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}">
                                            <input type="date" class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{$Cventa['FEC_CVENTA']}}">
                            
                                        </div>

                                        <div class="mb-3">
                                            <label for="Cventa">Codigo Vendedor</label>
                                            <input type="text" class="form-control" id="COD_VENDEDOR" name="COD_VENDEDOR" placeholder=" Ingrese el codigo del vendedor  " value="{{$Cventa['COD_VENDEDOR']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="Cventa">codigo Comprador</label>
                                            <input type="text" class="form-control" id="COD_COMPRADOR" name="COD_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$Cventa['COD_COMPRADOR']}}">
                                        </div>


                                        <div class="mb-3">
                                            <label for="Cventa">Codigo Animal</label>
                                            <input type="text" class="form-control" id="COD_ANIMAL" name="COD_ANIMAL" placeholder=" Ingrese el codigo del animal  " value="{{$Cventa['COD_ANIMAL']}}">
                                        </div>


                                        <div class="mb-3">
                                            <label for="Cventa">Folio de Carta De Venta</label>
                                            <input type="text" class="form-control" id="FOL_CVENTA" name="FOL_CVENTA" placeholder=" Ingrese el numero de folio  " value="{{$Cventa['FOL_CVENTA']}}">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="Cventa" class="form-label">Antecedentes Carta De Venta</label>
                                            <input type="text" readonly class="form-control" id="ANT_CVENTA" name="ANT_CVENTA" value="{{$Cventa['ANT_CVENTA']}}">
                                            <select class="form-select" id="ANT_CVENTA" name="ANT_CVENTA">
                                                <option value="SI" selected >SI</option>
                                                <option value="NO" selected >NO</option>
                                                
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