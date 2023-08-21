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
      <style>
        /* Boton Nuevo */
        .Btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 40px;
            height: 40px;
            border-radius: calc(45px/2);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: rgb(0, 143, 0);
            }

        /* plus sign */
        .sign {
            width: 100%;
            font-size: 2.0em;
            color: white;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: white;
            font-size: 1.0em;
            font-weight: 300;
            transition-duration: .3s;
        }
        /* hover effect on button width */
        .Btn:hover {
            width: 125px;
            transition-duration: .3s;
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 15px;
        }
        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 15px;
        }
        /* button click effect*/
        .Btn:active {
            transform: translate(2px ,2px);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('content_header')
    @if(session()->has('user_data'))
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php
                $authController = app(\App\Http\Controllers\AuthController::class);
                $objeto = 'Expedientes CV'; // Por ejemplo, el objeto deseado
                $rol = session('user_data')['NOM_ROL'];
                $tienePermiso = $authController->tienePermiso($rol, $objeto);
            ?>
             @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
            <center><br>
                <h1>Información de Expedientes Cartas De Ventas</h1>
            </center></br>
            
           

        @section('content')
        @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
        <p align="right">
            <button type="button" class="Btn" data-toggle="modal" data-target="#Cventa">
                <div class="sign">+</div>
                <div class="text">Nuevo</div>
            </button>
        </p>
        @endif
       
            <div class="modal fade bd-example-modal-sm" id="Cventa" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo Expedientes_Cventas</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Cventa/insertar') }}" method="post" class="needs-validation cventa-form" >
                                @csrf
                                <!--metodo de inserta en codigo de vendedor  atraendo los datos ya existente de la tabla persona-->
                                <div class="mb-3 mt-3">
                                    <label for="COD_VENDEDOR" >Nombre Vendedor</label>
                                    <select class="form-select custom-select" id="COD_VENDEDOR" name="COD_VENDEDOR" required>
                                        <option value="" disabled selected>Seleccione el Nombre del vendedor</option>
                                        @foreach ($personasArreglo as $personas)
                                            <option value="{{$personas['COD_PERSONA']}}">{{$personas['NOM_PERSONA']}}</option>
                                        @endforeach 
                                        
                                    
                                    </select>
                                </div>

                                <!--metodo de inserta en codigo de comprador  atraendo los datos ya existente de la tabla persona-->
                               <div class="mb-3">
                                    <label for="NOM_COMPRADOR">Nombre del Comprador</label>
                                    <input type="text" id="NOM_COMPRADOR" class="form-control" name="NOM_COMPRADOR" placeholder="Ingresar el nombre completo de la Comprador"   pattern="^[A-Za-z\s]+$" title="Ingrese solo letras"required>
                                    <div class="invalid-feedback">Ingresar el nombre completo de la Comprador</div>
                                </div>
                        
                             <!--    <div class="mb-3">
                                    <label for="DNI_COMPRADOR">Numero de Identidad comprador</label>
                                    <input type="text" id="DNI_COMPRADOR" class="form-control" name="DNI_COMPRADOR" placeholder="Ingresar el numero de identidad de comprador" required>
                                    <div class="invalid-feedback"></div>
                                </div>-->
                                <div class="mb-3">
                                    <label for="DNI_COMPRADOR">Numero de Identidad comprador</label>
                                    <input type="text" id="DNI_COMPRADOR" class="form-control @error('DNI_COMPRADOR') is-invalid @enderror" name="DNI_COMPRADOR" placeholder="Ingresar el numero de identidad de comprador" required pattern="[0-9]+" title="Ingrese solo números" maxlength="13">
                                    <div class="invalid-feedback"> Ingresar el DNI completo de la Comprador</div>
                                    @error('DNI_COMPRADOR')
                                        <div class="invalid-feedback">Ingresar el DNI ompleto de la Comprador</div>
                                    @enderror
                                </div>



                                <!--metodo de inserta en codigo de animal  atraendo los datos ya existente de la tabla persona-->
                                <div class="mb-3 mt-3">
                                    <label for="COD_ANIMAL" >Animal</label>
                                    <select class="form-select custom-select" id="COD_ANIMAL" name="COD_ANIMAL" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        @foreach ($AnimalArreglo as $Animal)
                                            <option value="{{$Animal['COD_ANIMAL']}}">{{$Animal['COD_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['RAZ_ANIMAL']}} {{$Animal['COL_ANIMAL']}} {{$Animal['COD_FIERRO']}} {{$Animal['VEN_ANIMAL']}} {{$Animal['HER_ANIMAL']}} {{$Animal['DET_ANIMAL']}}</option>
                                            

                                        @endforeach 
                                        
                                    
                                    </select>
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="FOL_CVENTA">Folios De Cartas</label>
                                    <input type="text" id="FOL_CVENTA" class="form-control"  @error('FOL_CVENTA') is-invalid @enderror "   name="FOL_CVENTA" placeholder="Ingrese numero de Folio "required pattern="[0-9]+" title="Ingrese solo números" maxlength="5" >
                                    
                                    <div class="invalid-feedback">Ingresar el numero de folio </div>
                                    @error('FOL_CVENTA')
                                        <div class="invalid-feedback">Ingresar el numero de folio</div>
                                    @enderror
                                   
                                    
                                </div>
                            


                                <div class="mb-3 mt-3">
                                    <label for="ANT_CVENTA">Antecedentes de carta venta</label>
                                    <select class="form-select custom-select"  id="ANT_CVENTA" name="ANT_CVENTA" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="SI" selected >SI</option>
                                        <option value="NO" selected >NO</option>
                                        
                                    
                                    </select>
                                    <div class="invalid-feedback" id="antCventaError">Seleccione una opción válida.</div>
                                </div>
                            
                            

                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                        <script>
                            $(document).ready(function() {
                                $('#NOM_COMPRADOR').on('input', function() {
                                    var nombreComprador = $(this).val();
                                    if (!/^[A-Za-z\s]+$/.test(nombreComprador) || nombreComprador.trim().length < 5) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#DNI_COMPRADOR').on('input', function() {
                                    var dniComprador = $(this).val();
                                    var dniRegex = /^[0-9]+$/;
                                    if (dniComprador === "" || !dniComprador.match(dniRegex) || dniComprador.length !== 13) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#FOL_CVENTA').on('input', function() {
                                    var folCventa = $(this).val();
                                    if (!/^[0-9]+$/.test(folCventa) || folCventa.length > 5) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#ANT_CVENTA').on('change', function() {
                                    var antCventa = $(this).val();
                                    if (antCventa === "") {
                                        $(this).addClass('is-invalid');
                                        $('#antCventaError').text('Seleccione una opción.');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                        $('#antCventaError').text('');
                                    }
                                });
                    
                                $('select[required]').on('change', function() {
                                    if ($(this).val() === '' || $(this).val() === null) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#Cventa').submit(function(event) {
                                    var formIsValid = true;
                    
                                    if ($('#NOM_COMPRADOR').val().trim().length < 5) {
                                        $('#NOM_COMPRADOR').addClass('is-invalid');
                                        formIsValid = false;
                                    } else {
                                        $('#NOM_COMPRADOR').removeClass('is-invalid');
                                    }
                    
                                    var dniComprador = $('#DNI_COMPRADOR').val();
                                    var dniRegex = /^[0-9]+$/;
                                    if (dniComprador === "" || !dniComprador.match(dniRegex) || dniComprador.length !== 13) {
                                        $('#DNI_COMPRADOR').addClass('is-invalid');
                                        formIsValid = false;
                                    } else {
                                        $('#DNI_COMPRADOR').removeClass('is-invalid');
                                    }
                    
                                    var folCventa = $('#FOL_CVENTA').val();
                                    if (!/^[0-9]+$/.test(folCventa) || folCventa.length > 5) {
                                        $('#FOL_CVENTA').addClass('is-invalid');
                                        formIsValid = false;
                                    } else {
                                        $('#FOL_CVENTA').removeClass('is-invalid');
                                    }
                    
                                    var antCventa = $('#ANT_CVENTA').val();
                                    if (antCventa === "") {
                                        $('#ANT_CVENTA').addClass('is-invalid');
                                        $('#antCventaError').text('Seleccione una opción.');
                                        formIsValid = false;
                                    } else {
                                        $('#ANT_CVENTA').removeClass('is-invalid');
                                        $('#antCventaError').text('');
                                    }


                                                      
                                    if (!formIsValid) {
                                        event.preventDefault();
                                    } else {
                                        showSuccessMessage();
                                    }
                                });
                    
                                function showSuccessMessage() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Registro Exitoso',
                                        text: 'El registro ha sido guardado exitosamente.',
                                        showConfirmButton: false,
                                        timer: 6000,
                                    });
                                }
                            });
                        </script>









                         
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
            <table  width="100%"  cellspacing="9" cellpadding="9" class="Table table-hover table-bordered mt-1 " id="modCventa" >
                <thead>
                    <th>Código Cventas</th>
                    <th>Fecha Venta</th>
                    <th>Código Vendedor</th>
                    <th>Nombre Vendedor</th>
                    <th>Nombre Comprador</th>
                    <th>DNI Comprador</th>
                    <th>Código Animal </th>
                    <th>Folio Cventa</th>
                    <th>Ant Cventa</th>
                    <th>opciones </th>
                   
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Cventa)
                        <tr>
                            <td>{{$Cventa['COD_CVENTA']}}</td>
                            <td>{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}</td>
                            <td>{{$Cventa['COD_VENDEDOR']}}</td> 
                            <td>{{$Cventa['NombreVendedor']}}</td>
                            <td>{{$Cventa['NOM_COMPRADOR']}}</td> 
                            <td>{{$Cventa['DNI_COMPRADOR']}}</td> 
                            <td>{{$Cventa['COD_ANIMAL']}}</td>
                            <td>{{$Cventa['FOL_CVENTA']}}</td> 
                            <td>{{$Cventa['ANT_CVENTA']}}</td>
                            <td>
                            @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                    <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Cventa-edit-{{$Cventa['COD_CVENTA']}}">
                                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                    </button>
                            @endif

                             <!-- Boton de PDF -->
                              <a href="{{ route('Cventa.pdfc') }}" class="btn btn-sm btn-danger" data-target="#Cventa-edit-{{$Cventa['COD_CVENTA']}}" target="_blank">
                                    <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                             </a>
    

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
                                                    <label for="Cventa">nombre Comprador</label>
                                                    <input type="text" class="form-control" id="NOM_COMPRADOR" name="NOM_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$Cventa['NOM_COMPRADOR']}}">
                                                </div>

                                               <div class="mb-3">
                                                    <label for="Cventa">DNI Comprador</label>
                                                    <input type="text" class="form-control" id="DNI_COMPRADOR" name="DNI_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$Cventa['DNI_COMPRADOR']}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="Cventa">Codigo Animal</label>
                                                    <input type="text" class="form-control" id="COD_ANIMAL" name="COD_ANIMAL" placeholder=" Ingrese el codigo del animal  " value="{{$Cventa['COD_ANIMAL']}}">
                                                    <select class="form-select custom-select" id="COD_ANIMAL" name="COD_ANIMAL" required>
                                                        <option value="" disabled selected>Seleccione una opción</option>
                                                            @foreach ($AnimalArreglo as $Animal)
                                                                <option value="{{$Animal['COD_ANIMAL']}}">{{$Animal['COD_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['RAZ_ANIMAL']}} {{$Animal['COL_ANIMAL']}} {{$Animal['COD_FIERRO']}} {{$Animal['VEN_ANIMAL']}} {{$Animal['HER_ANIMAL']}} {{$Animal['DET_ANIMAL']}}</option>
                                            

                                                                @endforeach 
                                        
                                    
                                                    </select>
                    
                                        
                                    
                                    
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
                        <!--agregado -->
            



                    @endforeach
                </tbody>
            </table>
                            </div>
                            </div>
                              <!-- MENSAJE BAJO -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            2023 &copy; SOFTEAM  
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a>Version 1.0</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- FIN MENSAJE -->
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
                        $('#modCventa').DataTable({
                            responsive: true,
                            lengthMenu : [10, 20, 30, 40, 50],
                            columnDefs: [
                                { orderable: false, target: [0, 2, 3, 6, 7]},
                                { searchable: false, target: [0, 3, 6, 7]},
                                { width: '25%', target: [1] },
                                { width: '10%', target: [2, 3, 4, 6, 7] }, 
                                { width: '25%', target: [5] },
                            ],
                            language: {
                                processing: "Procesando...",
                                lengthMenu: "Mostrar _MENU_ registros",
                                zeroRecords: "No se encontraron resultados",
                                emptyTable: "Ningún dato disponible en esta tabla",
                                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                                search: "Buscar:",
                                infoThousands: ",",
                                loadingRecords: "Cargando...",
                                paginate: {
                                    first: "Primero",
                                    last: "Último",
                                    next: "Siguiente",
                                    previous: "Anterior"
                                },
                            }
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
        @else
            <p>No tiene autorización para visualizar esta sección</p>
        @endif
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop