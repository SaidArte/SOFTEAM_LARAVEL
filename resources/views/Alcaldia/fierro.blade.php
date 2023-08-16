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

@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Clase CSS personalizada aquí -->
    <style>
     
        .custom-delete-button:hover .fas.fa-trash-alt {
            color: white !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('content_header')
    @if(session()->has('user_data'))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <center><br>
            <h1>Informacion de Fierro</h1>
        </center></br>
        <blockquote class="blockquote text-center">
            <p class="mb-0"></p>
            <footer class="blockquote-footer">Fierro <cite title="Source Title">Registrados</cite></footer>
        </blockquote>

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
                        <p>Ingresar Datos Solicitados:</p>
                        <form action="{{ url('fierro/insertar') }}" method="post" class="needs-validation" enctype= "multipart/form-data">
                            @csrf
                                
                            <div class="mb-3 mt-3">
                                <label for="COD_PERSONA" class="form-label">Persona: </label>
                                <select class="form-select" id="COD_PERSONA" name="COD_PERSONA" required>
                                    <option value="" disabled selected>Seleccione una persona</option>
                                    @foreach ($personasArreglo as $persona)
                                        <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOM_PERSONA'] }} </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="mb-3 ">
                                <label for="FEC_TRAMITE_FIERRO">Fecha de Tramite</label>
                                <input type="date" id="FEC_TRAMITE_FIERRO" class="form-control" name="FEC_TRAMITE_FIERRO" placeholder="inserte la fecha de tramite." required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="NUM_FOLIO_FIERRO">Numero de Folio</label>
                                <input type="text" id="NUM_FOLIO_FIERRO" class="form-control" name="NUM_FOLIO_FIERRO" placeholder="Ingrese el numero de folio del fierro" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="TIP_FIERRO" class="form-label">Tipo de Fierro</label>
                                <select class="form-select" id="TIP_FIERRO" name="TIP_FIERRO" required>
                                <div class="invalid-feedback"></div>
                                <option value="X" selected = "selected" disabled>- Elija el tipo de Fierro -</option>
                                    <option value="L">Letra</option>
                                    <option value="F">Figura</option>
                                    <option value="N">Numero</option>
                                    <option value="S">Simbolo</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="MON_CERTIFICO_FIERRO">Monto del Certifico</label>
                                <input type="text" id="MON_CERTIFICO_FIERRO" class="form-control" name="MON_CERTIFICO_FIERRO" placeholder="Ingrese el monto del certifico" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            </div> 

                            <form action="{{ route('fierro.guardar-imagen') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="IMG_FIERRO">Imagen del Fierro</label>
                                <input type="file" class="form-control" id="IMG_FIERRO" name="IMG_FIERRO" accept="image/*">
                            </div>
                        <center><br>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Guardar Informacion</button>
                                <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                
                            </div>
                        </center></br> 
                </form>
                    
                    </div>
                </div>
        </div>
        </div>

        <div class="card">
        <div class="card-body">

        <table width=100% cellspacing="8" cellpadding="8" class="table table-hover table-responsive table-verde-claro table-striped mt-1" id="Rfierro">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th><center>Dueño Fierro</center></th>
                    <th><center>Fecha Tramite</center></th>
                    <th><center>Numero Folio</center></th>
                    <th><center>Tipo Fierro</center></th>
                    <th><center>Monto Certifico</center></th>
                    <th><center>Img Fierro</center></th>
                    <th><center>Opciones de la Tabla</center></th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through $citaArreglo and show data -->
                @foreach($citaArreglo as $fierro)
                
                @php
                        $persona = null;
                        foreach ($personasArreglo as $p) {
                            if ($p['COD_PERSONA'] === $fierro['COD_PERSONA']) {
                                $persona = $p;
                                break;
                            }
                        }
                    @endphp
                    <tr>
                            <td>{{$fierro['COD_FIERRO']}}</td>
                            <td>
                                @if ($persona !== null)
                                        {{ $persona['NOM_PERSONA']  }}
                                @else
                                        Persona no encontrada
                                @endif
                        </td>
                            <td>{{date('d-m-y', strtotime($fierro['FEC_TRAMITE_FIERRO']))}}</td>   
                            <td>{{$fierro['NUM_FOLIO_FIERRO']}}</td>
                            <td>{{ $tiposFierro[$fierro['TIP_FIERRO']] }}</td>
                            <td>{{$fierro['MON_CERTIFICO_FIERRO']}}</td>
                            <td>
                            <img src="{{ asset($fierro['IMG_FIERRO']) }}" alt="Imagen del Fierro" class="img-fluid" style="max-height: 100px;">
                            </td>

                        <td>
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#fierro-edit-{{$fierro['COD_FIERRO']}}">
                                <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                            </button>
                            
                        </td>
                    
                    <div class="modal fade bd-example-modal-sm" id="fierro-edit-{{$fierro['COD_FIERRO']}}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Actualizar Datos</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Ingresa los Nuevos Datos</p>
                                    <form action="{{ url('fierro/actualizar') }}" method="post" class="row g-3 needs-validation" novalidate>
                                        @csrf
                                <input type="hidden" class="form-control" name="COD_FIERRO" value="{{$fierro['COD_FIERRO']}}">
                                            
                                <div class="mb-3">
                                        <label for="fierro" class="form-label">Fecha de Tramite:</label>
                                        <?php $fecha_formateada = date('Y-m-d', strtotime($fierro['FEC_TRAMITE_FIERRO'])); ?>
                                <input type="date" class="form-control" id="FEC_TRAMITE_FIERRO" name="FEC_TRAMITE_FIERRO" value="{{ $fecha_formateada }}">
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
                                    
                                <div class="card">
                            <div class="card-header">Actualizar Imagen del Fierro</div>
                            <div class="card-body">
                                <form action="{{ url('fierro/actualizar-imagen') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    @csrf
                                    <input type="hidden" name="COD_FIERRO" value="{{$fierro['COD_FIERRO']}}">
                                    <div class="form-group">
                                        <label for="IMG_FIERRO">Nueva Imagen del Fierro</label>
                                        <input type="file" class="form-control" id="IMG_FIERRO" name="IMG_FIERRO" accept="image/*" readonly>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Actualizar Imagen</button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                    
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

                
                    <div class="modal fade" id="registroExitosoModal" tabindex="-1" aria-labelledby="registroExitosoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="registroExitosoModalLabel">Registro Exitoso</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Fierro registrado exitosamente.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
            </tbody>
        </table>
        </div>
        </div>
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
                    $('#Rfierro').DataTable({
                        responsive: true
                    });
                });
            </script>
        </script>
        
        @stop

        @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
        @stop
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop
