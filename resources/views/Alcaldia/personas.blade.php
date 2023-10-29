@extends('adminlte::page')

@php
    use Carbon\Carbon;
@endphp
@php
    $generos =[
      'M' => 'MASCULINO',
      'F' => 'FEMENINO',
    ];
    $tiposdirecciones =[
      'DO' => 'DOMICILIO',
      'TR' => 'TRABAJO',
    ];
    $tipostelefonos =[
      'FI' => 'FIJO',
      'MO' => 'MOVIL',
    ];
@endphp

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
@endsection

<!-- ENCABEZADO -->
@section('content_header')
    @if(session()->has('user_data'))
        <?php
            $authController = app(\App\Http\Controllers\AuthController::class);
            $objeto = 'PERSONAS'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            
            <center><br>
                <h1>Información de Personas</h1>
            </center></br>
        
        @section('content')
            <!-- Pantalla para Insertar PERSONAS -->
            @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
            <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#Personas">
                    <div class="sign">+</div>     
                    <div class="text">Nuevo</div>
                </button>   
            </p>
            @endif
            <!-- Mensaje de error cuando el DNI este repetido -->
            @if(session('message'))
                <div class="alert alert-danger">
                    {{ session('message')['text'] }}
                </div>
            @endif
            <div class="modal fade bd-example-modal-sm" id="Personas" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">INGRESAR UNA NUEVA PERSONA</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('personas/insertar') }}" method="post" class="needs-validation personas-form" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-3">
                                        <label for="DNI_PERSONA">Identidad:</label>
                                        <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="NOM_PERSONA">Nombre Completo:</label>
                                        <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre completo de la persona" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="GEN_PERSONA">Género:</label>
                                        <select class="form-select custom-select" id="GEN_PERSONA" name="GEN_PERSONA" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="M">MASCULINO</option>
                                            <option value="F">FEMENINO</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="FEC_NAC_PERSONA">Fecha de Nacimiento:</label>
                                        <input type="date" id="FEC_NAC_PERSONA" class="form-control" name="FEC_NAC_PERSONA" placeholder="Seleccione la fecha de nacimiento" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <form action="{{ route('personas.guardar-imagen') }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      <div class="form-group">
                                          <label for="IMG_PERSONA">Imágen:</label>
                                          <input type="file" class="form-control" id="IMG_PERSONA" name="IMG_PERSONA" accept="image/*">
                                      </div>
                                    <div class="mb-3">
                                        <label for="DES_DIRECCION">Dirección:</label>
                                        <input type="text" id="DES_DIRECCION" class="form-control" name="DES_DIRECCION" placeholder="Ingresar la dirección de la persona" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="TIP_DIRECCION">Tipo de Dirección:</label>
                                        <select class="form-select custom-select" id="TIP_DIRECCION" name="TIP_DIRECCION" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="DO">DOMICILIO</option>
                                            <option value="TR">TRABAJO</option>
                                        </select>  
                                    </div>                          
                                    <div class="mb-3">
                                        <label for="DIR_EMAIL">Correo Electrónico:</label>
                                        <input type="text" id="DIR_EMAIL" class="form-control" name="DIR_EMAIL" placeholder="xxxx@gmail.com" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NUM_TELEFONO">Teléfono:</label>
                                        <input type="text" id="NUM_TELEFONO" class="form-control" name="NUM_TELEFONO" placeholder="0000-0000" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="TIP_TELEFONO">Tipo de Teléfono:</label>
                                        <select class="form-select custom-select" id="TIP_TELEFONO" name="TIP_TELEFONO" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="FI">FIJO</option>
                                            <option value="MO">MOVIL</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="DES_TELEFONO">Descripción del Teléfono:</label>
                                        <input type="text" id="DES_TELEFONO" class="form-control" name="DES_TELEFONO" placeholder="Ingresar una descripción del teléfono" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="OPE_TELEFONO">Operadora de Teléfono:</label>
                                        <input type="text" id="OPE_TELEFONO" class="form-control" name="OPE_TELEFONO" placeholder="Ingresar una descripción del teléfono" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="IND_TELEFONO">Estado:</label>
                                        <select class="form-select custom-select" id="IND_TELEFONO" name="IND_TELEFONO" required>
                                            <option value="" disabled selected>Seleccione una opción</option>    
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="INACTIVO">INACTIVO</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                $(document).ready(function() {
                                    //Validaciones del nombre persona, no permite que se ingrese numeros solo letras
                                    $('#NOM_PERSONA').on('input', function() {
                                        var nombre = $(this).val();
                                        var errorMessage = 'El nombre debe tener al menos 5 carácteres y no más de 100, sin números.';
                                        // Verificar si el nombre tiene al menos 5 letras, no contiene números y no tiene más de 100 caracteres
                                        if (nombre.length < 5 || nombre.length > 100 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#FEC_NAC_PERSONA').on('input', function() {
                                        var fecnacimiento = $(this).val();
                                        var currentDate = new Date().toISOString().split('T')[0];
                                        var minBirthdate = new Date();
                                        minBirthdate.setFullYear(minBirthdate.getFullYear() - 18);  // Restar 18 años a la fecha actual
                                        
                                        var errorMessage = 'Debes tener al menos 18 años para inscribirte.';
                                        
                                        if (!fecnacimiento || fecnacimiento > currentDate) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            var selectedDate = new Date(fecnacimiento);
                                            if (selectedDate > minBirthdate) {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        }
                                    });
                                    //Validaciones del campo DNI el cual no permite el ingreso de letras (las bloquea y no se muestra)
                                    //y solo permite el ingreso de numeros
                                    $('#DNI_PERSONA').on('input', function() {
                                        var dni = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                        $(this).val(dni); // Actualizar el valor del campo solo con números
                                        var errorMessage = 'El DNI debe tener exactamente 13 dígitos numéricos.';
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
                                    $('#NUM_TELEFONO').on('input', function() {
                                        var telefono = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                        $(this).val(telefono); // Actualizar el valor del campo solo con números
                                        var errorMessage = 'El teléfono debe tener exactamente 8 dígitos numéricos.';
                                        if (telefono.length !== 8) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#DES_DIRECCION').on('input', function() {
                                        var direccionpersona = $(this).val();
                                        var errorMessage = '';

                                        if (direccionpersona.length < 5) {
                                            errorMessage = 'La dirección debe tener al menos 5 carácteres.';
                                        } else if (direccionpersona.length > 100) {
                                            errorMessage = 'La dirección no puede tener más de 100 carácteres.';
                                        }
                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });                                
                                    $('#DIR_EMAIL').on('input', function() {
                                        var correopersona = $(this).val();
                                        var errorMessage = 'El correo debe tener entre 5 y 50 caraácteres, sin espacios y contener letras minúsculas, "@" y "."';
                                        
                                        if (correopersona.length < 5 || correopersona.length > 50 || correopersona.indexOf(' ') !== -1 || correopersona.indexOf('@') === -1 || !/^[a-z0-9@.]+$/.test(correopersona)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#DES_TELEFONO').on('input', function() {
                                        var destelefono = $(this).val();
                                        var errorMessage = 'La descripción debe tener entre 5 y 100 letras y no contener carácteres especiales.';
                                        
                                        if (destelefono.length < 5 || destelefono.length > 100 || !/^[a-zA-Z ]+$/.test(destelefono)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });                                 
                                    $('#OPE_TELEFONO').on('input', function() {
                                        var opetelefono = $(this).val();
                                        var errorMessage = 'La descripción debe tener entre 4 y 20 letras, sin carácteres especiales ni números.';
                                        
                                        if (opetelefono.length < 4 || opetelefono.length > 20 || !/^[a-zA-Z\s]+$/.test(opetelefono)) {
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
                                    document.getElementById("DNI_PERSONA").value = "";
                                    document.getElementById("NOM_PERSONA").value = "";
                                    document.getElementById("GEN_PERSONA").value = "";
                                    document.getElementById("FEC_NAC_PERSONA").value = "";
                                    document.getElementById("IMG_PERSONA").value = "";
                                    document.getElementById("DES_DIRECCION").value = "";
                                    document.getElementById("DIR_EMAIL").value = "";
                                    document.getElementById("NUM_TELEFONO").value = "";
                                    document.getElementById("TIP_TELEFONO").value = "";
                                    document.getElementById("DES_TELEFONO").value = "";
                                    document.getElementById("OPE_TELEFONO").value = "";
                                    document.getElementById("IND_TELEFONO").value = "";
        
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
                                document.querySelector('.personas-form').addEventListener('submit', formSubmitHandler);     
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN Pantalla para Insertar PERSONAS --> 
            <!-- Tabla del Modulo PERSONAS -->
            <div class="card">
                <div class="card-body">
                    <table width=100% cellspacing="10" cellpadding="5" class="table table-hover table-bordered table-responsive mt-1" id="persona">
                        <thead>
                            <th><center>N°</center></th>
                            <th><center>DNI</center></th>
                            <th><center>Nombre</center></th>
                            <th><center>Género</center></th>
                            <th><center>F.Nac.</center></th>
                            <th><center>Imágen</center></th>
                            <th><center>Dirección</center></th>
                            <th><center>Correo</center></th>
                            <th><center>Teléfono</center></th>
                            <th><center><i class="fas fa-cog"></i></center></th>
                        </thead>
                        <tbody>
                            @foreach($citaArreglo as $personas)
                                <tr>
                                    <td>{{$personas['COD_PERSONA']}}</td>
                                    <td>{{$personas['DNI_PERSONA']}}</td>
                                    <td>{{$personas['NOM_PERSONA']}}</td>
                                    <td>{{$generos[$personas['GEN_PERSONA']]}}</td>
                                    <td>{{ Carbon::parse($personas['FEC_NAC_PERSONA'])->format('Y-m-d') }}</td>
                                    <td><center>
                                        <img src="{{ asset($personas['IMG_PERSONA']) }}" alt="Imágen de la persona" class="img-fluid" style="max-height: 65px;">
                                    </center></td> 
                                    <td>{{$personas['DES_DIRECCION']}}</td>   
                                    <td>{{$personas['DIR_EMAIL']}}</td>   
                                    <td>{{$personas['NUM_TELEFONO']}}</td>   
                                    <td>
                                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                      <!-- Boton de Editar -->
                                      <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#personas-edit-{{$personas['COD_PERSONA']}}">
                                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                      </button>
                                    @endif
                                    </td>
                                </tr>
                                <!-- Pantalla para ACTUALIZAR la tabla PERSONAS -->
                                <div class="modal fade bd-example-modal-sm" id="personas-edit-{{$personas['COD_PERSONA']}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Actualizar Datos</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('personas/actualizar') }}" method="post" class="personas-form"enctype="multipart/form-data">
                                                    @csrf
                                                        <input type="hidden" class="form-control" name="COD_PERSONA" value="{{$personas['COD_PERSONA']}}">
                                                        <div class="mb-3">
                                                            <label for="personas">Identidad:</label>
                                                            <input type="text" class="form-control" id="DNI_PERSONA-{{$personas['COD_PERSONA']}}" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" value="{{$personas['DNI_PERSONA']}}" oninput="validarDNI('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas">Nombre Completo:</label>
                                                            <input type="text" id="NOM_PERSONA-{{$personas['COD_PERSONA']}}" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre completo de la persona" value="{{$personas['NOM_PERSONA']}}" oninput="validarNombre('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback2-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Género:</label>
                                                            <select class="form-select custom-select" id="GEN_PERSONA" name="GEN_PERSONA" value="{{$personas['GEN_PERSONA']}}" required>
                                                                <option value="M" @if($personas['GEN_PERSONA'] === 'M') selected @endif>MASCULINO</option>
                                                                <option value="F" @if($personas['GEN_PERSONA'] === 'F') selected @endif>FEMENINO</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas" class="form-laabel">Fecha de Nacimiento:</label>
                                                            <!-- Codigo para que me muestre la fecha ya registrada al momento de actualizar --->
                                                            <?php $fecha_formateada = Carbon::parse($personas['FEC_NAC_PERSONA'])->format('Y-m-d'); ?>
                                                            <input type="date" id="FEC_NAC_PERSONA-{{$personas['COD_PERSONA']}}" class="form-control" name="FEC_NAC_PERSONA" placeholder="Seleccione la fecha de nacimiento" value="{{$fecha_formateada}}" oninput="validarFecNac('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback3-{{$personas['COD_PERSONA']}}"></div>                                    
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="IMG_PERSONA">Imágen:</label>
                                                            <input type="file" class="form-control" id="IMG_PERSONA" name="IMG_PERSONA" accept="image/*">
                                                        </div>
                                                        <!-- Campo oculto para almacenar la ruta de la imagen actual -->
                                                        <input type="hidden" name="IMG_PERSONA_actual" value="{{ $personas['IMG_PERSONA'] }}">
                                                        <!-- Mostrar imagen actual -->
                                                        <img src="{{ asset($personas['IMG_PERSONA']) }}" alt="Imagen actual" class="img-fluid" style="max-height: 100px;">
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas" class="form-label">Código Dirección:</label>
                                                            <input type="text" id="COD_DIRECCION" class="form-control" name="COD_DIRECCION" placeholder="Ingrese el código de la dirección" value="{{$personas['COD_DIRECCION']}}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Dirección:</label>
                                                            <input type="text" id="DES_DIRECCION-{{$personas['COD_PERSONA']}}" class="form-control" name="DES_DIRECCION" placeholder="Ingresar la dirección de la persona" value="{{$personas['DES_DIRECCION']}}" oninput="validarDireccion('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback4-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Tipo de Dirección:</label>
                                                            <select class="form-select custom-select" id="TIP_DIRECCION" name="TIP_DIRECCION" value="{{$personas['TIP_DIRECCION']}}" required>
                                                                <option value="DO" @if($personas['TIP_DIRECCION'] === 'DO') selected @endif>DOMICILIO</option>
                                                                <option value="TR" @if($personas['TIP_DIRECCION'] === 'TR') selected @endif>TRABAJO</option>
                                                            </select>  
                                                            <div class="invalid-feedback"></div>
                                                        </div>  
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas" class="form-label">Código Email:</label>
                                                            <input type="text" id="COD_EMAIL" class="form-control" name="COD_EMAIL" placeholder="Ingrese el código del Correo" value="{{$personas['COD_EMAIL']}}" readonly>                                                           
                                                        </div>                        
                                                        <div class="mb-3">
                                                            <label for="personas">Correo Electrónico:</label>
                                                            <input type="text" id="DIR_EMAIL-{{$personas['COD_PERSONA']}}" class="form-control" name="DIR_EMAIL" placeholder="xxxx@gmail.com" value="{{$personas['DIR_EMAIL']}}" oninput="validarCorreo('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback5-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas" class="form-label">Código Teléfono:</label>
                                                            <input type="text" id="COD_TELEFONO" class="form-control" name="COD_TELEFONO" placeholder="Ingrese el código del teléfono" value="{{$personas['COD_TELEFONO']}}" readonly>
                                                        </div>   
                                                        <div class="mb-3">
                                                            <label for="personas">Teléfono:</label>
                                                            <input type="text" id="NUM_TELEFONO-{{$personas['COD_PERSONA']}}" class="form-control" name="NUM_TELEFONO" placeholder="0000-0000" value="{{$personas['NUM_TELEFONO']}}" oninput="validarTelefono('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback6-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Tipo de Teléfono:</label>
                                                            <select class="form-select custom-select" id="TIP_TELEFONO" name="TIP_TELEFONO" value="{{$personas['TIP_TELEFONO']}}" required>
                                                                <option value="FI" @if($personas['TIP_TELEFONO'] === 'FI') selected @endif>FIJO</option>
                                                                <option value="MO" @if($personas['TIP_TELEFONO'] === 'MO') selected @endif>MOVIL</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Descripción del Teléfono:</label>
                                                            <input type="text" id="DES_TELEFONO-{{$personas['COD_PERSONA']}}" class="form-control" name="DES_TELEFONO" placeholder="Ingresar una descripción del teléfono" value="{{$personas['DES_TELEFONO']}}" oninput="validarDesTelefono('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback7-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Operadora de Teléfono:</label>
                                                            <input type="text" id="OPE_TELEFONO-{{$personas['COD_PERSONA']}}" class="form-control" name="OPE_TELEFONO" placeholder="Ingresar una descripción del teléfono" value="{{$personas['OPE_TELEFONO']}}" oninput="validarOpeTelefono('{{$personas['COD_PERSONA']}}', this.value)" required>
                                                            <div class="invalid-feedback" id="invalid-feedback8-{{$personas['COD_PERSONA']}}"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Estado:</label>
                                                            <select class="form-select custom-select" id="IND_TELEFONO" name="IND_TELEFONO" value="{{$personas['IND_TELEFONO']}}" required>   
                                                                <option value="ACTIVO" @if($personas['IND_TELEFONO'] === 'ACTIVO') selected @endif>ACTIVO</option>
                                                                <option value="INACTIVO" @if($personas['IND_TELEFONO'] === 'INACTIVO') selected @endif>INACTIVO</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-primary" id="submitButton-{{$personas['COD_PERSONA']}}">Editar</button>
                                                            <a href="{{ url('personas') }}" class="btn btn-danger">Cancelar</a>
                                                    </div>
                                                </form> 
                                                <script>
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
                                                    function validarFecNac(id, fecNac) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("FEC_NAC_PERSONA-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback3-" + id);

                                                        // Parsea la fecha de nacimiento en un objeto Date
                                                        var fechaNac = new Date(fecNac);
                                                        
                                                        // Calcula la fecha hace 18 años atrás
                                                        var fechaHace18Anios = new Date();
                                                        fechaHace18Anios.setFullYear(fechaHace18Anios.getFullYear() - 18);

                                                        // Compara la fecha de nacimiento con la fecha hace 18 años
                                                        if (fechaNac <= fechaHace18Anios) {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        } else {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "Debes tener al menos 18 años para inscribirte.";
                                                            btnGuardar.disabled = true;
                                                        }
                                                    }
                                                    function validarDireccion(id, direccion) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("DES_DIRECCION-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback4-" + id);

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
                                                    function validarCorreo(id, correo) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("DIR_EMAIL-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback5-" + id);

                                                        // Verificar si el correo cumple con los requisitos
                                                        if (/^\S+@\S+\.\S{2,}$/.test(correo) && correo.length >= 5 && correo.length <= 50) {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        } else {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "El correo debe tener al menos 5 caracteres, no ser mayor de 50, contener un '@' y un '.' sin espacios";
                                                            btnGuardar.disabled = true;
                                                        }
                                                    }
                                                    function validarTelefono(id, telefono) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("NUM_TELEFONO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                                        
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
                                                    function validarDesTelefono(id, desTel) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("DES_TELEFONO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback7-" + id);

                                                        if (desTel.length < 5 || desTel.length > 100 || !/^[a-zA-Z\s]+$/.test(desTel)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La descripción debe tener al menos 5 carácteres y no más de 100, sin números";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    }
                                                    function validarOpeTelefono(id, opeTel) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("OPE_TELEFONO-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback8-" + id);

                                                        if (opeTel.length < 4 || opeTel.length > 20 || !/^[a-zA-Z\s]+$/.test(opeTel)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = "La descripción debe tener al menos 4 carácteres y no más de 20, sin números";
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
                        $('#persona').DataTable({
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