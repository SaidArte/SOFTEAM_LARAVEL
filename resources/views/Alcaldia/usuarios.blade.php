@extends('adminlte::page')

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
            /*Con esta instruccion css funcionaran nuestras class hidden.*/
            .hidden {
                display: none;
            }

            /*Estilos para icono de ojo*/
            .eye-icon {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                cursor: pointer;
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
                $objeto = 'USUARIOS'; // Por ejemplo, el objeto deseado
                $rol = session('user_data')['NOM_ROL'];
                $tienePermiso = $authController->tienePermiso($rol, $objeto);
            ?>
             @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
                <center><br>
                    <h1>Información de Usuarios</h1>
                </center></br>
                
            @stop

            @section('content')
                @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
                    <p align="right">
                        <button type="button" class="Btn" data-toggle="modal" data-target="#Usuarios">
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
                    <div class="modal fade bd-example-modal-sm" id="Usuarios" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ingresar un nuevo usuario</h5>
                                    <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('Usuarios/insertar') }}" method="post">
                                        @csrf
                                            
                                            <div class="mb-3 mt-3">
                                                <label for="NOM_ROL">Rol</label>
                                                <select class="form-select custom-select" id="NOM_ROL" name="NOM_ROL" required>
                                                    <option value="" disabled selected>Seleccione una opción</option>
                                                    @foreach ($rolesArreglo as $roles)
                                                        <option value="{{$roles['NOM_ROL']}}">{{$roles['NOM_ROL']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id">DNI</label>
                                                <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese el número de identidad" oninput="buscarPersona(this.value)" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nom">Nombre</label>
                                                <input type="text" readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" readonly id="COD_PERSONA" class="form-control" name="COD_PERSONA">
                                            </div>
                                            <div class="mb-3">
                                                <label for="NOM_USUARIO">Usuario</label>
                                                <input type="text" id="NOM_USUARIO" class="form-control" name="NOM_USUARIO" placeholder="Ingresar el alias del usuario" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="PAS_USUARIOL" class="form-label">Contraseña</label>
                                                <div class="form-group position-relative">
                                                    <input type="password" id="PAS_USUARIO" class="form-control" name="PAS_USUARIO" placeholder="Ingresar una contraseña" required>
                                                    <span class="eye-icon" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                                                    <div id="password-feedback" class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="IND_USUARIO">Estado</label>
                                                <select class="form-select custom-select" id="IND_USUARIO" name="IND_USUARIO" required>
                                                    <option value="" disabled selected>Seleccione una opción</option>
                                                    <option value="ACTIVO">ACTIVO</option>
                                                    <option value="INACTIVO">INACTIVO</option>
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary" id="submitButton" disabled>Guardar</button>
                                                <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            </div>
                                    </form>
                                    <script>
                                        //Validaciones para el usuario
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const nomUsuarioInput = document.getElementById("NOM_USUARIO");
                                            var btnGuardar = document.getElementById("submitButton");  // Obtener el botón de guardar.
                                            
                                            nomUsuarioInput.addEventListener("input", function() {
                                                // Convertir a mayúsculas
                                                this.value = this.value.toUpperCase();
                                                
                                                // Quitar espacios y caracteres especiales
                                                this.value = this.value.replace(/[^A-Z0-9]/g, "");

                                                // Validar la longitud y mostrar mensajes de error
                                                if (this.value.length === 0) {
                                                    $(this).addClass('is-invalid');
                                                    $(this).siblings('.invalid-feedback').text('Favor, ingrese un nombre de usuario.');
                                                    btnGuardar.disabled = true;
                                                } else if (this.value.length < 4 || this.value.length > 20) {
                                                    $(this).addClass('is-invalid');
                                                    $(this).siblings('.invalid-feedback').text('Favor, ingrese un nombre de usuario no menor de 5 caracteres y no mayor de 20.');
                                                    btnGuardar.disabled = true;
                                                } else {
                                                    $(this).removeClass('is-invalid');
                                                    $(this).siblings('.invalid-feedback').text('');
                                                    btnGuardar.disabled = false;
                                                }
                                            });
                                        });

                                        
                                        $(document).ready(function() {
                                            //Validaciones del campo nombre el cual no permite el ingreso de números (las bloquea y no se muestra)
                                            //y solo permite el ingreso de numeros
                                            $('#dni').on('input', function() {
                                                var btnGuardar = document.getElementById("submitButton");  // Obtener el botón de guardar.
                                                var id = $(this).val().replace(/\D/g, ''); // Mantener solo numéricos y eliminar letras y simbolos.
                                                $(this).val(id); // Actualizar el valor del campo solo con números
                                                var errorMessage = 'Favor, ingrese una identificación valida';
                                                if (id.length == '') {
                                                    $(this).addClass('is-invalid');
                                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                                    btnGuardar.disabled = true;
                                                } else if(id.length !== 13) {
                                                    errorMessage = 'El DNI debe tener exactamente 13 dígitos numéricos.';
                                                    $(this).addClass('is-invalid');
                                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                                    btnGuardar.disabled = true;
                                                } else {
                                                    $(this).removeClass('is-invalid');
                                                    $(this).siblings('.invalid-feedback').text('');
                                                    btnGuardar.disabled = false;
                                                }
                                            });
                                            //Validaciones de la Contraseña
                                            const passwordInput = document.getElementById('PAS_USUARIO');
                                            const passwordFeedback = document.getElementById('password-feedback');

                                            passwordInput.addEventListener('input', () => {
                                                const password = passwordInput.value;
                                                var btnGuardar = document.getElementById("submitButton");  // Obtener el botón de guardar

                                                // Validaciones
                                                if (password.length < 8 || password.length > 40) {
                                                    passwordInput.classList.add('is-invalid');
                                                    passwordFeedback.textContent = 'La contraseña debe tener al menos 8 caracteres, y no más de 40.';
                                                    btnGuardar.disabled = true;
                                                } else if (!/[A-Z]/.test(password)) {
                                                    passwordInput.classList.add('is-invalid');
                                                    passwordFeedback.textContent = 'La contraseña debe contener al menos una letra mayúscula.';
                                                    btnGuardar.disabled = true;
                                                } else if (!/[0-9]/.test(password)) {
                                                    passwordInput.classList.add('is-invalid');
                                                    passwordFeedback.textContent = 'La contraseña debe contener al menos un número.';
                                                    btnGuardar.disabled = true;
                                                } else if (!/[!@#$%^&*]/.test(password)) {
                                                    passwordInput.classList.add('is-invalid');
                                                    passwordFeedback.textContent = 'La contraseña debe contener al menos un carácter especial (!@#$%^&*).';
                                                    btnGuardar.disabled = true;
                                                } else if (/\s/.test(password)) {
                                                    passwordInput.classList.add('is-invalid');
                                                    passwordFeedback.textContent = 'La contraseña no debe contener espacios.';
                                                    btnGuardar.disabled = true;
                                                } else {
                                                    passwordInput.classList.remove('is-invalid');
                                                    passwordFeedback.textContent = '';
                                                    btnGuardar.disabled = false;
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
                                        
                                        //Función de ocultar/mostrar password
                                        function togglePasswordVisibility() {
                                            var passwordInput = document.getElementById("PAS_USUARIO");
                                            var toggleIcon = document.querySelector(".eye-icon i");

                                            if (passwordInput.type === "password") {
                                                passwordInput.type = "text";
                                                toggleIcon.classList.remove("fa-eye");
                                                toggleIcon.classList.add("fa-eye-slash");
                                            } else {
                                                passwordInput.type = "password";
                                                toggleIcon.classList.remove("fa-eye-slash");
                                                toggleIcon.classList.add("fa-eye");
                                            }
                                        }

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
                                            document.getElementById("NOM_ROL").value = "";
                                            document.getElementById("COD_PERSONA").value = "";
                                            document.getElementById("NOM_PERSONA").value = "";
                                            document.getElementById("NOM_USUARIO").value = "";
                                            document.getElementById("PAS_USUARIO").value = "";
                                            document.getElementById("IND_USUARIO").value = "";

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
                                        // Mostrar el modal de registro exitoso cuando se envíe el formulario
                                        $('#Usuarios form').submit(function() {
                                            $('#registroExitosoModal').modal('show');
                                        });    
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="card">
                    <div class="card-body">
                        <table width=100% cellspacing="8" cellpadding="8" class="table table-hover ttable-bordered mt-1" id="usuarios">
                            <thead>
                                <tr>
                                    <th><center>Nº</center></th>
                                    <th><center>Usuario</center></th>
                                    <th><center>Nombre</center></th>
                                    <th><center>Rol</center></th>
                                    <th><center>Último Acceso</center></th>
                                    <th class="hidden"><center>Límite Intentos</center></th>
                                    <th class="hidden"><center>Intentos Fallidos</center></th>
                                    <th><center>F. Vencimiento</center></th>
                                    <th><center>Estado</center></th>
                                    <th><center><i class="fas fa-cog"></i></center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through $citaArreglo and show data -->
                                @foreach($citaArreglo as $Usuarios)
                                    <tr>
                                        <td>{{$Usuarios['COD_USUARIO']}}</td>
                                        <td>{{$Usuarios['NOM_USUARIO']}}</td>
                                        <td>{{$Usuarios['NOM_PERSONA']}}</td>   
                                        <td>{{$Usuarios['NOM_ROL']}}</td> 
                                        <td>{{date('d-m-Y h:i:s', strtotime($Usuarios['FEC_ULTIMO_ACCESO']))}}</td>
                                        <td class="hidden">{{$Usuarios['LIM_INTENTOS']}}</td>
                                        <td class="hidden">{{$Usuarios['NUM_INTENTOS_FALLIDOS']}}</td>
                                        <td>{{date('d-m-y', strtotime($Usuarios['FEC_VENCIMIENTO']))}}</td>
                                        <td>{{$Usuarios['IND_USUARIO']}}</td>
                                        <td>
                                            @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                                <!-- Boton de Editar -->
                                                <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Usuarios-edit-{{$Usuarios['COD_USUARIO']}}">
                                                    <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Modal for editing goes here -->
                                    <div class="modal fade bd-example-modal-sm" id="Usuarios-edit-{{$Usuarios['COD_USUARIO']}}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Actualizar datos del usuario</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ url('Usuarios/actualizar') }}" method="post" class="row g-3 needs-validation">
                                                        @csrf
                                                            <input type="hidden" class="form-control" name="COD_USUARIO" value="{{$Usuarios['COD_USUARIO']}}">
                                                            
                                                            <div class="mb-3">
                                                                <label for="Usuarios">Usuario</label>
                                                                <input type="text" class="form-control" id="NOM_USUARIO-{{$Usuarios['COD_USUARIO']}}" name="NOM_USUARIO" placeholder="Ingrese el alias del usuario" value="{{$Usuarios['NOM_USUARIO']}}" oninput="validarUsuario('{{$Usuarios['COD_USUARIO']}}', this.value)" required>
                                                                <div class="invalid-feedback" id="invalid-feedback-{{$Usuarios['COD_USUARIO']}}"></div>
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="Usuarios">Rol</label>
                                                                <select class="form-select custom-select" id="NOM_ROL" name="NOM_ROL" required>
                                                                    <option value="" disabled selected>Seleccione una opción</option>
                                                                    @foreach ($rolesArreglo as $roles)
                                                                        <option value="{{$roles['NOM_ROL']}}" @if ($roles['NOM_ROL'] == $Usuarios['NOM_ROL']) selected @endif>
                                                                            {{$roles['NOM_ROL']}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nIntentos">No. intentos</label>
                                                                <input type="text" readonly class="form-control" id="LIM_INTENTOS-{{$Usuarios['COD_USUARIO']}}" name="LIM_INTENTOS" value="{{$Usuarios['LIM_INTENTOS']}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nIntentosF">Intentos fallidos</label>
                                                                <input type="text" readonly class="form-control" id="NUM_INTENTOS_FALLIDOS-{{$Usuarios['COD_USUARIO']}}" name="NUM_INTENTOS_FALLIDOS" value="{{$Usuarios['NUM_INTENTOS_FALLIDOS']}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="FEC_VEN">Fecha vencimiento</label>
                                                                <?php $fecha_formateada = date('Y-m-d', strtotime($Usuarios['FEC_VENCIMIENTO'])); ?>    
                                                                <input type="date" class="form-control" id="FEC_VENCIMIENTO" name="FEC_VENCIMIENTO" value="{{ $fecha_formateada }}" min="{{ date('Y-m-d', time()) }}" required>
                                                                <!-- La etiqueta "min" nos ayuda a que no esten disponibles a elección fechas 
                                                                que sean anteriores a la fecha actual (en la que se realiza el cambio).-->
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="Usuarios">Estado</label>
                                                                <select class="form-select custom-select" id="IND_USUARIO" name="IND_USUARIO" value="{{$Usuarios['IND_USUARIO']}}" required>
                                                                    <option value="X" selected = "selected" disabled>- Elija un estado -</option>
                                                                    <option value="ACTIVO" @if($Usuarios['IND_USUARIO'] === 'ACTIVO') selected @endif>ACTIVO</option>
                                                                    <option value="INACTIVO" @if($Usuarios['IND_USUARIO'] === 'INACTIVO') selected @endif>INACTIVO</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <button type="submit" class="btn btn-primary" id="submitButton-{{$Usuarios['COD_USUARIO']}}">Guardar</button>
                                                                <a href="{{ url('Usuarios') }}" class="btn btn-danger">Cancelar</a>
                                                            </div>
                                                    </form>
                                                    <script>
                                                        function validarUsuario(id, usuario) {
                                                            var btnGuardar = document.getElementById("submitButton-" + id);
                                                            var inputElement = document.getElementById("NOM_USUARIO-" + id);
                                                            var invalidFeedback = document.getElementById("invalid-feedback-" + id);

                                                            // Convertir a mayúsculas
                                                            inputElement.value = inputElement.value.toUpperCase();
                                                            // Quitar espacios y caracteres especiales
                                                            inputElement.value = inputElement.value.replace(/[^A-Z0-9]/g, "");
                                                            if (usuario.length === 0) {
                                                                inputElement.classList.add("is-invalid");
                                                                invalidFeedback.textContent = "Favor, ingrese un nombre de usuario.";
                                                                btnGuardar.disabled = true;
                                                            } else if (usuario.length < 4 || usuario.length > 20) {
                                                                inputElement.classList.add("is-invalid");
                                                                invalidFeedback.textContent = "Favor, ingrese un nombre de usuario no menor de 5 caracteres y no mayor de 20.";
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

            @section('js')
            <script> console.log('Hi!'); </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#usuarios').DataTable({
                                responsive: true,
                                lengthMenu : [10, 20, 30, 40, 50],
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

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
            @stop

            @section('css')
                <link rel="stylesheet" href="/css/admin_custom.css">
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

