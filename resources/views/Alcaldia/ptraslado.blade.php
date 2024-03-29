@ -1,1254 +0,0 @@
@extends('adminlte::page')

@section('title', 'Alcaldia')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Clase CSS personalizada aquí -->
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
   
@stop

@section('content_header')
@if(session()->has('user_data'))
        <?php
            $authController = app(\App\Http\Controllers\AuthController::class);
            $objeto = 'PTRASLADO'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
    @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <center><br>
        <h1>Información de Guías Francas</h1>
    </center></br>

@section('content')
    <!-- Boton Nuevo -->
    @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
    <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#ptraslado">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
    @endif
    <div class="modal fade bd-example-modal-lg" id="ptraslado" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title">Ingresa un Nuevo Permiso de Traslado</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                   
                </div>
                <div class="modal-body container-fluid">
    <form action="{{ url('ptraslado/insertar') }}" method="post" class="needs-validation">
        @csrf

        <div class="row">
            <!-- Primera columna -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="FEC_TRASLADO">Fecha Traslado</label>
                    <input type="date" id="FEC_TRASLADO" class="form-control" name="FEC_TRASLADO" placeholder="Inserte fecha del Traslado" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label for="id">Identidad Dueño</label>
                    <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese número de identidad" oninput="buscarPersona(this.value)" required>
                    <div class="invalid-feedback"></div>
                </div>

                 <div class="mb-3">
                    <label for="nom">Nombre Dueño</label>
                    <input type="text" readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" required>
                 </div>
                <div class="mb-3">
                     <input type="hidden" readonly id="COD_PERSONA" class="form-control" name="COD_PERSONA">
                  </div>

                  <div class="mb-3">
                    <label for="DIR_ORIG_PTRASLADO">Dirección Origen Traslado</label>
                    <input type="text" id="DIR_ORIG_PTRASLADO" class="form-control" name="DIR_ORIG_PTRASLADO" placeholder="Ingresar direccion de origen" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="DIR_DEST_TRASLADO">Dirección Destino Traslado</label>
                    <input type="text" id="DIR_DEST_TRASLADO" class="form-control" name="DIR_DEST_TRASLADO" placeholder="Ingresar direccion de destino" required>
                    <div class="invalid-feedback"></div>
                </div>

            </div>

            <!-- Segunda columna -->
            <div class="col-md-4">
                    <div class="mb-3">
                        <label for="NOM_TRANSPORTISTA">Nombre Transportista</label>
                        <input type="text" id="NOM_TRANSPORTISTA" class="form-control" name="NOM_TRANSPORTISTA" placeholder="Ingresar nombre de transportita" required>
                         <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="DNI_TRANSPORTISTA">Identidad Transportista</label>
                         <input type="text" id="DNI_TRANSPORTISTA" class="form-control" name="DNI_TRANSPORTISTA" placeholder="Ingresar numero de identidad" required>
                         <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="TEL_TRANSPORTISTA">Telefono Transportista</label>
                        <input type="text" id="TEL_TRANSPORTISTA" class="form-control" name="TEL_TRANSPORTISTA" placeholder="Ingresar numero de telefono" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="MAR_VEHICULO">Marca Vehículo</label>
                        <input type="text" id="MAR_VEHICULO" class="form-control" name="MAR_VEHICULO" placeholder="Ingresar marca del vehiculo" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="MOD_VEHICULO"> Modelo Vehículo</label>
                        <input type="text" id="MOD_VEHICULO" class="form-control" name="MOD_VEHICULO" placeholder="Ingresar modelo del vehiculo" required>
                        <div class="invalid-feedback"></div>
                    </div>   
            </div>

            <!-- Tercera columna -->
            <div class="col-md-4">
                    <div class="mb-3">
                        <label for="MAT_VEHICULO">Matricula Vehículo</label>
                        <input type="text" id="MAT_VEHICULO" class="form-control" name="MAT_VEHICULO" placeholder="Ingresar matricula del vehiculo" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="COL_VEHICULO">Color Vehículo</label>
                        <input type="text" id="COL_VEHICULO" class="form-control" name="COL_VEHICULO" placeholder="Ingresar color del vehiculo" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="MON_TRASLADO">Monto traslado</label>
                        <input type="text" id="MON_TRASLADO" class="form-control" name="MON_TRASLADO" placeholder="Ingresar monto del traslado" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="CAN_GANADO">Cantidad Animales</label>
                        <input type="text" id="CAN_GANADO" class="form-control" name="CAN_GANADO" placeholder="Ingresar cantidad de animales" required>
                        <div class="invalid-feedback"></div>
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
            </div>
        </div>

        <!-- Otras filas y columnas -->

        <div class="row">
            <div class="col-md-12">
                <!-- Botones de acción -->
                <div class="mb-3">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>

                

                    <script>
                        $(document).ready(function() {
                             //Validaciones del campo Fecha de Traslado el cual no permitira el ingreso de una fecha anterior al dia de registro
                            $('#FEC_TRASLADO').on('input', function() {
                                var fechaTraslado = $(this).val();
                                var currentDate = new Date().toISOString().split('T')[0];
                                var errorMessage = 'La fecha debe ser válida y no puede ser anterior a hoy';
                                
                                if (!fechaTraslado || fechaTraslado < currentDate) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });

                          //Validaciones del campo direccion de Origen de Traslado
                          $('#DIR_ORIG_PTRASLADO').on('input', function() {
                                  var direccionOrigen = $(this).val();
                                 var errorMessage = 'La dirección debe tener entre 5 y 200 caracteres';

                                 if (direccionOrigen.length < 5 || direccionOrigen.length > 200) {
                                   $(this).addClass('is-invalid');
                                               $(this).siblings('.invalid-feedback').text(errorMessage);
                                    } else {
                                         $(this).removeClass('is-invalid');
                                               $(this).siblings('.invalid-feedback').text('');
                                      }
                                  });

                              
                             //Validaciones del campo direccion de Destino de Traslado
                            $('#DIR_DEST_TRASLADO').on('input', function() {
                                var direccionDestino = $(this).val();
                                var errorMessage = 'La dirección debe tener entre 5 y 200 caracteres';
                                
                                if (direccionDestino.length < 5 || direccionDestino.length > 200 ) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            
                            //Validaciones del nombre del Trasnportista, no permite que se ingrese numeros solo letras
                            // Validaciones del nombre persona, no permite que se ingresen números ni caracteres especiales
                            $('#NOM_TRANSPORTISTA').on('keydown', function(e) {
                                        var key = e.key;
                                        var errorMessage = '';

                                        // Verifica si se está intentando ingresar un número o un carácter especial
                                        if (!/^[a-zA-Z\s]$/.test(key) && key !== 'Backspace') {
                                            errorMessage = 'No se permiten números ni caracteres especiales en el nombre.';
                                            e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                        }

                                        // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });

                                    // Validación de longitud mínima cuando se comienza a escribir
                                    var nombreInput = $('#NOM_TRANSPORTISTA');
                                    nombreInput.on('input', function() {
                                        var nombre = $(this).val();
                                        var errorMessage = '';

                                        // Verifica que se haya empezado a escribir antes de aplicar la validación de longitud mínima
                                        if (nombre.length > 0 && nombre.length < 5) {
                                            errorMessage = 'El nombre debe tener al menos 5 letras.';
                                        }

                                        // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });

                            //Validaciones del campo DNI el cual no permite el ingreso de letras (las bloquea y no se muestra)
                            //y solo permite el ingreso de numeros
                            $('#DNI_TRANSPORTISTA').on('input', function() {
                                var dniTransp = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                $(this).val(dniTransp); // Actualizar el valor del campo solo con números
                                var errorMessage = 'El DNI debe contener solo numeros ejemplo:0701199800027 ';
                                if (dniTransp.length !== 13) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            //Validaciones del campo Telefono en el cual no permite el ingreso de letras (las bloquea y no se muestra)
                            //y solo permite el ingreso de numeros
                            $('#TEL_TRANSPORTISTA').on('input', function() {
                                var telefono = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                $(this).val(telefono); // Actualizar el valor del campo solo con números
                                var errorMessage = 'El teléfono debe tener exactamente 8 dígitos numéricos ';
                                if (telefono.length !== 8) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                         //Validaciones al campo marca
                            $('#MAR_VEHICULO').on('keydown', function(e) {
                                        var key = e.key;
                                        var errorMessage = '';

                                        // Verifica si se está intentando ingresar un número o un carácter especial
                                        if (!/^[a-zA-Z\s]$/.test(key) && key !== 'Backspace') {
                                            errorMessage = 'No se permiten números ni caracteres especiales en la marca.';
                                            e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                        }

                                        // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                            //Validaciones al campo modelo
                            $('#MOD_VEHICULO').on('keydown', function(e) {
                                       var key = e.key;
                                       var errorMessage = '';

                                // Verifica si se está intentando ingresar un carácter especial
                                      if (!/^[a-zA-Z0-9\s]$/.test(key) && key !== 'Backspace') {
                                       errorMessage = 'No se permiten caracteres especiales en el modelo.';
                                    }

                                // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                      if (errorMessage) {
                                       e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                       $(this).addClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text(errorMessage);
                                     } else {
                                   // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                      $(this).removeClass('is-invalid');
                                     $(this).siblings('.invalid-feedback').text('');
                                      }
                            });

                            //Validaciones del campo color
                            $('#COL_VEHICULO').on('keydown', function(e) {
                                        var key = e.key;
                                        var errorMessage = '';

                                        // Verifica si se está intentando ingresar un número o un carácter especial
                                        if (!/^[a-zA-Z\s]$/.test(key) && key !== 'Backspace') {
                                            errorMessage = 'No se permiten números ni caracteres especiales en el color';
                                            e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                        }

                                        // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                     //Validaciones para el campo matricula
                                   $('#MAT_VEHICULO').on('keydown', function(e) {
                                        var key = e.key;
                                        var errorMessage = '';

                                     // Verifica si se está intentando ingresar un número, una letra o un carácter especial
                                    if (!/^[a-zA-Z0-9\s]$/.test(key) && key !== 'Backspace') {
                                       errorMessage = 'No se permiten caracteres especiales en el nombre.';
                                     e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                    }

                                    // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                    if (errorMessage) {
                                     $(this).addClass('is-invalid');
                                     $(this).siblings('.invalid-feedback').text(errorMessage);
                                    } else {
                                     // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                   $(this).removeClass('is-invalid');
                                   $(this).siblings('.invalid-feedback').text('');
                                    }
                                });

                                //VALIDACIONES DEL CAMPO MONTO
                                $('#MON_TRASLADO').on('keydown', function(e) {
                                     var key = e.key;
                                    var errorMessage = '';

                                    // Verifica si se está intentando ingresar un carácter que no es un número
                                    if (!/^\d$/.test(key) && key !== 'Backspace') {
                                      errorMessage = 'Solo se permiten números en el campo.';
                                      e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                     }

                                    // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                    if (errorMessage) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text(errorMessage);
                                    } else {
                                   // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                    }
                                });

                                //VALIDACIONES DEL CAMPO CODIGO DE FIERRO
                                $('#COD_FIERRO').on('keydown', function(e) {
                                     var key = e.key;
                                    var errorMessage = '';

                                    // Verifica si se está intentando ingresar un carácter que no es un número
                                    if (!/^\d$/.test(key) && key !== 'Backspace') {
                                      errorMessage = 'Solo se permiten números, verifica que exista el codigo en FIERROS';
                                      e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                     }

                                    // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                    if (errorMessage) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text(errorMessage);
                                    } else {
                                   // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                    }
                                });

                                //VALIDACIONES AL CAMPO CANTIDAD DE ANIMALES
                                $('#CAN_GANADO').on('keydown', function(e) {
                                     var key = e.key;
                                    var errorMessage = '';

                                    // Verifica si se está intentando ingresar un carácter que no es un número
                                    if (!/^\d$/.test(key) && key !== 'Backspace') {
                                      errorMessage = 'Solo se permiten números';
                                      e.preventDefault(); // Evita que el carácter no deseado se ingrese en el campo
                                     }

                                    // Si hay un error, muestra el mensaje y agrega la clase 'is-invalid'
                                    if (errorMessage) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text(errorMessage);
                                    } else {
                                   // Si no hay errores, quita la clase 'is-invalid' y borra el mensaje
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                    }
                                });
                                            
                        });

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

                                        //Función para buscar personas.
                                            function buscarPersona2(id,idPersona) {
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

                        //Deshabilitar el envio de formularios si hay campos no validos
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
                           
                            
                            document.getElementById("FEC_TRASLADO").value = "";
                            document.getElementById("COD_PERSONA").value = "";
                            document.getElementById("DIR_ORIG_PTRASLADO").value = "";
                            document.getElementById("DIR_DEST_TRASLADO").value = "";
                            document.getElementById("NOM_TRANSPORTISTA").value = "";
                            document.getElementById("DNI_TRANSPORTISTA").value = "";
                            document.getElementById("TEL_TRANSPORTISTA").value = "";
                            document.getElementById("MAR_VEHICULO").value = "";
                            document.getElementById("MOD_VEHICULO").value = "";
                            document.getElementById("MAT_VEHICULO").value = "";
                            document.getElementById("COL_VEHICULO").value = "";
                            document.getElementById("MON_TRASLADO").value = "";
                            document.getElementById("CAN_GANADO").value = "";
                            document.getElementById("ESTADO").value = "";

                               
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

                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

        <table width=100% cellspacing="8" cellpadding="8" class="table table-hover table-bordered mt-1" id="traslado">
        <thead>
            <tr>
                <th>Nº</th>                
                <th><center>Fecha Traslado</center></th>
                <th><center>Nombre Dueño</center></th>
                <th><center>Direccion Origen</center></th>
                <th><center>Direccion Destino</center></th>
                <th><center>Nombre Transportista</center></th> 
                <th><center>Estado</center></th>      
                <th><center><i class="fas fa-cog"></i></center></th>
            </tr>
        </thead>
        <tbody>

            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $PTraslado)
                @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $PTraslado['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                <tr>    
                    <td>{{$PTraslado['COD_PTRASLADO']}}</td>             
                    <td>{{date('d/m/y',strtotime($PTraslado['FEC_TRASLADO']))}}</td>
                    <td>
                        @if ($persona !== null)
                            {{ $persona['NOM_PERSONA']  }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                    <td>{{$PTraslado['DIR_ORIG_PTRASLADO']}}</td>
                    <td>{{$PTraslado['DIR_DEST_TRASLADO']}}</td>
                    <td>{{$PTraslado['NOM_TRANSPORTISTA']}}</td>
                    <td>
                        @if ($PTraslado['ESTADO'] === 'A')
                                ACTIVO
                            @elseif ($PTraslado['ESTADO'] === 'I')
                                INACTIVO
                            @else
                                DESCONOCIDO
                            @endif
                    </td>
                    <td>
                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                        <button value="Editar" title="Editar" class="btn btn-sm btn-warning"  type="button" data-toggle="modal" data-target="#PTraslado-edit-{{$PTraslado['COD_PTRASLADO']}}">
                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                        </button>
                    @endif
                    <!-- Boton de PDF -->
                    <button onclick="mostrarVistaPrevia({{$PTraslado['COD_PTRASLADO']}})" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                    </button>
                        
                    </td>
                    
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-lg" id="PTraslado-edit-{{$PTraslado['COD_PTRASLADO']}}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar Datos</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body container-fluid">
                                <form action="{{ url('ptraslado/actualizar') }}" method="post" class="row g-3 needs-validation" novalidate>
                                    @csrf
                                    
                                <div class="row">
                                    <!-- Primera columna -->
                                    <div class="col-md-4">
                                        <input type="hidden" class="form-control" name="COD_PTRASLADO" value="{{$PTraslado['COD_PTRASLADO']}}">

                                        <div class="mb-3 mt-3">
                                            <label for="PTraslado" class="form-label">Fecha Traslado</label>
                                            <?php $fecha_formateada = date('Y-m-d', strtotime($PTraslado['FEC_TRASLADO'])); ?>    
                                            <input type="date" class="form-control" id="FEC_TRASLADO" name="FEC_TRASLADO" value="{{ $fecha_formateada }}" min="{{ date('Y-m-d', time()) }}" required>
                                            <div class="valid-feedback " id="invalid-feedback1--{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="id">Identidad Dueño</label>
                                            <input type="text" id="dni-{{$PTraslado['COD_PTRASLADO']}}" class="form-control" name="dni" value="{{$persona['DNI_PERSONA']}}" placeholder="Ingrese número de identidad" oninput="buscarPersona2('{{$PTraslado['COD_PTRASLADO']}}', this.value);validarDNIDuenio('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback20-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                         </div>
                                            <div class="mb-3">
                                            <label for="nom">Nombre Dueño</label>
                                            <input type="text" readonly id="NOM_PERSONA-{{$PTraslado['COD_PTRASLADO']}}" class="form-control" name="NOM_PERSONA" value="{{$persona['NOM_PERSONA']}}" required>
                                        </div>
                                            <div class="mb-3">
                                            <input type="hidden" id="COD_PERSONA-{{$PTraslado['COD_PTRASLADO']}}" class="form-control" name="COD_PERSONA" value="{{$persona['COD_PERSONA']}}">
                                        </div>
                                                    
                                        <div class="mb-3">
                                            <label for="PTraslado">Dirección Origen</label>
                                            <input type="text" class="form-control" id="DIR_ORIG_PTRASLADO-{{$PTraslado['COD_PTRASLADO']}}" name="DIR_ORIG_PTRASLADO" placeholder="Ingresar direccion de origen del traslado" value="{{$PTraslado['DIR_ORIG_PTRASLADO']}}" oninput="validarDireccionO('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback10-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="PTraslado">Dirección Destino</label>
                                            <input type="text" class="form-control" id="DIR_DEST_TRASLADO-{{$PTraslado['COD_PTRASLADO']}}" name="DIR_DEST_TRASLADO" placeholder="Ingresar direccion de destino del traslado" value="{{$PTraslado['DIR_DEST_TRASLADO']}}" oninput="validarDireccionD('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback11-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>

                                        
                                    </div>

                                    <!-- Segunda columna --> 
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="PTraslado">Nombre Transportista</label>
                                            <input type="text" class="form-control" id="NOM_TRANSPORTISTA-{{$PTraslado['COD_PTRASLADO']}}" name="NOM_TRANSPORTISTA" placeholder="Ingresar nombre transportista" value="{{$PTraslado['NOM_TRANSPORTISTA']}}" oninput="validarNombre('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback3-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="PTraslado">Identidad Transportista</label>
                                            <input type="text" class="form-control" id="DNI_TRANSPORTISTA-{{$PTraslado['COD_PTRASLADO']}}" name="DNI_TRANSPORTISTA" placeholder="Ingresar numero de identidad" value="{{$PTraslado['DNI_TRANSPORTISTA']}}" oninput="validarDNI('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback2-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>

                                         <div class="mb-3">
                                            <label for="PTraslado">Telefono Transportista</label>
                                            <input type="text" class="form-control" id="TEL_TRANSPORTISTA-{{$PTraslado['COD_PTRASLADO']}}" name="TEL_TRANSPORTISTA" placeholder="Ingresar numero de telefono" value="{{$PTraslado['TEL_TRANSPORTISTA']}}" oninput="validarTelefono('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback1-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div> 

                                         <div class="mb-3">
                                            <label for="PTraslado">Marca Vehículo</label>
                                            <input type="text" class="form-control" id="MAR_VEHICULO-{{$PTraslado['COD_PTRASLADO']}}" name="MAR_VEHICULO" placeholder="Ingresar Marca Vehículo" value="{{$PTraslado['MAR_VEHICULO']}}" oninput="validarMarca('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback4-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="PTraslado">Modelo Vehículo</label>
                                            <input type="text" class="form-control" id="MOD_VEHICULO-{{$PTraslado['COD_PTRASLADO']}}" name="MOD_VEHICULO" placeholder="Ingresar Modelo Vehículo" value="{{$PTraslado['MOD_VEHICULO']}}" oninput="validarModelo('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback5-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>
                                    </div>
                                    <!-- Tercera columna --> 
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="PTraslado">Matricula Vehículo</label>
                                            <input type="text" class="form-control" id="MAT_VEHICULO-{{$PTraslado['COD_PTRASLADO']}}" name="MAT_VEHICULO" placeholder="Ingresar la matricula del Vehículo" value="{{$PTraslado['MAT_VEHICULO']}}" oninput="validarMatri('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback8-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="PTraslado">Color Vehículo</label>
                                            <input type="text" class="form-control" id="COL_VEHICULO-{{$PTraslado['COD_PTRASLADO']}}" name="COL_VEHICULO" placeholder="Ingresar el color del Vehículo" value="{{$PTraslado['COL_VEHICULO']}}" oninput="validarColor('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback9-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>

                                         <div class="mb-3">
                                            <label for="PTraslado">Monto Traslado</label>
                                            <input type="text" class="form-control" id="MON_TRASLADO-{{$PTraslado['COD_PTRASLADO']}}" name="MON_TRASLADO" placeholder="Ingresar Monto de traslado" value="{{$PTraslado['MON_TRASLADO']}}" oninput="validarMonto('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                        </div>
                                        <div class="mb-3">
                                             <label for="CAN_GANADO">Cantidad Animales</label>
                                             <input type="text" class="form-control" id="CAN_GANADO-{{$PTraslado['COD_PTRASLADO']}}" name="CAN_GANADO" placeholder="Ingresar la cantidad de animales" value="{{$PTraslado['CAN_GANADO']}}" oninput="validarCanA('{{$PTraslado['COD_PTRASLADO']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback7-{{$PTraslado['COD_PTRASLADO']}}"></div>
                                         </div>
                                        <div class="mb-3 mt-3">
                                            <label for="PTraslado">Estado</label>
                                            <select class="form-select custom-select" id="ESTADO" name="ESTADO" required>
                                                <option value="X" selected disabled>- Elija un estado -</option>
                                                <option value="A" @if($PTraslado['ESTADO'] === 'A') selected @endif>ACTIVO</option>
                                                <option value="I" @if($PTraslado['ESTADO'] === 'I') selected @endif>INACTIVO</option>
                                            </select>
                                        </div>
                                     </div>
                         <!-- Otras filas y columnas -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary"id="submitButton-{{$PTraslado['COD_PTRASLADO']}}">Editar</button>
                                            <a href="{{ url('ptraslado') }}" class="btn btn-danger">Cancelar</a>
                                        </div>
                                    </div>
                                 </div>
                             </form>
                            <script>
                                //Validaciones del formulario EDITAR

                                //Telefono Transportista listo
                                function validarTelefono(id, telefono) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("TEL_TRANSPORTISTA-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback1-" + id);

                                    
                                    if (!/^\d{8}$/.test(telefono)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "El teléfono debe tener exactamente 8 dígitos";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }
                                //Validaciones editar dni Transportista listo
                                function validarDNI(id, dni) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("DNI_TRANSPORTISTA-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback2-" + id);

                                    if (!/^\d{13}$/.test(dni)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "El DNI debe tener exactamente 13 dígitos numéricos";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }

                                function validarDNIDuenio(id, dniD) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("dni-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback20-" + id);

                                    if (!/^\d{13}$/.test(dniD)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "El DNI debe tener exactamente 13 dígitos numéricos";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }

                                   function validarDireccionO(id, direcciono) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("DIR_ORIG_PTRASLADO-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback10-" + id);

                                    if (direcciono.length < 5) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "La dirección debe tener al menos 5 caracteres.";
                                        btnGuardar.disabled = true;
                                    } else if (direcciono.length > 200) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "La dirección no puede tener más de 200 carácteres.";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }                       
                                function validarDireccionD(id, direcciond) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("DIR_DEST_TRASLADO-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback11-" + id);

                                    if (direcciond.length < 5) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "La dirección debe tener al menos 5 caracteres.";
                                        btnGuardar.disabled = true;
                                    } else if (direcciond.length > 200) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "La dirección no puede tener más de 200 carácteres.";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }

                                //Validar Nombre Transportista
                                function validarNombre(id, nombre) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("NOM_TRANSPORTISTA-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback3-" + id);

                                    if (nombre.length < 5 || nombre.length > 100 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "El nombre debe tener al menos 5 carácteres sin números y Simbolos";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }
                                //Validar Marca Vehículo
                                function validarMarca(id, marca) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("MAR_VEHICULO-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback4-" + id);

                                    if (marca.length < 4 || marca.length > 50 || !/^[a-zA-Z\s]+$/.test(marca)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "No se permite números";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }

                                //Validar Modelo Vehículo
                                function validarModelo(id, modelo) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("MOD_VEHICULO-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback5-" + id);

                                    if (modelo.length < 4 || modelo.length > 50 ||!/^[a-zA-Z0-9\s]+$/.test(modelo)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "No se permite caracteres especiales";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }

                                //Validar Matricula Vehículo
                                function validarMatri(id, matricula) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("MAT_VEHICULO-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback8-" + id);

                                    if (matricula.length < 6 || matricula.length > 50 ||!/^[a-zA-Z0-9\s]+$/.test(matricula)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "No se permite caracteres especiales";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }
                                //Validar Color Vehiculo 
                                function validarColor(id, color) {
                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                    var inputElement = document.getElementById("COL_VEHICULO-" + id);
                                    var invalidFeedback = document.getElementById("invalid-feedback9-" + id);

                                    if (color.length < 4 || color.length > 50 || !/^[a-zA-Z\s]+$/.test(color)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "No se permiten números y Simbolos";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }

                                //Validaciones monto traslado
                                function validarMonto(id, monto) {
                                         var btnGuardar = document.getElementById("submitButton-" + id);
                                        var inputElement = document.getElementById("MON_TRASLADO-"+ id);
                                         var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                         
                                    if ( !/^\d{2,}$/.test(monto)) {
                                         inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "El Monto solo permite numeros";
                                         btnGuardar.disabled = true;
                                     } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }
                                //funcion validar cantidad de ganado 
                                function validarCanA(id, cantidad) {
                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                        var inputElement = document.getElementById("CAN_GANADO-"+ id);
                                        var invalidFeedback = document.getElementById("invalid-feedback7-" + id);

                                    
                                    if (!/^\d{1,}$/.test(cantidad)) {
                                        inputElement.classList.add("is-invalid");
                                        invalidFeedback.textContent = "Solo permite números";
                                        btnGuardar.disabled = true;
                                    } else {
                                        inputElement.classList.remove("is-invalid");
                                        invalidFeedback.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                }


                                //Función para buscar personas.
                                function buscarPersona2(id,idPersona) {
                                        var personasArreglo = <?php echo json_encode($personasArreglo); ?>;
                                        var personaEncontrada = false;

                                            if(idPersona){
                                                    // Itera sobre el arreglo de personas en JavaScript (asumiendo que es un arreglo de objetos)
                                                    for (var i = 0; i < personasArreglo.length; i++) {
                                                        if (personasArreglo[i].DNI_PERSONA == idPersona) {
                                                            personaEncontrada = true;
                                                            $('#NOM_PERSONA-'+id).val(personasArreglo[i].NOM_PERSONA);
                                                            $('#COD_PERSONA-'+id).val(personasArreglo[i].COD_PERSONA);
                                                            break;
                                                        }
                                                    }

                                                    if (!personaEncontrada) {
                                                        personaEncontrada = false;
                                                        $('#NOM_PERSONA-'+id).val('Persona no encontrada');
                                                        $('#COD_PERSONA-'+id).val('');
                                                    }

                                                }else{
                                                    personaEncontrada = false;
                                                    $('#NOM_PERSONA-'+id).val('');
                                                    $('#COD_PERSONA-'+id).val('');
                                                }
                                        };
                                    
                                        function mostrarVistaPrevia(idtraslado) {
                                            // URL de la acción del controlador que genera el PDF
                                            var nuevaVentana = window.open("{{ url('ptraslado/generar-pdf') }}/" + idtraslado, '_blank');

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
        </div>

                <!-- Modal Eliminar -->
                <div class="modal fade" id="ptraslado-delete-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <input type="hidden" name="delete_id" id="delete_id"> <!-- Agrega este campo oculto, donde almacena el Id del registro que se va a eeliminar-->
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
   <script> console.log('Hi!'); </script>
   <script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
            
            <script>
            $(document).ready(function() {
                $('#traslado').DataTable({
                    responsive: true,
                        dom: "Bfrtilp",
                        buttons: [//Botones de Excel, PDF, Imprimir
                            {
                                extend: "excelHtml5",
                                filename: "Guías Francas",
                                text: "<i class='fa-solid fa-file-excel'></i>",
                                tittleAttr: "Exportar a Excel",
                                className: "btn btn-success",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                },
                            },
                            {
                            extend: "print",
                            filename: "Guías Francas",
                            text: "<i class='fa-solid fa-print'></i>",
                            titleAttr: "Imprimir",
                            className: "btn btn-secondary",
                            footer: true,
                            customize: function(win) {
                                // Agrega tu encabezado personalizado aquí
                                $(win.document.head).append("<style>@page { margin-top: 20px; }</style>");
                                
                                // Agrega dos logos al encabezado
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS GUIA FRANCA  </h5>");
                                $(win.document.body).prepend("<div style='text-align: center;'><img src='vendor/adminlte/dist/img/Encabezado.jpg' alt='Logo 1' width='1500' height='400' style='float: left; margin-right: 20px;' />");

                                
                                // Agrega la fecha actual
                                var currentDate = new Date();
                                var formattedDate = currentDate.toLocaleDateString();
                                $(win.document.body).prepend("<p style='text-align: right;'>Fecha de impresión: " + formattedDate + "</p>");
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6],
                                stripHtml: false,
                            },
                        }
                            
                        ],
                        lengthMenu : [10, 20, 30, 40, 50],
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
    <script>
        // Manejar el clic en el botón de eliminar
        $('.btn-outline-danger').on('click', function() {
                    var deleteId = $(this).data('id');
                    $('#delete_id').val(deleteId);
                });
        //Función para confirmar eliminación
        function confirmDelete(id) {
            $('#psacrificio-delete-confirm').modal('show');
            $('#delete-form').attr('action', '{{ url("psacrificio/eliminar") }}/' + id);
        }
    </script> 
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
