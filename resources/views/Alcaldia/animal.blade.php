@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')
@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Agrega la clase CSS personalizada aquí -->
    <style>
        /* CSS personalizado */
        .custom-delete-button:hover .fas.fa-trash-alt {
            color: white !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop
@section('content_header')
    <center>
        <h1>Información de Animales</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Animales.</p>
        <footer class="blockquote-footer">Animales <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
<p align="right">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Animal">+ Nuevo</button>
</p>
    
    <div class="modal fade bd-example-modal-sm" id="Animal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar un nuevo Animal</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Favor, ingrese los datos solicitados:</p>
                    <form action="{{ url('Animal/insertar') }}" method="post">
                        @csrf
                       
                        <div class="mb-3 mt-3">
                            <label for="COD_ANIMAL">Codigo Animal</label>
                            <input type="text" id="COD_ANIMAL" class="form-control" name="COD_ANIMAL" placeholder="Ingrese el codigo animal">
                        </div>-->
                        <!--
                        <div class="mb-3 mt-3">
                            <label for="FEC_REG_ANIMAL">Fecha de Resgistro</label>
                            <input type="date" id="FEC_REG_ANIMAL" class="form-control" name="FEC_REG_ANIMAL" placeholder="Ingrese la fecha">
                        </div>
                    -->
                        <div class="mb-3 mt-3">
                            <label for="CLAS_ANIMAL">Clase del Animal</label>
                            <input type="text" id="CLAS_ANIMAL" class="form-control" name="CLAS_ANIMAL" placeholder="Ingrese la clase de animal">
                        </div>
    
                        <div class="mb-3 mt-3">
                            <label for="RAZ_ANIMAL">Raza del Animal</label>
                            <input type="text" id="RAZ_ANIMAL" class="form-control" name="RAZ_ANIMAL" placeholder="Ingrese raza del animal">
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="COL_ANIMAL">color del Animal</label>
                            <input type="text" id="COL_ANIMAL" class="form-control" name="COL_ANIMAL" placeholder="Ingrese color del animal">
                        </div>

                        <div class="mb-3">
                            <label for="COD_FIERRO">Código Fierro</label>
                            <input type="text" id="COD_FIERRO" class="form-control" name="COD_FIERRO" placeholder="Ingresar el código de la Fierro">
                        </div>

                       

                
                        <div class="mb-3 mt-3">
                            <label for="VEN_ANIMAL" >Venteado Animal</label>
                            <select class="form-select custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" >
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="S" selected >SI</option>
                                <option value="N" selected >NO</option>
                               
                            </select>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="HER_ANIMAL">Herrado Animal</label>
                            <select class="form-select custom-select" id="HER_ANIMAL" name="HER_ANIMAL" >
                                <option value="" disabled selected>Seleccione una opción</option>

                                <option value="S" selected >SI</option>
                                <option value="N" selected >NO</option>
                               
                            </select>
                        </div>
    
                
                        
                        
                        <div class="mb-3 mt-3">
                            <label for="DET_ANIMAL">Detalle del Animal</label>
                            <input type="text" id="DET_ANIMAL" class="form-control" name="DET_ANIMAL" placeholder="Ingrese detalle del animal">
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

    <table cellspacing="9" cellpadding="9" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;" " id="modAnimal" >
        <thead>
            <th>Código Animal</th>
            <th>Fecha registro</th>
            <th>Clase Animal</th>
            <th>Raza Animal</th>
            <th>color Animal</th>
            <th>Código Fierro </th>
            <th>Venteado Animal</th>
            <th>Herrado Animal</th>
            <th>Detalle Animal</th>
            
          
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $Animal)
                <tr>
                    <td>{{$Animal['COD_ANIMAL']}}</td>
                    <td>{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}</td>
                    <td>{{$Animal['CLAS_ANIMAL']}}</td>   
                    <td>{{$Animal['RAZ_ANIMAL']}}</td> 
                    <td>{{$Animal['COL_ANIMAL']}}</td>
                    <td>{{$Animal['COD_FIERRO']}}</td> 
                    <td>{{$Animal['VEN_ANIMAL']}}</td>
                    <td>{{$Animal['HER_ANIMAL']}}</td>
                    <td>{{$Animal['DET_ANIMAL']}}</td>


                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Animal-edit-{{$Animal['COD_ANIMAL']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Animal['COD_ANIMAL']}})">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>


                    </td>

                   
                </tr>
                 <!-- Modal for editing goes here -->
                 <div class="modal fade bd-example-modal-sm" id="Animal-edit-{{$Animal['COD_ANIMAL']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar Datos De Animales</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresar Nuevos Datos</p>
                                <form action="{{ url('Animal/actualizar') }}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_ANIMAL" value="{{$Animal['COD_ANIMAL']}}">
                                         <!--
                                        <div class="mb-3">
                                            <label for="Animal">Fecha De Registro Animal</label>
                                            <input type="text" readonly class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}">
                                            <input type="date" class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{$Animal['FEC_REG_ANIMAL']}}">
                            
                                        </div>
                                    -->
                                        <div class="mb-3">
                                            <label for="Animal">Clase Del Animal</label>
                                            <input type="text" class="form-control" id="CLAS_ANIMAL" name="CLAS_ANIMAL" placeholder=" Ingrese La clase Del Animal  " value="{{$Animal['CLAS_ANIMAL']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="Animal">Raza Del Animal</label>
                                            <input type="text" class="form-control" id="RAZ_ANIMAL" name="RAZ_ANIMAL" placeholder=" Ingrese La Raza Del Animal  " value="{{$Animal['RAZ_ANIMAL']}}">
                                        </div>


                                        <div class="mb-3">
                                            <label for="Animal">Color Del Animal</label>
                                            <input type="text" class="form-control" id="COL_ANIMAL" name="COL_ANIMAL" placeholder=" Ingrese El Color Del animal  " value="{{$Animal['COL_ANIMAL']}}">
                                        </div>


                                        <div class="mb-3">
                                            <label for="Animal">Codigo Del fierro</label>
                                            <input type="text" class="form-control" id="COD_FIERRO" name="COD_FIERRO" placeholder=" Ingrese El Codigo Del Fierro  " value="{{$Animal['COD_FIERRO']}}">
                                        </div>

                                        

                                        <div class="mb-3 mt-3">
                                            <label for="Animal" >Esta Venteado El Animal</label>
                                           
                                            <select class="form-select  custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" value="{{$Animal['VEN_ANIMAL']}}">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="S" selected >SI</option>
                                                <option value="N" selected >NO</option>
                                                
                                            </select>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="Animal" class="form-label">Esta Herrado El Animal</label>
                                           
                                            <select class="form-select  custom-select" id="HER_ANIMAL" name="HER_ANIMAL" value="{{$Animal['HER_ANIMAL']}}" >
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="S" selected >SI</option>
                                                <option value="N" selected >NO</option>
                                                
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="Animal">Detalle Del Animal</label>
                                            <input type="text" class="form-control" id="DET_ANIMAL" name="DET_ANIMAL" placeholder=" Ingrese El Detalle Del Animal  " value="{{$Animal['DET_ANIMAL']}}">
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
@section('js')
   <script> console.log('Hi!'); </script>
   <script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#modAnimal').DataTable({
                    responsive: true
                });
            });
        </script>
    </script>
    
@stop
@section('css')
   <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
   <script> console.log('Hi!'); </script>
@stop
