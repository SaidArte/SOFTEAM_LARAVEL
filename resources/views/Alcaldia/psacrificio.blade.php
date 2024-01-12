@extends('adminlte::page')

@section('title', 'Alcaldia')

@section('plugins.Sweetalert2', true)

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
        <?php
            $authController = app(\App\Http\Controllers\AuthController::class);
            $objeto = 'PSACRIFICIO'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <center><br>
            <h1>Información Permisos de Sacrificio</h1>
        </center></br>

        @section('content')
            <!-- Boton Nuevo -->
            @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
            <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#psacrificio">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
            @endif
            
            <div class="modal fade bd-example-modal-sm" id="psacrificio" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Nuevo Permiso de Sacrificio</h5>
                        </div>
                        
                        <div class="modal-body">
                            <!-- Inicio del nuevo formulario -->
                            <form action="{{ url('psacrificio/insertar') }}" method="post" enctype="multipart/form-data" class="needs-validation psacrificio-form">

                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="IMG_ANIMAL">Imágen:</label>
                                                <input type="file" class="form-control" id="IMG_ANIMAL" name="IMG_ANIMAL" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="NOM_PERSONA">Nombre Completo</label>
                                            <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre completo de la persona" required>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="DNI_PERSONA">Identidad</label>
                                            <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" required>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="TEL_PERSONA">Teléfono</label>
                                            <input type="text" id="TEL_PERSONA" class="form-control" name="TEL_PERSONA" placeholder="0000-0000" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="FEC_SACRIFICIO">Fecha Sacrificio</label>
                                            <input type="date" id="FEC_SACRIFICIO" class="form-control" name="FEC_SACRIFICIO" placeholder="Inserte la fecha del sacrificio" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ANIMALL">Tipo Animal</label>
                                            <select class="form-select custom-select" id="ANIMAL" name="ANIMAL" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Vaca">Vaca</option>
                                                <option value="Caballo">Caballo</option>
                                                <option value="Cerdo">Cerdo</option>
                                                <option value="Burro">Burro</option>
                                                <option value="Mula">Mula</option>
                                                <option value="Yegua">Yegua</option>
                                                <option value="Toro">Toro</option>
                                                <option value="Res">Res</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="COL_ANIMALL">Color Animal</label>
                                            <input type="text" id="COL_ANIMAL" class="form-control" name="COL_ANIMAL" placeholder="Ingrese color del animal" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-sm-13 mb-3">
                                            <div class="form-group">
                                                <label for="DIR_PSACRIFICIO">Dirección Sacrificio</label>
                                                <textarea id="DIR_PSACRIFICIO" rows="5" class="form-control" name="DIR_PSACRIFICIO" placeholder="Ingrese una dirección" required></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>

                            <script>
                                $(document).ready(function() {
                                    // Validaciones del nombre persona, no permite que se ingresen números ni caracteres especiales
                                    $('#NOM_PERSONA').on('keydown', function(e) {
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
                                    var nombreInput = $('#NOM_PERSONA');
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
                                    $('#DNI_PERSONA').on('input', function() {
                                        var dni = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                        $(this).val(dni); // Actualizar el valor del campo solo con números
                                        var errorMessage = 'El DNI debe tener exactamente 13 dígitos numéricos ';
                                        if (dni.length !== 13) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    //Validaciones del campo Telefono en el cual no permite el ingreso de letras (las bloquea y no se muestra)
                                    //y solo permite el ingreso de numeros
                                    $('#TEL_PERSONA').on('input', function() {
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
                                    //Validaciones del campo Fecha Registro el cual no permitira el ingreso de una fecha anterior al dia de registro
                                    $('#FEC_SACRIFICIO').on('input', function() {
                                        var fechaSacrificio = $(this).val();
                                        var currentDate = new Date().toISOString().split('T')[0];
                                        var errorMessage = 'La fecha debe ser válida y no puede ser anterior a hoy';
                                        
                                        if (!fechaSacrificio || fechaSacrificio < currentDate) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    //
                                    $('#COD_ANIMAL').on('input', function() {
                                        var codigoAnimal = $(this).val();
                                        // Implementar la lógica para verificar si el código ya existe y 
                                        //mostrar el mensaje de error correspondiente si ya está en uso.
                                    });
                                    //validaciones de direccion
                                    $('#DIR_PSACRIFICIO').on('input', function() {
                                        var direccionSacrificio = $(this).val();
                                        var errorMessage = '';

                                        // Validar que la dirección tenga al menos 5 caracteres
                                        if (direccionSacrificio.length < 5) {
                                            errorMessage = 'La dirección debe tener al menos 5 caracteres';
                                        }

                                        // Validar que no se ingresen más de 100 caracteres
                                        if (direccionSacrificio.length > 100) {
                                            errorMessage = 'El máximo de caracteres permitidos es 100';
                                            $(this).val(direccionSacrificio.substring(0, 100)); // Limitar a 100 caracteres
                                        }


                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#COL_ANIMAL').on('input', function() {
                                        var input = $(this).val();
                                        var errorMessage = '';
                                        var maxLength = 20;

                                        // Validar la longitud mínima y máxima
                                        if (input.length < 4) {
                                            errorMessage = 'El color debe tener al menos 4 caracteres.';
                                        } else if (input.length > maxLength) {
                                            errorMessage = 'El color no puede tener más de ' + maxLength + ' caracteres.';
                                            $(this).val(input.substring(0, maxLength)); // Limitar a maxLength caracteres
                                        }

                                        // Validar que no se ingresen números
                                        if (/^\d+$/.test(input)) {
                                            errorMessage = 'No se aceptan números.';
                                        }

                                        // Validar que no se ingresen caracteres especiales, excepto espacios
                                        var specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
                                        if (specialChars.test(input) || /\d/.test(input)) {
                                            errorMessage = 'No se aceptan caracteres especiales ni números.';
                                            $(this).val(input.replace(/[^\s]+/g, '')); // Eliminar caracteres especiales y números
                                        }

                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });

                                });
                                // Deshabilita el botón de enviar inicialmente
                                $('form.needs-validation').find('button[type="submit"]').prop('disabled', true);

                                // Habilita o deshabilita el botón de enviar según la validez del formulario
                                $('form.needs-validation').on('input change', function() {
                                    var esValido = true;

                                    $(this).find('.form-control').each(function() {
                                        if ($(this).hasClass('is-invalid') || $(this).val().trim() === '') {
                                            esValido = false;
                                            return false; // Sale del bucle si encuentra un campo no válido
                                        }
                                    });

                                    $(this).find('button[type="submit"]').prop('disabled', !esValido);
                                });
                                //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                                function limpiarFormulario() {
                                    document.getElementById("IMG_ANIMAL").value = "";
                                    document.getElementById("NOM_PERSONA").value = "";
                                    document.getElementById("DNI_PERSONA").value = "";
                                    document.getElementById("TEL_PERSONA").value = "";
                                    document.getElementById("FEC_SACRIFICIO").value = "";
                                    document.getElementById("ANIMAL").value = ""; // Agregué el identificador correcto para el campo ANIMAL
                                    document.getElementById("COL_ANIMAL").value = "";
                                    document.getElementById("DIR_PSACRIFICIO").value = "";

                                    // Limpia los mensajes de validación
                                    const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
                                    invalidFeedbackElements.forEach(element => {
                                        element.textContent = "";
                                    });

                                    // Remueve la clase is-invalid de todos los campos
                                    const invalidFields = document.querySelectorAll(".form-control.is-invalid");
                                    invalidFields.forEach(field => {
                                        field.classList.remove("is-invalid");
                                    });
                                }
                                document.getElementById("btnCancelar").addEventListener("click", function() {
                                    limpiarFormulario();
                                    // Cierra el modal manualmente
                                    $('#psacrificio').modal('hide');
                                    // Redirige a la página principal después de cerrar el modal
                                    window.location.href = '/psacrificio';
                                });
                                  // Agregar una clase de CSS para mostrar la notificación flotante
                                  function showSuccessMessage() {
                                    const successMessage = document.createElement('div');
                                    successMessage.className = 'success-message';
                                    successMessage.textContent = 'Registro Exitoso';

                                    document.body.appendChild(successMessage);

                                    setTimeout(() => {
                                        successMessage.remove();
                                    }, 4000); // La notificación desaparecerá después de 4 segundos (puedes ajustar este valor)
                                }

                                // Función que se ejecutará después de enviar el formulario
                                function formSubmitHandler() {
                                    showSuccessMessage();
                                }
                                document.querySelector('.psacrificio-form').addEventListener('submit', formSubmitHandler);     
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Inicio de la tabla -->
                    <table  width="100%" cellspacing="8 " cellpadding="8" class="table table-hover table-bordered mt-1" id="sacrificio">
                    <thead>
                            <tr>
                                <th>Nº</th>
                                <th><center>Nombre</center></th>
                                <th><center>Identidad</center></th>
                                <th><center>Teléfono</center></th>
                                <th><center>Fecha</center></th>
                                <th><center>Dirección</center></th>
                                <th><center>Animal</center></th>
                                <th><center>Color</center></th>
                                <th><center>Foto</center></th>
                                
                                <th><center>Opción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through $citaArreglo and show data -->
                            @foreach($citaArreglo as $psacrificio)
                                <tr>
                                    <td>{{$psacrificio['COD_PSACRIFICIO']}}</td>  
                                    <td>{{$psacrificio['NOM_PERSONA']}}</td> 
                                    <td>{{$psacrificio['DNI_PERSONA']}}</td>
                                    <td>{{$psacrificio['TEL_PERSONA']}}</td>
                                    <td>{{date('d/m/y',strtotime($psacrificio['FEC_SACRIFICIO']))}}</td>
                                    <td>{{$psacrificio['DIR_PSACRIFICIO']}}</td>
                                    <td>{{$psacrificio['ANIMAL']}}</td>
                                    <td>{{$psacrificio['COL_ANIMAL']}}</td>
                                    <td><center>
                                        <img src="{{ asset($psacrificio['IMG_ANIMAL']) }}" alt="Imágen del animal" class="img-fluid" style="max-height: 60px;">
                                    </center></td> 
                                    
                                    <td>
                                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                        <!-- Boton de Editar -->
                                        <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}">
                                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                        </button>
                                    @endif
                                        <!-- Boton de PDF -->
                                        <button onclick="mostrarVistaPrevia({{$psacrificio['COD_PSACRIFICIO']}})" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal for editing goes here -->
                                <div class="modal fade bd-example-modal-sm" id="psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Actualizar Datos</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('psacrificio/actualizar') }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                                    @csrf
                                                        <input type="hidden" class="form-control" name="COD_PSACRIFICIO" value="{{$psacrificio['COD_PSACRIFICIO']}}">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="IMG_ANIMAL">Imágen:</label>
                                                                    <input type="file" class="form-control" id="IMG_ANIMAL" name="IMG_ANIMAL" accept="image/*">
                                                                </div>
                                                                <!-- Campo oculto para almacenar la ruta de la imagen actual -->
                                                                <input type="hidden" id="IMG_ANIMAL_actual" name="IMG_ANIMAL_actual" value="{{ $psacrificio['IMG_ANIMAL'] }}">
                                                                <!-- Mostrar imagen actual -->
                                                                <img src="{{ asset($psacrificio['IMG_ANIMAL']) }}" alt="Imagen actual" class="img-fluid" style="max-height: 100px;">

                                                                <div class="mb-3 mt-3">
                                                                    <label for="psacrificio" class="form-label">Nombre Completo</label>
                                                                    <input type="text" id="NOM_PERSONA-{{$psacrificio['COD_PSACRIFICIO']}}" class="form-control" name="NOM_PERSONA" placeholder="Ingrese el nombre de la persona" value="{{$psacrificio['NOM_PERSONA']}}" oninput="validarNombre('{{$psacrificio['COD_PSACRIFICIO']}}', this.value)">
                                                                    <div class="invalid-feedback" id="invalid-feedback2-{{$psacrificio['COD_PSACRIFICIO']}}"></div>
                                                                </div>

                                                                <div class="mb-3 mt-3">
                                                                    <label for="psacrificio" class="form-label">Identidad</label>
                                                                    <input type="text" id="DNI_PERSONA-{{$psacrificio['COD_PSACRIFICIO']}}" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" value="{{$psacrificio['DNI_PERSONA']}}" oninput="validarDNI('{{$psacrificio['COD_PSACRIFICIO']}}', this.value)">
                                                                    <div class="invalid-feedback" id="invalid-feedback-{{$psacrificio['COD_PSACRIFICIO']}}"></div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="psacrificio">Teléfono</label>
                                                                    <input type="text" id="TEL_PERSONA-{{$psacrificio['COD_PSACRIFICIO']}}" class="form-control" name="TEL_PERSONA" placeholder="0000-0000" value="{{$psacrificio['TEL_PERSONA']}}" oninput="validarTelefono('{{$psacrificio['COD_PSACRIFICIO']}}', this.value)">
                                                                    <div class="invalid-feedback" id="invalid-feedback10-{{$psacrificio['COD_PSACRIFICIO']}}"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-3 mt-3">
                                                                    <label for="psacrificio" class="form-label">Fecha Sacrificio</label>
                                                                    <!-- Codigo para que me muestre la fecha ya registrada al momento de actualizar --->
                                                                    <?php $fecha_formateada = date('Y-m-d', strtotime($psacrificio['FEC_SACRIFICIO'])); ?>
                                                                    <input type="date" class="form-control" id="FEC_SACRIFICIO" name="FEC_SACRIFICIO" placeholder="Ingrese la fecha del sacrificio" value="{{$fecha_formateada}}" min="{{ date('Y-m-d', time()) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="ANIMALLL" >Tipo Animal</label>
                                                                    <select class="form-select custom-select" id="ANIMAL" name="ANIMAL" required>
                                                                        <option value="" disabled selected>Seleccione una clase de animal</option>
                                                                        <option value="Vaca" @if($psacrificio['ANIMAL'] === 'Vaca') selected @endif>Vaca</option>
                                                                        <option value="Caballo" @if($psacrificio['ANIMAL'] === 'Caballo') selected @endif>Caballo</option>
                                                                        <option value="Cerdo" @if($psacrificio['ANIMAL'] === 'Cerdo') selected @endif>Cerdo</option>
                                                                        <option value="Burro" @if($psacrificio['ANIMAL'] === 'Burro') selected @endif>Burro</option>
                                                                        <option value="Mula" @if($psacrificio['ANIMAL'] === 'Mula') selected @endif>Mula</option>
                                                                        <option value="Yegua" @if($psacrificio['ANIMAL'] === 'Yegua') selected @endif>Yegua</option>
                                                                        <option value="Toro" @if($psacrificio['ANIMAL'] === 'Toro') selected @endif>Toro</option>
                                                                        <option value="Res" @if($psacrificio['ANIMAL'] === 'Res') selected @endif>Res</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="COL_ANIMALL">Color Animal</label>
                                                                    <input type="text" id="COL_ANIMAL-{{$psacrificio['COD_PSACRIFICIO']}}" class="form-control" name="COL_ANIMAL" placeholder="Ingrese color del animal" value="{{$psacrificio['COL_ANIMAL']}}" oninput="validarColor('{{$psacrificio['COD_PSACRIFICIO']}}', this.value)">
                                                                    <div class="invalid-feedback" id="invalid-feedback4-{{$psacrificio['COD_PSACRIFICIO']}}"></div>
                                                                </div>
                                                                <div class="col-sm-13 mb-3">
                                                                    <div class="form-group">
                                                                        <label for="psacrificio">Dirección Sacrificio</label>
                                                                        <textarea id="DIR_PSACRIFICIO-{{$psacrificio['COD_PSACRIFICIO']}}" rows="6" class="form-control" name="DIR_PSACRIFICIO" placeholder="Ingrese la dirección del sacrificio" value="{{$psacrificio['DIR_PSACRIFICIO']}}" oninput="validarDireccion('{{$psacrificio['COD_PSACRIFICIO']}}', this.value)">{{$psacrificio['DIR_PSACRIFICIO']}}</textarea>
                                                                        <div class="invalid-feedback" id="invalid-feedback5-{{$psacrificio['COD_PSACRIFICIO']}}"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <!-- Boton de confirmar al editar -->
                                                            <button type="submit" class="btn btn-primary" id="submitButton-{{$psacrificio['COD_PSACRIFICIO']}}">Editar</button>
                                                            <!-- Boton de cancelar -->
                                                            <a href="{{ url('psacrificio') }}" class="btn btn-danger">Cancelar</a>
                                                    </div>
                                                </form>
                                                <script>
                                                   function validarNombre(id, nombre) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("NOM_PERSONA-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback2-" + id);

                                                        if (nombre.length < 5 || nombre.length > 100 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "El nombre debe tener al menos 5 carácteres y no más de 100, sin números";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    } 
                                                    //Validaciones EDITAR
                                                    function validarDNI(id, dni) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("DNI_PERSONA-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback-" + id);
              
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
                                                    //Validaciones Telefono
                                                    function validarTelefono(id, telefono) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("TEL_PERSONA-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback10-" + id);

                                                        
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
                                                    //Validar Direccion
                                                    function validarDireccion(id, direccion) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("DIR_PSACRIFICIO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback5-" + id);

                                                        if (direccion.length < 5) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La dirección debe tener al menos 5 caracteres.";
                                                            btnGuardar.disabled = true;
                                                        } else if (direccion.length > 100) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La dirección no puede tener más de 100 carácteres.";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    }
                                                    //validaciones color
                                                    function validarColor(id, color) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("COL_ANIMAL-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback4-" + id);

                                                        if (color.length < 4 || color.length > 45 || !/^[a-zA-Z\s]+$/.test(color)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "El color debe tener al menos 4 carácteres y no más de 45, sin números";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    } 
                                                    

                                                    function mostrarVistaPrevia(idsacrificio) {
                                                        // URL de la acción del controlador que genera el PDF
                                                        var nuevaVentana = window.open("{{ url('psacrificio/generar-pdf') }}/" + idsacrificio, '_blank');

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
                $(document).ready(function() {
                    $('#sacrificio').DataTable({
                        responsive: true,
                        dom: "Bfrtilp",
                        buttons: [//Botones de Excel, PDF, Imprimir
                            {
                                extend: "excelHtml5",
                                filename: "Permisos de Sacrificio",
                                title: "Permisos de Sacrificio",
                                text: "<i class='fa-solid fa-file-excel'></i>",
                                tittleAttr: "Exportar a Excel",
                                className: "btn btn-success",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6], //exportar solo la primera hasta las sexta tabla
                                },
                            },
                            
                                //{
                //extend: "pdfHtml5",
                //filename: "Permisos de Sacrificio",
                //title: "Permisos de Sacrificio",
                //text: "<i class='fa-solid fa-file-pdf'></i>",
                //titleAttr: "Exportar a PDF",
                //className: "btn btn-danger",
                //exportOptions: {
                    //columns: [0, 1, 2, 3, 4, 5, 6],
                //},
            //},  
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
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS PERMISOS DE SACRIFICIOS  </h5>");
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
                        columnDefs: [
                            { orderable: false, target: [0, 2, 3, 6, 7]},
                            { searchable: false, target: [0, 3, 6, 7]},
                            { width: '25%', target: [1] },
                            { width: '10%', target: [2, 3, 4, 6, 7] }, 
                            { width: '25%', target: [5] },
                        ],
                        language: { //Lenguaje a español de toda la vista 
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
