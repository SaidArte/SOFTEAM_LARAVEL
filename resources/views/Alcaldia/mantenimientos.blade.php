@extends('adminlte::page')
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

            #ajustes_wrapper {
                overflow-x: auto;
            }
            /*Con esta instruccion css funcionaran nuestras class hidden.*/
            .hidden {
                display: none;
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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <?php
                $authController = app(\App\Http\Controllers\AuthController::class);
                $objeto = 'MANTENIMIENTOS'; // Por ejemplo, el objeto deseado
                $rol = session('user_data')['NOM_ROL'];
                $tienePermiso = $authController->tienePermiso($rol, $objeto);
            ?>

        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")

            <center><br>
                <h1>Información de Mantenimientos</h1>
            </center></br>
            

        @section('content')
        @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
            <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#Mantenimientos">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <div class="text-center">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        </div>
        @endif
            <div class="modal fade bd-example-modal-sm" id="Mantenimientos" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo mantenimiento</h5>
                            <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('Mantenimientos/insertar') }}" method="post" class="needs-validation mantenimiento-form">
                                @csrf
                                    
                                <div class="mb-3">
                                    <label for="FEC_HR_MANTENIMIENTO">Fecha/Hora:</label>
                                    <input type="datetime-local" id="FEC_HR_MANTENIMIENTO" class="form-control" name="FEC_HR_MANTENIMIENTO" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                    <div class="mb-3 mt-3">
                                        <label for="TIP_MANTENIMIENTO">Tipo:</label>
                                        <select class="form-select custom-select" id="TIP_MANTENIMIENTO" name="TIP_MANTENIMIENTO" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="Mantenimiento predictivo">Mantenimiento predictivo</option>
                                            <option value="Mantenimiento preventivo">Mantenimiento preventivo</option>
                                            <option value="Mantenimiento correctivo">Mantenimiento correctivo</option>
                                            <option value="Mantenimiento evolutivo">Mantenimiento evolutivo</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label for="DES_MANTENIMIENTO">Descripción:</label>
                                        <input type="text" id="DES_MANTENIMIENTO" class="form-control" name="DES_MANTENIMIENTO" placeholder="Ingresar la descripción del mantenimiento" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NOM_USUARIOL">Usuario:</label>
                                        <input type="text" id="NOM_USUARIO" class="form-control" name="MON_USUARIO" placeholder="Ingresar el usuario" oninput="this.value = this.value.toUpperCase(); buscarUsuario(this.value)" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NOMREALUSUARIO">Nombre:</label>
                                        <input type="text" readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" id="COD_USUARIO" class="form-control" name="COD_USUARIO" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="MON_MANTENIMIENTO">Monto:</label>
                                        <input type="number" prefix="L. " id="MON_MANTENIMIENTO" class="form-control" name="MON_MANTENIMIENTO" placeholder="Ingrese el costo del mantenimiento" min="1" step="any" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                    <button class="btn btn-primary" id="btnGuardar" type="submit" disabled>Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                //VALIDACIONES
                                var fechaHoraInput = document.getElementById("FEC_HR_MANTENIMIENTO");
                                var desMantenimientoInput = document.getElementById("DES_MANTENIMIENTO");
                                var montoInput = document.getElementById("MON_MANTENIMIENTO");
                                var btnGuardar = document.getElementById("btnGuardar");

                                desMantenimientoInput.addEventListener("input", function() {
                                    var descripcion = this.value;
                                    var errorMessage = '';

                                    if (descripcion.length < 5) {
                                        errorMessage = 'La descripción debe tener al menos 5 carácteres.';
                                    } else if (descripcion.length > 100) {
                                        errorMessage = 'La descripción no puede tener más de 100 carácteres.';
                                    }

                                    if (errorMessage) {
                                        this.classList.add("is-invalid");
                                        this.nextElementSibling.textContent = errorMessage;
                                        btnGuardar.disabled = true;
                                    } else {
                                        this.classList.remove("is-invalid");
                                        this.nextElementSibling.textContent = "";
                                        btnGuardar.disabled = false;
                                    }
                                });

                                fechaHoraInput.addEventListener("change", function() {
                                    // Obtener la fecha y hora actual
                                    var currentDate = new Date();
                                    // Obtener el valor del campo FEC_HR_MANTENIMIENTO
                                    var selectedDate = new Date(this.value);
                                    
                                    // Comparar con la fecha y hora actual
                                    if (selectedDate < currentDate) {
                                        // Si la fecha seleccionada es anterior a la actual, mostrar un mensaje de error
                                        this.classList.add("is-invalid");
                                        this.nextElementSibling.textContent = "La fecha y hora no puede ser anterior a la actual.";
                                        btnGuardar.disabled = true; // Deshabilitar el botón de guardar
                                    } else {
                                        // Si la fecha seleccionada es válida, eliminar cualquier mensaje de error
                                        this.classList.remove("is-invalid");
                                        this.nextElementSibling.textContent = "";
                                        btnGuardar.disabled = false; // Habilitar el botón de guardar
                                    }
                                });
                                montoInput.addEventListener("input", function() {
                                    // Utilizar una expresión regular para validar números con hasta 8 dígitos y 2 decimales
                                    var regex = /^\d{1,6}(?:\.\d{1,2})?$/;
                                    var inputValue = this.value;

                                    if (!regex.test(inputValue)) {
                                        // Si no coincide con el patrón, mostrar un mensaje de error
                                        this.classList.add("is-invalid");
                                        this.nextElementSibling.textContent = "Ingrese un monto válido con hasta 8 dígitos y 2 decimales.";
                                        btnGuardar.disabled = true; // Deshabilitar el botón de guardar
                                    } else {
                                        // Si es un número válido, eliminar cualquier mensaje de error
                                        this.classList.remove("is-invalid");
                                        this.nextElementSibling.textContent = "";
                                        btnGuardar.disabled = false; // Habilitar el botón de guardar
                                    }
                                });
                                //Función para buscar usuarios.
                                function buscarUsuario(usuario) {
                                    var usuariosArreglo = <?php echo json_encode($userArreglo); ?>;
                                    var usuarioEncontrado = false;

                                    if(usuario){
                                        // Itera sobre el arreglo de usuarios en JavaScript (asumiendo que es un arreglo de objetos)
                                        for (var i = 0; i < usuariosArreglo.length; i++) {
                                            if (usuariosArreglo[i].NOM_USUARIO == usuario) {
                                                usuarioEncontrado = true;
                                                $('#NOM_PERSONA').val(usuariosArreglo[i].NOM_PERSONA);
                                                $('#COD_USUARIO').val(usuariosArreglo[i].COD_USUARIO);
                                                break;
                                            }
                                        }

                                        if (!usuarioEncontrado) {
                                            usuarioEncontrado = false;
                                            $('#NOM_PERSONA').val('Usuario no encontrado');
                                            $('#COD_USUARIO').val('');
                                        }

                                    }else{
                                        usuarioEncontrado = false;
                                        $('#NOM_PERSONA').val('');
                                        $('#COD_USUARIO').val('');
                                    }
                                };
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
                                //Funcion de limpiar el formulario al momento que le demos al botón de cancelar
                                function limpiarFormulario() {
                                    document.getElementById("FEC_HR_MANTENIMIENTO").value = "";
                                    document.getElementById("TIP_MANTENIMIENTO").value = "";
                                    document.getElementById("DES_MANTENIMIENTO").value = "";
                                    document.getElementById("COD_USUARIO").value = "";
                                    document.getElementById("MON_MANTENIMIENTO").value = "";
                                    
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
                        <table width=100% cellspacing="7" cellpadding="7" class="table table-hover table-bordered mt-1" id="ajustes">
                        <thead>
                            <th><center>Nº</center></th>
                            <th><center>Fecha Registro</center></th>
                            <th><center>Fecha/Hora</center></th>
                            <th><center>Tipo</center></th>
                            <th><center>Descripción</center></th>
                            <th class="hidden">Nº</th>
                            <th><center>Usuario</center></th>
                            <th><center>Monto</center></th>
                            <th><center><i class="fas fa-cog"></i></center></th>
                        </thead>
                        <tbody>
                            <!-- Loop through $citaArreglo and show data -->
                            @foreach($citaArreglo as $Mantenimientos)
                            @php
                                $usuario = null;
                                foreach ($userArreglo as $user) {
                                    if ($user['COD_USUARIO'] === $Mantenimientos['COD_USUARIO']) {
                                        $usuario = $user;
                                        break;
                                    }
                                }
                            @endphp
                                <tr>
                                    <td>{{$Mantenimientos['COD_MANTENIMIENTO']}}</td>
                                    <td>{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_REG_MANTENIMIENTO']))}}</td>   
                                    <td>{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_HR_MANTENIMIENTO']))}}</td> 
                                    <td>{{$Mantenimientos['TIP_MANTENIMIENTO']}}</td>
                                    <td>{{$Mantenimientos['DES_MANTENIMIENTO']}}</td>
                                    <td class="hidden">{{$Mantenimientos['COD_USUARIO']}}</td>
                                    <td>{{$Mantenimientos['NOMBRE_USUARIO']}}</td>
                                    <td>L. {{$Mantenimientos['MON_MANTENIMIENTO']}}</td>
                                    <td>
                                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                        <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Mantenimientos-edit-{{$Mantenimientos['COD_MANTENIMIENTO']}}">
                                            <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                        </button>
                                    @endif
                                    </td>
                                </tr>
                                <!-- Modal for editing goes here -->
                                <div class="modal fade bd-example-modal-sm" id="Mantenimientos-edit-{{$Mantenimientos['COD_MANTENIMIENTO']}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Actualizar datos del mantenimiento</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Mantenimientos/actualizar') }}" method="post" class="needs-validation">
                                                    @csrf
                                                        <input type="hidden" class="form-control" name="COD_MANTENIMIENTO" value="{{$Mantenimientos['COD_MANTENIMIENTO']}}">
                                                        
                                                        <div class="mb-3">
                                                            <label for="FEC_HR_MANTENIMIENTO">Fecha/Hora:</label>
                                                            <?php $fecha_formateada = date('Y-m-d\TH:i', strtotime($Mantenimientos['FEC_HR_MANTENIMIENTO'])); ?>    
                                                            <input type="datetime-local" class="form-control" id="FEC_HR_MANTENIMIENTO" name="FEC_HR_MANTENIMIENTO" value="{{ $fecha_formateada }}" min="{{ date('Y-m-d\TH:i', time()) }}" required>
                                                            <!-- La etiqueta "min" nos ayuda a que no esten disponibles a elección fechas 
                                                            que sean anteriores a la fecha actual (en la que se realiza el cambio).-->
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="LTIP_MANTENIMIENTO">Tipo:</label>
                                                            <select class="form-select custom-select" id="TIP_MANTENIMIENTO" name="TIP_MANTENIMIENTO" required>
                                                                <option value="Mantenimiento predictivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_predictivo') selected @endif>Mantenimiento predictivo</option>
                                                                <option value="Mantenimiento preventivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_preventivo') selected @endif>Mantenimiento preventivo</option>
                                                                <option value="Mantenimiento correctivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_correctivo') selected @endif>Mantenimiento correctivo</option>
                                                                <option value="Mantenimiento evolutivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_evolutivo') selected @endif>Mantenimiento evolutivo</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="LDES_MANTENIMIENTO">Descripción:</label>
                                                            <input type="text" class="form-control" id="LDES_MANTENIMIENTO-{{$Mantenimientos['COD_MANTENIMIENTO']}}" name="DES_MANTENIMIENTO" value="{{$Mantenimientos['DES_MANTENIMIENTO']}}" oninput="validarDescripcion('{{$Mantenimientos['COD_MANTENIMIENTO']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback-{{$Mantenimientos['COD_MANTENIMIENTO']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="USUARIOL">Usuario:</label>
                                                            <input type="text" class="form-control" id="NOM_USUARIO-{{$Mantenimientos['COD_MANTENIMIENTO']}}"  name="NOM_USUARIO" oninput="this.value = this.value.toUpperCase(); buscarUsuario2('{{$Mantenimientos['COD_MANTENIMIENTO']}}', this.value)" >
                                                            <div class="invalid-feedback"  id="invalid-feedback2-{{$Mantenimientos['COD_MANTENIMIENTO']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="NOMREALUSUARIO">Nombre:</label>
                                                            <input type="text" readonly id="NOM_PERSONA-{{$Mantenimientos['COD_MANTENIMIENTO']}}" class="form-control" name="NOM_PERSONA" value="{{$usuario['NOM_PERSONA']}}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input type="hidden" class="form-control" id="COD_USUARIO-{{$Mantenimientos['COD_MANTENIMIENTO']}}"  name="COD_USUARIO" value="{{$Mantenimientos['COD_USUARIO']}}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="LMON_MANTENIMIENTO">Monto:</label>
                                                            <input type="number" prefix="L. " class="form-control" id="MON_MANTENIMIENTO-{{$Mantenimientos['COD_MANTENIMIENTO']}}" name="MON_MANTENIMIENTO" value="{{$Mantenimientos['MON_MANTENIMIENTO']}}" oninput="validarMonto('{{$Mantenimientos['COD_MANTENIMIENTO']}}', this.value)" min="1" step="any" required>
                                                            <div class="invalid-feedback" id="invalid-feedback3-{{$Mantenimientos['COD_MANTENIMIENTO']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <button class="btn btn-primary" id="submitButton-{{$Mantenimientos['COD_MANTENIMIENTO']}}" type="submit">Guardar</button>
                                                            <a href="{{ url('Mantenimientos') }}" class="btn btn-danger">Cancelar</a>
                                                        </div>
                                                </form>
                                                <script>
                                                    //Función para buscar usuarios.
                                                    function buscarUsuario2(id, usuario) {
                                                        var usuariosArreglo = <?php echo json_encode($userArreglo); ?>;
                                                        var usuarioEncontrado = false;

                                                        if(usuario){
                                                            // Itera sobre el arreglo de usuarios en JavaScript (asumiendo que es un arreglo de objetos)
                                                            for (var i = 0; i < usuariosArreglo.length; i++) {
                                                                if (usuariosArreglo[i].NOM_USUARIO == usuario) {
                                                                    usuarioEncontrado = true;
                                                                    $('#NOM_PERSONA-'+id).val(usuariosArreglo[i].NOM_PERSONA);
                                                                    $('#COD_USUARIO-'+id).val(usuariosArreglo[i].COD_USUARIO);
                                                                    break;
                                                                }
                                                            }

                                                            if (!usuarioEncontrado) {
                                                                usuarioEncontrado = false;
                                                                $('#NOM_PERSONA-'+id).val('Usuario no encontrado');
                                                                $('#COD_USUARIO-'+id).val('');
                                                            }

                                                        }else{
                                                            usuarioEncontrado = false;
                                                            $('#NOM_PERSONA-'+id).val('');
                                                            $('#COD_USUARIO-'+id).val('');
                                                        }
                                                    };
                                                    
                                                    function validarDescripcion(id, des_mantenimiento) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("LDES_MANTENIMIENTO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback-" + id);

                                                        if (des_mantenimiento.length < 5) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La descripción debe tener al menos 5 caracteres.";
                                                            btnGuardar.disabled = true;
                                                        } else if (des_mantenimiento.length > 100) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La descripción no puede tener más de 100 carácteres.";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    }

                                                    function validarMonto(id, monto) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement  = document.getElementById("MON_MANTENIMIENTO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback3-" + id);
                                                        
                                                        // Utilizar una expresión regular para validar números con hasta 8 dígitos y 2 decimales
                                                        var regex = /^\d{1,6}(?:\.\d{1,2})?$/;
                                                        if (!regex.test(monto)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "Ingrese un monto válido con hasta 8 dígitos y 2 decimales.";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
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
            @if(session('notification'))
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            Swal.fire({
                                icon: '{{ session('notification')['type'] }}',
                                title: '{{ session('notification')['title'] }}',
                                text: '{{ session('notification')['message'] }}',
                            });
                        </script>
            @endif
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
                    $(document).ready(function() {
                        $('#ajustes').DataTable({
                            responsive: true,
                            dom: "Bfrtilp",
                                    buttons: [//Botones de Excel, PDF, Imprimir
                                        {
                                            extend: "excelHtml5",
                                            text: "<i class='fa-solid fa-file-excel'></i>",
                                            tittleAttr: "Exportar a Excel",
                                            className: "btn btn-success",
                                            exportOptions: {
                                                columns: ":visible" // Exportar todas las columnas visibles
                                            },
                                            filename: "Mantenimientos_Talanga", // Nombre personalizado para el archivo Excel
                                            title: "Programación Mantenimientos del Sistema",
                                        },
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


