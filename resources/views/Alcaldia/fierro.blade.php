@extends('adminlte::page')
@php
    $tiposFierro = [
        'L' => 'Letra',
        'F' => 'Figura',
        'N' => 'Numero',
        'S' => 'Simbolo',
    ];
   @endphp
   @php
    use Carbon\Carbon;
@endphp
@section('title', 'Alcaldia')

@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Clase CSS personalizada aquí -->
    <style>
        /* CSS personalizado */
        .custom-delete-button:hover .fas.fa-trash-alt {
            color: white !important;
        }
    </style>
    <style>
    .modal-body {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .mb-3 {
        flex: 0 0 48%; /* Ajusta el ancho según tus necesidades */
        margin-bottom: 1rem;
    }
</style>

    <!-- Estilos del mensaje de registro exitoso -->
    <style>
        .success-message {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }
    </style>
    <style>
        body {
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
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
        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Fierros</title>
    <!-- Estilos y estilos específicos para la generación de PDF -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }

        /* Agrega más estilos según sea necesario */
    </style>
</head>
<body>
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <?php
            $authController = app(\App\Http\Controllers\AuthController::class);
            $objeto = 'FIERROS'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
       <center><br>
            <h1>Información de Fierros</h1>
        </center></br>

        @section('content')
            <!-- Boton Nuevo -->
            @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
                <p align="right">
                    <button type="button" class="Btn" data-toggle="modal" data-target="#fierro">
                        <div class="sign">+</div>
                        <div class="text">Nuevo</div>
                    </button>
                </p>
            @endif
            
            <div class="modal fade bd-example-modal-sm" id="fierro" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
             <h5 class="modal-title text-center">Ingresa Un Nuevo Fierro</h5>
            </div>

            <div class="modal-body">
                <!-- Inicio del nuevo formulario -->
                <form action="{{ url('fierro/insertar') }}" method="post" class="needs-validation fierro-form" enctype="multipart/form-data">
                   @csrf 
                        <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id">Identidad Dueño</label>
                                <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese Identidad del Dueño" oninput="buscarPersona(this.value)" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="nom">Nombre</label>
                                <input type="text" readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" required>
                            </div>
                            <div class="mb-3">
                            <input type="hidden" readonly id="COD_PERSONA" class="form-control" name="COD_PERSONA">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="FEC_TRAMITE_FIERRO">Fecha Trámite</label>
                                <input type="date" id="FEC_TRAMITE_FIERRO" class="form-control" name="FEC_TRAMITE_FIERRO" placeholder="inserte la fecha de tramite." required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="NUM_FOLIO_FIERRO">Número Folio</label>
                                <input type="text" id="NUM_FOLIO_FIERRO" class="form-control" name="NUM_FOLIO_FIERRO" placeholder="Ingrese el numero de folio del fierro" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Agrega más elementos aquí si es necesario -->
                        </div>
                    </div>

                    <!-- Repite la estructura de filas y columnas para otros elementos -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="TIP_FIERRO" class="form-label">Tipo Fierro</label>
                                <select class="form-select" id="TIP_FIERRO" name="TIP_FIERRO" required>
                                    <div class="invalid-feedback"></div>
                                    <option value="X" selected="selected" disabled>- Elija el tipo de Fierro -</option>
                                    <option value="L">Letra</option>
                                    <option value="F">Figura</option>
                                    <option value="N">Numero</option>
                                    <option value="S">Simbolo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="MON_CERTIFICO_FIERRO">Monto Certifico</label>
                                <input type="text" prefix="L. " id="MON_CERTIFICO_FIERRO" class="form-control" name="MON_CERTIFICO_FIERRO" placeholder="Ingrese el monto del certifico" min="1" step="any" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Repite la estructura de filas y columnas para otros elementos -->

                    <div class="form-group">
                        <label for="IMG_FIERRO">Imagen Fierro</label>
                        <input type="file" class="form-control" id="IMG_FIERRO" name="IMG_FIERRO" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                    <label for="ESTADO">Estado</label>
                        <select class="form-select custom-select" id="ESTADO" name="ESTADO" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="A">ACTIVO</option>
                            <option value="I">INACTIVO</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                        </form>

                            <script>
                                $(document).ready(function() {
                                    //Validaciones del nombre persona, no permite que se ingrese numeros solo letras
                                    $('#COD_FIERRO').on('input', function() {
                                      var codigoFierro = $(this).val();
                                     // Implementar la lógica para verificar si el código ya existe y 
                                    //mostrar el mensaje de error correspondiente si ya está en uso.
                                     });
                                    
                                      $(document).ready(function() {
                                        $('#FEC_TRAMITE_FIERRO').on('input', function() {
                                            var fechaTramiteFierro = $(this).val();
                                            var currentDate = new Date().toISOString().split('T')[0];
                                            var errorMessage = 'La fecha de tramite no puede ser posterior al día actual';

                                            // Asegúrate de que la fecha de tramite no sea posterior al día actual
                                            if (fechaTramiteFierro > currentDate) {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                    });

                                    $('#NUM_FOLIO_FIERRO').on('input', function() {
                                     var folio = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                    $(this).val(folio); // Actualizar el valor del campo solo con números
                                    var errorMessage = 'El folio debe tener exactamente 6 dígitos numéricos ';
                                    if (folio.length !== 6) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text(errorMessage);
                                    } else {
                                        $(this).removeClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text('');
                                    }
                                     });
                                    //Validaciones del campo Fecha Registro el cual no permitira el ingreso de una fecha anterior al dia de registro
                                    $('#MON_CERTIFICO_FIERRO').on('input', function() {
                                      var monto = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                     $(this).val(monto); // Actualizar el valor del campo solo con números
                                     var errorMessage = 'El monto del certifico debe tener 2 dígitos numéricos ';
                                     if (monto.length  <2) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text(errorMessage);
                                     } else {
                                        $(this).removeClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text('');
                                     }
                                     });
                                    //
                                    
                                });
                                //Deshabilitar el envio de formularios si hay campos vacios
                                (function () {
                                    'use strict'
                                    //Obtener todos los formularios a los que queremos aplicar estilos de validacion de Bootstrap
                                    var forms = document.querySelectorAll('.needs-validation')
                                    //Bucle sobre ellos y evitar el envio
                                    Array.prototype.slice.call(forms)
                                        .forEach(function (form) {
                                            form.addEventListener('submit', function (event) {
                                                if (!form.checkValidity()) {
                                                    event.preventDefault()
                                                    event.stopPropagation()
                                                }

                                                form.classList.add('was-validated')
                                            }, false)
                                        })
                                })()
                                //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                                function limpiarFormulario() {
                                    document.getElementById("NOM_PERSONA").value = "";
                                    document.getElementById("FEC_TRAMITE_FIERRO").value = "";
                                    document.getElementById("NUM_FOLIO_FIERRO").value = "";
                                    document.getElementById("TIP_FIERRO").value = "";
                                    document.getElementById("MON_CERTIFICO_FIERRO").value = "";
                                    document.getElementById("IMG_FIERRO").value = "";

                                    const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
                                    invalidFeedbackElements.forEach(element => {
                                        element.textContent = "";
                                    });

                                    const invalidFields = document.querySelectorAll(".form-control.is-invalid");
                                    invalidFields.forEach(field => {
                                        field.classList.remove("is-invalid");
                                    });
                                }
                                document.getElementById("btnCancelar").addEventListener("click", function() {
                                    limpiarFormulario();
                                });
                                // Agregar una clase de CSS para mostrar la notificación flotante
                                
                                        //Función para buscar personas.
                                        function buscarPersona(idPersona) {
                                            var personasArreglo = <?php echo json_encode($personasArreglo); ?>;
                                            var personaEncontrada = false;

                                            if(idPersona){
                                                // Itera sobre el arreglo de personas en JavaScript (asumiendo que es un arreglo de objetos)
                                                for (var i = 0; i < personasArreglo.length; i++) {
                                                    if (personasArreglo[i].DNI_PERSONA == idPersona) {
                                                        personaEncontrada = true;
                                                        $('#NOM_PERSONA').val(personasArreglo[i].NOM_PERSONA);
                                                        $('#COD_PERSONA').val(personasArreglo[i].COD_PERSONA);
                                                        break;
                                                    }
                                                }

                                                if (!personaEncontrada) {
                                                    personaEncontrada = false;
                                                    $('#NOM_PERSONA').val('Persona no encontrada');
                                                    $('#COD_PERSONA').val('');
                                                }

                                            }else{
                                                personaEncontrada = false;
                                                $('#NOM_PERSONA').val('');
                                                $('#COD_PERSONA').val('');
                                            }
                                        };
                                             
                                // Función que se ejecutará después de enviar el formulario
                                function formSubmitHandler() {
                                    showSuccessMessage();
                                }
                                document.querySelector('.fierro-form').addEventListener('submit', formSubmitHandler);
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Inicio de la tabla -->
                    <table  width="100%" cellspacing="8 " cellpadding="8" class="table table-hover table-bordered mt-1" id="Rfierro">
                        <thead>
                        <tr>
                            <th>Nº</th>
                            <th><center>Dueño Fierro</center></th>
                            <th><center>No. Identidad</center></th>
                            <th><center>Fecha Registro</center></th>
                            <th><center>Folio</center></th>
                            <th><center>Tipo Fierro</center></th>
                            <th><center>Imagen</center></th>
                            <th><center>Estado</center></th>
                            <th><center>Opciones</center></th>
                        </tr>
                        </thead>
                        <tbody>
                           
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
                                         <td>
                                            @if ($persona !== null)
                                                 {{ $persona['DNI_PERSONA']  }}
                                             @else
                                                 Persona no encontrada
                                             @endif
                                         </td>
                                        <td>{{date('d-m-y', strtotime($fierro['FEC_TRAMITE_FIERRO']))}}</td>   
                                        <td># {{$fierro['NUM_FOLIO_FIERRO']}}</td>
                                        <td>{{$tiposFierro[$fierro['TIP_FIERRO']] }}</td>
                                        
                                        <td>
                                        <img src="{{ asset($fierro['IMG_FIERRO']) }}" alt="Imagen del Fierro" class="img-fluid" style="max-height: 100px;">
                                        </td>
                                        <td>
                                        @if ($fierro['ESTADO'] === 'A')
                                                Activo
                                            @elseif ($fierro['ESTADO'] === 'I')
                                                Inactivo
                                            @else
                                                Desconocido
                                            @endif
                                        </td>
                                        
                                    <td>
                                        <!-- Boton de Editar -->
                                        @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                            <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#fierro-edit-{{$fierro['COD_FIERRO']}}">
                                            <i class="fa-solid fa-pen-to-square" style="font-size: 15px"></i>
                                            </button>
                                        @endif
                                        <!-- Boton de PDF -->
                                        <button onclick="mostrarVistaPrevia({{$fierro['COD_FIERRO']}})" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal for editing goes here -->
                                <div class="modal fade bd-example-modal-sm" id="fierro-edit-{{$fierro['COD_FIERRO']}}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Actualizar Datos</h5>
                                        </div>

                                        <div class="modal-body">
                                        <form action="{{ url('fierro/actualizar') }}" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario({{$fierro['COD_FIERRO']}})">
                                            @csrf
                                                <div>
                                                    <input type="hidden" class="form-control" name="COD_FIERRO" value="{{$fierro['COD_FIERRO']}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="PERSONAL" class="form-label">Nombre Propietario:</label>
                                                    <input type="text" readonly class="form-control" id="NOM_PERSONA-{{ $fierro['COD_FIERRO'] }}" name="NOM_PERSONA" value="{{$persona['NOM_PERSONA']}}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="COD_PERSONA" class="form-label">No. Identidad:</label>
                                                    <input type="text" readonly class="form-control" id="DNI_PERSONA-{{ $fierro['COD_FIERRO'] }}" name="DNI_PERSONA" value="{{$persona['DNI_PERSONA']}}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="fierro" class="form-label">Fecha Trámite:</label>
                                                    <?php $fecha_formateada = Carbon::parse($fierro['FEC_TRAMITE_FIERRO'])->format('Y-m-d'); ?>
                                                    <input type="date" id="FEC_TRAMITE_FIERRO-{{$fierro['COD_FIERRO']}}" class="form-control" name="FEC_TRAMITE_FIERRO" placeholder="Seleccione la fecha de Trámite" value="{{$fecha_formateada}}" oninput="validarFecTra('{{$fierro['COD_FIERRO']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback3-{{$fierro['COD_FIERRO']}}"></div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="NUM_FOLIO_FIERRO">Número Folio</label>
                                                    <input type="text" class="form-control" id="NUM_FOLIO_FIERRO-{{ $fierro['COD_FIERRO'] }}" name="NUM_FOLIO_FIERRO" placeholder="Ingrese el Folio" value="{{ $fierro['NUM_FOLIO_FIERRO'] }}" oninput="validarFOLIO({{ $fierro['COD_FIERRO'] }}, this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback-{{ $fierro['COD_FIERRO'] }}"></div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="TIP_FIERRO" class="form-label">Tipo Fierro</label>
                                                    <select class="form-select" id="TIP_FIERRO" name="TIP_FIERRO">
                                                        <option value="L" {{ $fierro['TIP_FIERRO'] === 'L' ? 'selected' : '' }}>Letra</option>
                                                        <option value="F" {{ $fierro['TIP_FIERRO'] === 'F' ? 'selected' : '' }}>Figura</option>
                                                        <option value="N" {{ $fierro['TIP_FIERRO'] === 'N' ? 'selected' : '' }}>Numero</option>
                                                        <option value="S" {{ $fierro['TIP_FIERRO'] === 'S' ? 'selected' : '' }}>Simbolo</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="MON_CERTIFICO_FIERRO">Monto Certifico</label>
                                                    <input type="text" prefix="L. " class="form-control" id="MON_CERTIFICO_FIERRO" name="MON_CERTIFICO_FIERRO" placeholder="Ingrese el Monto del Certifico" value="{{$fierro['MON_CERTIFICO_FIERRO']}}" min="1" step="any" oninput="validarMontoC({{ $fierro['COD_FIERRO'] }}, this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback-{{ $fierro['COD_FIERRO'] }}"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="IMG_FIERRO">Imagen Fierro:</label>
                                                    <input type="file" class="form-control" id="IMG_FIERRO" name="IMG_FIERRO" accept="image/*">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="FIERROS">Estado</label>
                                                    <select class="form-select custom-select" id="ESTADO" name="ESTADO" required>
                                                        <option value="X" selected disabled>- Elija un estado -</option>
                                                        <option value="A" @if($fierro['ESTADO'] === 'A') selected @endif>ACTIVO</option>
                                                        <option value="I" @if($fierro['ESTADO'] === 'I') selected @endif>INACTIVO</option>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="IMG_FIERRO_actual" value="{{ $fierro['IMG_FIERRO'] }}">
                                                <img src="{{ asset($fierro['IMG_FIERRO']) }}" alt="Imagen actual" class="img-fluid" style="max-height: 100px;">

                                                <div class="mb-3">
                                                            <!-- Boton de confirmar al editar -->
                                                            <button type="submit" class="btn btn-primary" id="submitButton-{{$fierro['COD_FIERRO']}}">Editar</button>
                                                            <!-- Boton de cancelar -->
                                                            <a href="{{ url('fierro') }}" class="btn btn-danger">Cancelar</a>
                                                    </div>
                                                </form>
                                                
                                                <script>
                                                    function validarFecTra(id, fechaSeleccionada) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("FEC_TRAMITE_FIERRO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback3-" + id);

                                                        // Obtener la fecha actual
                                                        var fechaActual = new Date();

                                                        // Convertir la fecha seleccionada a un objeto Date
                                                        var fechaTramite = new Date(fechaSeleccionada);

                                                        // Comparar con la fecha actual y permitir fechas pasadas o el día actual
                                                        if (!isNaN(fechaTramite) && fechaTramite <= fechaActual) {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        } else {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La fecha de trámite no puede ser futura.";
                                                            btnGuardar.disabled = true;
                                                        }
                                                    }




                                               function validarFOLIO(id, folio) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("NUM_FOLIO_FIERRO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback-" + id);
              
                                                        if (!/^\d{6}$/.test(folio)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "El folio debe tener exactamente 6 dígitos numéricos";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    }

                                                    function validarMontoC(id, monto) {
                                                            var btnGuardar = document.getElementById("submitButton-" + id);
                                                            var inputElement = document.getElementById("MON_CERTIFICO_FIERRO");
                                                            var invalidFeedback = document.getElementById("invalid-feedback-" + id);

                                                            // Modifiqué la expresión regular para aceptar al menos 2 dígitos
                                                            if (!/^\d{2,}$/.test(monto)) {
                                                                inputElement.classList.add("is-invalid");
                                                                invalidFeedback.textContent = "El Monto debe tener al menos 2 dígitos";
                                                                btnGuardar.disabled = true;
                                                            } else {
                                                                inputElement.classList.remove("is-invalid");
                                                                invalidFeedback.textContent = "";
                                                                btnGuardar.disabled = false;
                                                            }
                                                        }
                                                    function mostrarVistaPrevia(idfierro) {
                                                        // URL de la acción del controlador que genera el PDF
                                                        var nuevaVentana = window.open("{{ url('fierro/generar-pdf') }}/" + idfierro, '_blank');

                                                        // Esperar a que la nueva ventana esté completamente cargada
                                                        nuevaVentana.onload = function () {
                                                            // Mostrar el diálogo de impresión
                                                            nuevaVentana.print();
                                                        };
                                                    }
                                            </script>

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            2023 &copy; UNAH  
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script> console.log('Hi!'); </script>
            <script>
            <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="sweetalert2.all.min.js"></script>

