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
            $objeto = 'Personas'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            
            <center><br>
                <h1>Infromación de Personas</h1>
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
            <div class="modal fade bd-example-modal-sm" id="Personas" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">INGRESAR UNA NUEVA PERSONA</h5>
                        </div>
                        <div class="modal-body">
                            <p>Ingrese los datos solicitados:</p>
                            <form action="{{ url('personas/insertar') }}" method="post" class="needs-validation personas-form" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-3">
                                        <label for="DNI_PERSONA">Número de Identidad:</label>
                                        <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="NOM_PERSONA">Nombre de la Persona:</label>
                                        <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el Nombre Completo de la persona" required>
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
                                          <label for="IMG_PERSONA">Imagen de la Persona:</label>
                                          <input type="file" class="form-control" id="IMG_PERSONA" name="IMG_PERSONA" accept="image/*">
                                      </div>
                                    <div class="mb-3">
                                        <label for="DES_DIRECCION">Descripción de la Dirección:</label>
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
                                        <label for="DIR_EMAIL">Direccion de Correo Electronico:</label>
                                        <input type="text" id="DIR_EMAIL" class="form-control" name="DIR_EMAIL" placeholder="xxxx@gmail.com" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NUM_TELEFONO">Número de Telefono:</label>
                                        <input type="text" id="NUM_TELEFONO" class="form-control" name="NUM_TELEFONO" placeholder="0000-0000" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="TIP_TELEFONO">Tipo de Telefono:</label>
                                        <select class="form-select custom-select" id="TIP_TELEFONO" name="TIP_TELEFONO" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="FI">FIJO</option>
                                            <option value="MO">MOVIL</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="DES_TELEFONO">Descripción del Telefono:</label>
                                        <input type="text" id="DES_TELEFONO" class="form-control" name="DES_TELEFONO" placeholder="Ingresar una descripción del telefono" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="OPE_TELEFONO">Operadora de Telefono:</label>
                                        <input type="text" id="OPE_TELEFONO" class="form-control" name="OPE_TELEFONO" placeholder="Ingresar una descripción del telefono" required>
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
                                        var errorMessage = 'El nombre debe tener al menos 5 letras';
                                        if (nombre.length < 5 || !/^[a-zA-Z\s]+$/.test(nombre)) {
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
                                        
                                        var errorMessage = 'Debes tener al menos 18 años para inscribirte';
                                        
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
                                    $('#NUM_TELEFONO').on('input', function() {
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
                                    $('#DES_DIRECCION').on('input', function() {
                                        var direccionpersona = $(this).val();
                                        var errorMessage = 'La dirección debe tener al menos 5 caracteres';
                                        
                                        if (direccionpersona.length < 5) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#DIR_EMAIL').on('input', function() {
                                        var correopersona = $(this).val();
                                        var errorMessage = 'La dirección de Correo debe tener al menos 5 caracteres';
                                        
                                        if (correopersona.length < 5) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            // Verificar si contiene el símbolo "@"
                                            if (correopersona.indexOf('@') === -1) {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('El correo electrónico debe contener "@"');
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        }
                                    });
                                    $('#NOM_PERSONA').on('input', function() {
                                        var nombre = $(this).val();
                                        var errorMessage = 'El nombre debe tener al menos 5 letras';
                                        if (nombre.length < 5 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#DES_TELEFONO').on('input', function() {
                                        var destelefono = $(this).val();
                                        var errorMessage = 'La descripción debe tener al menos 5 letras';
                                        if (destelefono.length < 5 || !/^[a-zA-Z\s]+$/.test(destelefono)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#OPE_TELEFONO').on('input', function() {
                                        var opetelefono = $(this).val();
                                        var errorMessage = 'La descripción debe tener al menos 4 letras';
                                        if (opetelefono.length < 4 || !/^[a-zA-Z\s]+$/.test(opetelefono)) {
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
                                    document.getElementById("TIP_DIRECCION").value = "";
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
                            <th><center>Fecha de Nacimiento</center></th>
                            <th><center>Imagen Persona</center></th>
                            <th><center>Descripción Dirección</center></th>
                            <th><center>Dirección Correo</center></th>
                            <th><center>Número Telefono</center></th>
                            <th><center>Opciones de la Tabla</center></th>
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
                                        <img src="{{ asset($personas['IMG_PERSONA']) }}" alt="Imagen de la persona" class="img-fluid" style="max-height: 100px;">
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
                                                            <label for="personas">Número de Identidad:</label>
                                                            <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="xxxx-xxxx-xxxxx" value="{{$personas['DNI_PERSONA']}}">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas">Nombre de la Persona:</label>
                                                            <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el Nombre Completo de la persona" value="{{$personas['NOM_PERSONA']}}">
                                                            <div class="invalid-feedback"></div>
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
                                                            <input type="date" id="FEC_NAC_PERSONA" class="form-control" name="FEC_NAC_PERSONA" placeholder="Seleccione la fecha de nacimiento" value="{{$fecha_formateada}}">                                    
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="IMG_PERSONA">Imagen de la Persona:</label>
                                                            <input type="file" class="form-control" id="IMG_PERSONA" name="IMG_PERSONA" accept="image/*">
                                                        </div>
                                                        <!-- Mostrar imagen actual -->
                                                        <img src="{{ asset($personas['IMG_PERSONA']) }}" alt="Imagen actual" class="img-fluid" style="max-height: 100px;">
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas" class="form-label">Codigo Dirección:</label>
                                                            <input type="text" id="COD_DIRECCION" class="form-control" name="COD_DIRECCION" placeholder="Ingrese el codigo de la dirección" value="{{$personas['COD_DIRECCION']}}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Descripción de la Dirección:</label>
                                                            <input type="text" id="DES_DIRECCION" class="form-control" name="DES_DIRECCION" placeholder="Ingresar la dirección de la persona" value="{{$personas['DES_DIRECCION']}}">
                                                            <div class="invalid-feedback"></div>
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
                                                            <label for="personas" class="form-label">Codigo Email:</label>
                                                            <input type="text" id="COD_EMAIL" class="form-control" name="COD_EMAIL" placeholder="Ingrese el codigo del Correo" value="{{$personas['COD_EMAIL']}}" readonly>
                                                            
                                                        </div>                        
                                                        <div class="mb-3">
                                                            <label for="personas">Direccion de Correo Electronico:</label>
                                                            <input type="text" id="DIR_EMAIL" class="form-control" name="DIR_EMAIL" placeholder="xxxx@gmail.com" value="{{$personas['DIR_EMAIL']}}">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3 mt-3">
                                                            <label for="personas" class="form-label">Codigo Teléfono:</label>
                                                            <input type="text" id="COD_TELEFONO" class="form-control" name="COD_TELEFONO" placeholder="Ingrese el codigo del teléfono" value="{{$personas['COD_TELEFONO']}}" readonly>
                                                        </div>   
                                                        <div class="mb-3">
                                                            <label for="personas">Número de Telefono:</label>
                                                            <input type="text" id="NUM_TELEFONO" class="form-control" name="NUM_TELEFONO" placeholder="0000-0000" value="{{$personas['NUM_TELEFONO']}}">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Tipo de Telefono:</label>
                                                            <select class="form-select custom-select" id="TIP_TELEFONO" name="TIP_TELEFONO" value="{{$personas['TIP_TELEFONO']}}" required>
                                                                <option value="FI" @if($personas['TIP_TELEFONO'] === 'FI') selected @endif>FIJO</option>
                                                                <option value="MO" @if($personas['TIP_TELEFONO'] === 'MO') selected @endif>MOVIL</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Descripción del Telefono:</label>
                                                            <input type="text" id="DES_TELEFONO" class="form-control" name="DES_TELEFONO" placeholder="Ingresar una descripción del telefono" value="{{$personas['DES_TELEFONO']}}">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personas">Operadora de Telefono:</label>
                                                            <input type="text" id="OPE_TELEFONO" class="form-control" name="OPE_TELEFONO" placeholder="Ingresar una descripción del telefono" value="{{$personas['OPE_TELEFONO']}}">
                                                            <div class="invalid-feedback"></div>
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
            <script>
                // Agregar una función para mostrar una ventana emergente de SweetAlert2 para el mensaje de registro exitoso
                function showSuccessMessage() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro Exitoso',
                        text: 'El registro ha sido guardado exitosamente.',
                        showConfirmButton: false,
                        timer: 6000,
                    });
                }

                // Función que se ejecutará después de enviar el formulario
                function formSubmitHandler() {
                    showSuccessMessage();
                }
                document.querySelector('.personas-form').addEventListener('submit', formSubmitHandler);
            </script> 
            <script> console.log('Hi!'); </script>
            <script>
                <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
                <script>
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