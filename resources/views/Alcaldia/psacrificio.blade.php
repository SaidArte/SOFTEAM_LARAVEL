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
            $objeto = 'Permisos de Sacrificio'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <center><br>
            <h1>Información de Permisos de Sacrificio</h1>
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
                            <h5 class="modal-title">Ingresa un Nuevo Permiso de Sacrificio</h5>
                        </div>
                        
                        <div class="modal-body">
                            <p>Ingresar Datos Solicitados:</p>
                            <!-- Inicio del nuevo formulario -->
                            <form action="{{ url('psacrificio/insertar') }}" method="post" class="needs-validation psacrificio-form">

                                @csrf

                                    <div class="mb-3">
                                        <label for="NOM_PERSONA">Nombre de la Persona</label>
                                        <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre completo de la persona" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label for="DNI_PERSONA">Numero de Identidad</label>
                                        <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="Ingresar el numero de identidad" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="TEL_PERSONA">Numero de Telefono</label>
                                        <input type="text" id="TEL_PERSONA" class="form-control" name="TEL_PERSONA" placeholder="Ingresar el numero de telefono" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="FEC_SACRIFICIO">Fecha del Sacrificio</label>
                                        <input type="date" id="FEC_SACRIFICIO" class="form-control" name="FEC_SACRIFICIO" placeholder="Inserte la fecha del sacrificio" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="COD_ANIMAL">Codigo del Animal</label>
                                        <select class="form-select" id="COD_ANIMAL" name="COD_ANIMAL" required>
                                            <option value="" disable selected> Seleccione al Animal</option>
                                            @foreach ($AnimalArreglo as $Animal)
                                                <option value="{{ $Animal['COD_ANIMAL'] }}">{{ $Animal['CLAS_ANIMAL'] }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="DIR_PSACRIFICIO">Direccion del Sacrificio</label>
                                        <input type="text" id="DIR_PSACRIFICIO" class="form-control" name="DIR_PSACRIFICIO" placeholder="Ingresar la direccion del sacrificio" required>
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
                                    //Validaciones del campo direccion 
                                    $('#DIR_PSACRIFICIO').on('input', function() {
                                        var direccionSacrificio = $(this).val();
                                        var errorMessage = 'La dirección debe tener al menos 5 caracteres';
                                        
                                        if (direccionSacrificio.length < 5) {
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
                                    document.getElementById("NOM_PERSONA").value = "";
                                    document.getElementById("DNI_PERSONA").value = "";
                                    document.getElementById("TEL_PERSONA").value = "";
                                    document.getElementById("FEC_SACRIFICIO").value = "";
                                    document.getElementById("COD_ANIMAL").value = "";
                                    document.getElementById("DIR_PSACRIFICIO").value = "";

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
                    <!-- Inicio de la tabla -->
                    <table  width="100%" cellspacing="8 " cellpadding="8" class="table table-hover table-bordered mt-1" id="sacrificio">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th><center>Nombre</center></th>
                                <th><center>Numero de Identidad</center></th>
                                <th><center>Telefono</center></th>
                                <th><center>Fecha del Sacrificio</center></th>
                                <th><center>Direccion del Sacrificio</center></th>
                                <th><center>Registro del Animal</center></th>
                                <th><center>Opciones de la Tabla</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through $citaArreglo and show data -->
                            @foreach($citaArreglo as $psacrificio)
                                @php
                                    $Animal = null;
                                    foreach ($AnimalArreglo as $p) {
                                        if ($p ['COD_ANIMAL'] === $psacrificio ['COD_ANIMAL']) {
                                            $Animal = $p;
                                            break;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{$psacrificio['COD_PSACRIFICIO']}}</td>  
                                    <td>{{$psacrificio['NOM_PERSONA']}}</td> 
                                    <td>{{$psacrificio['DNI_PERSONA']}}</td>
                                    <td>{{$psacrificio['TEL_PERSONA']}}</td>
                                    <td>{{date('d/m/y',strtotime($psacrificio['FEC_SACRIFICIO']))}}</td>
                                    <td>{{$psacrificio['DIR_PSACRIFICIO']}}</td>
                                    <td>
                                        @if ($Animal !== null)
                                            {{ $Animal['CLAS_ANIMAL'] }}
                                        @else
                                            Animal no encontrado
                                        @endif
                                    </td>
                                    
                                    <td>
                                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                        <!-- Boton de Editar -->
                                        <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}">
                                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                        </button>
                                    @endif
                                        <!-- Boton de PDF -->
                                        <a href="{{ route('psacrificio.pdf') }}" class="btn btn-sm btn-danger" data-target="#psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}" target="_blank">
                                            <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                                        </a>
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
                                                <p>Ingresa los Nuevos Datos</p>
                                                <form action="{{ url('psacrificio/actualizar') }}" method="post" class="row g-3 needs-validation" novalidate>
                                                    @csrf
                                                        <input type="hidden" class="form-control" name="COD_PSACRIFICIO" value="{{$psacrificio['COD_PSACRIFICIO']}}">
                                                        
                                                        <div class="mb-3 mt-3">
                                                            <label for="psacrificio" class="form-label">Nombre de la Persona</label>
                                                            <input type="text" class="form-control" id="NOM_PERSONA" name="NOM_PERSONA" placeholder="Ingrese el nombre de la persona" value="{{$psacrificio['NOM_PERSONA']}}" readonly>
                                                            <div class="valid-feedback"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="psacrificio">Numero de Identidad</label>
                                                            <input type="text" class="form-control" id="DNI_PERSONA" name="DNI_PERSONA" placeholder="Ingrese el numero de identidad" value="{{$psacrificio['DNI_PERSONA']}}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="psacrificio">Numero de Telefono</label>
                                                            <input type="text" class="form-control" id="TEL_PERSONA" name="TEL_PERSONA" placeholder="Ingrese el numero de telefono" value="{{$psacrificio['TEL_PERSONA']}}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="psacrificio" class="form-laabel">Fecha de Sacrificio</label>
                                                            <!-- Codigo para que me muestre la fecha ya registrada al momento de actualizar --->
                                                            <?php $fecha_formateada = date('Y-m-d', strtotime($psacrificio['FEC_SACRIFICIO'])); ?>
                                                            <input type="date" class="form-control" id="FEC_SACRIFICIO" name="FEC_SACRIFICIO" placeholder="Ingrese la fecha del sacrificio" value="{{$fecha_formateada}}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="psacrificio">Codigo del Animal</label>
                                                            <input type="text" class="form-control" id="COD_ANIMAL" name="COD_ANIMAL" placeholder="Ingrese el codigo del animal" value="{{$psacrificio['COD_ANIMAL']}}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="psacrificio">Direccion del Sacrificio</label>
                                                            <input type="text" class="form-control" id="DIR_PSACRIFICIOL" name="DIR_PSACRIFICIO" placeholder="Ingrese la direccion del sacrificio" value="{{$psacrificio['DIR_PSACRIFICIO']}}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <!-- Boton de confirmar al editar -->
                                                            <button type="submit" class="btn btn-primary">Editar</button>
                                                            <!-- Boton de cancelar -->
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
                            
                                {
                extend: "pdfHtml5",
                filename: "Permisos de Sacrificio",
                title: "Permisos de Sacrificio",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                titleAttr: "Exportar a PDF",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },  
            {
                                extend: "print",
                                filename: "Permisos de Sacrificio",
                                title: "Permisos de Sacrificio",
                                text: "<i class='fa-solid fa-print'></i>",
                                tittleAttr: "Imprimir",
                                className: "btn btn-secondary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6], //exportar solo la primera hasta las sexta tabla
                                },
                            },
                        ],
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