<script>
        @if(session('update_success'))
            Swal.fire('¡Éxito!', '{{ session('update_success') }}', 'success');
        @endif

        @if(session('update_error'))
            Swal.fire('¡Error!', '{{ session('update_error') }}', 'error');
        @endif

        @if(session('success'))
            Swal.fire('¡Éxito!', '{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            Swal.fire('¡Error!', '{{ session('error') }}', 'error');
        @endif
        @section('pdf_styles')
    <style>
        /* Estilos personalizados para la presentación en PDF */
        /* ... */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
@endsection
        $(document).ready(function() {
            $('#Rfierro').DataTable({
                responsive: true,
                dom: "Bfrtilp",
                buttons: [//Botones de Excel, PDF, Imprimir
                    {
                        extend: "excelHtml5",
                        filename: "Fierros",
                        text: "<i class='fa-solid fa-file-excel'></i>",
                        tittleAttr: "Exportar a Excel",
                        className: "btn btn-success",
                        exportOptions: {
                            columns: [0, 1, 2, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                        },
                    },
                
                    {
                            extend: "print",
                            text: "<i class='fa-solid fa-print'></i>",
                            titleAttr: "Imprimir",
                            className: "btn btn-secondary",
                            footer: true,
                            customize: function(win) {
                                // Agrega tu encabezado personalizado aquí
                                $(win.document.head).append("<style>@page { margin-top: 20px; }</style>");
                                
                                // Agrega dos logos al encabezado
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS DE FIERROS  </h5>");
                                $(win.document.body).prepend("<div style='text-align: center;'><img src='vendor/adminlte/dist/img/Encabezado.jpg' alt='Logo 1' width='1500' height='400' style='float: left; margin-right: 20px;' />");

                                
                                // Agrega la fecha actual
                                var currentDate = new Date();
                                var formattedDate = currentDate.toLocaleDateString();
                                $(win.document.body).prepend("<p style='text-align: right;'>Fecha de impresión: " + formattedDate + "</p>");
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                                stripHtml: false,
                            },
                        }

                ],
                lengthMenu : [10, 20, 30, 40, 50],
                columnDefs: [
                    { orderable: false, targets: [0, 2, 3, 6, 7] },
                    { searchable: false, targets: [0, 3, 6, 7] },
                    { width: '25%', targets: [1] },
                    { width: '10%', targets: [2, 3, 4, 6, 7] },
                    { width: '25%', targets: [5] },
                ],
                language: {
                    processing: "Procesando...",
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    search: "Buscar:",
                    infoThousands: ",",
                    loadingRecords: "Cargando...",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior",
                    },
                    buttons: {
                        copy: "Copiar",
                        colvis: "Visibilidad",
                        collection: "Colección",
                        colvisRestore: "Restaurar visibilidad",
                        copyKeys: "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                        copySuccess: {
                            1: "Copiada 1 fila al portapapeles",
                            _: "Copiadas %ds fila al portapapeles",
                        },
                        pdf: "PDF",
                        print: "Imprimir",
                    },
                },
                order: [[0, 'desc']],
            });
        });
             
            </script>
            </script> 
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>
            <script src="sweetalert2.all.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

        @stop

        @section('css')
            <link rel="stylesheet" href="/css/admin_custom.css">
        @stop
        @else
            <script>
                alert("No tiene autorización para ver este contenido");
                window.location.href = "{{ route('home') }}"; // Cambia a 'home' si no se poseen permisos.
            </script>
        @endif
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop
