@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))

        @if(session('user_data')['NOM_ROL'] == "ADMINISTRADOR")
            <center><br>
                <h1>Información de Parámetros</h1>
            </center></br>

        @section('content')

        <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#Parametros">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
        <!-- Mensaje de error cuando el rol este repetido -->
        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message')['text'] }}
            </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <div class="text-center">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        </div>
        @endif
            <div class="modal fade bd-example-modal-sm" id="Parametros" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo parámetro</h5>
                            <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('Parametros/insertar') }}" method="post" class="needs-validation param-form">
                                @csrf              
                                    <div class="mb-3">
                                        <label for="paraml">Nombre Parámetro</label>
                                        <input type="text" id="PARAMETRO" class="form-control" name="PARAMETRO" placeholder="Ingresar el nombre del parámetro" oninput="this.value = this.value.toUpperCase()" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paramdesl">Descripción Parámetro</label>
                                        <input type="text" id="DES_PARAMETRO" class="form-control" name="DES_PARAMETRO" placeholder="Ingresar la descripción del parámetro" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paramtipl">Valor Parámetro</label>
                                        <input type="text" id="VALOR" class="form-control" name="VALOR" placeholder="Ingresar el valor del parámetro" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                $(document).ready(function(){
                                    //Validaciones del nombre rol, no permite que se ingrese numeros ni caracteres especiales, solo letras
                                    $('#PARAMETRO').on('input', function() {
                                        var param = $(this).val();
                                        var errorMessage = 'El nombre del parámetro debe contener al menos 5 letras, no debe ser mayor a 20 letras, espacios en blanco y no debe incluir caracteres especiales ni números';
                                        // Verificar si el nombre de rol no incluye carácteres especiales ni números
                                        if (param.length < 5 || param.length > 20 || !/^[a-zA-Z_-]+$/.test(param)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    //Validaciones del nombre rol, no permite que se ingrese numeros ni caracteres especiales, solo letras
                                    $('#DES_PARAMETRO').on('input', function() {
                                        var des_param = $(this).val();
                                        var errorMessage = '';

                                        if (des_param.length < 5) {
                                            errorMessage = 'La descripción debe tener al menos 5 caracteres.';
                                        } else if (des_param.length > 99) {
                                            errorMessage = 'La descripción no puede tener más de 100 caracteres.';
                                        }
                                        if (errorMessage) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    $('#VALOR').on('input', function() {
                                        var valor = $(this).val();
                                        var errorMessage = '';

                                        if (!/^\d+$/.test(valor)) { //Solo debe admitir números.
                                            errorMessage = 'El valor debe ser un número entero.';
                                        } else if (valor < 1 || valor > 5) {
                                            errorMessage = 'El valor debe estar entre 1 y 5.';
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
                                    document.getElementById("PARAMETRO").value = "";
                                    document.getElementById("DES_PARAMETRO").value = "";
                                    document.getElementById("VALOR").value = "";
                                    
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
                                    // Función que se ejecutará después de enviar el formulario
                                    function formSubmitHandler() {
                                    showSuccessMessage();
                                }
                                document.querySelector('.param-form').addEventListener('submit', formSubmitHandler);
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
            <table cellspacing="7" cellpadding="7" class="table table-hover table-bordered mt-1" id="paramtbl">
                <thead>
                    <th><center>Nº</center></th>
                    <th><center>Parámetro</center></th>
                    <th><center>D. Parámetro</center></th>
                    <th><center>V. Parámetro</center></th>
                    <th><center>U. Creador</center></th>
                    <th><center>F. Creación</center></th>
                    <th><center>U. Modificador</center></th>
                    <th><center>F. Modificación</center></th>
                    <th><center><i class="fas fa-cog"></i></center></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($parametrosArreglo as $param)
                        <tr>
                            <td>{{$param['COD_PARAMETRO']}}</td>
                            <td>{{$param['PARAMETRO']}}</td>   
                            <td>{{$param['DES_PARAMETRO']}}</td> 
                            <td>{{$param['VALOR']}}</td>
                            <td>{{$param['USUARIO_CREADOR']}}</td>
                            <td>{{date('d-m-Y h:i:s', strtotime($param['FEC_CREADO']))}}</td>
                            <td>{{$param['USUARIO_MODIFICADOR']}}</td>
                            <td>{{date('d-m-Y h:i:s', strtotime($param['FEC_MODIFICADO']))}}</td>
                            <td>
                            
                                <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Parametros-edit-{{$param['COD_PARAMETRO']}}">
                                <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                </button>
                            
                            </td>
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-sm" id="Parametros-edit-{{$param['COD_PARAMETRO']}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Actualizar datos del parámetro</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('Parametros/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_PARAMETRO" value="{{$param['COD_PARAMETRO']}}">
                                                
                                                <div class="mb-3">
                                                    <label for="paramle">Nombre Parámetro</label>
                                                    <input type="text" readonly readonly class="form-control" id="PARAMETRO-{{$param['COD_PARAMETRO']}}" name="PARAMETRO" value="{{$param['PARAMETRO']}}" oninput="validarParametro('{{$param['COD_PARAMETRO']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback-{{$param['COD_PARAMETRO']}}"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="desparamle">Descripción Parámetro</label>
                                                    <input type="text" class="form-control" id="DES_PARAMETRO-{{$param['COD_PARAMETRO']}}" name="DES_PARAMETRO" value="{{$param['DES_PARAMETRO']}}" oninput="validarDesParametro('{{$param['COD_PARAMETRO']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback2-{{$param['COD_PARAMETRO']}}"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tipparamle">Valor Parámetro</label>
                                                    <input type="text" class="form-control" id="VALOR-{{$param['COD_PARAMETRO']}}" name="VALOR" value="{{$param['VALOR']}}" oninput="validarValParametro('{{$param['COD_PARAMETRO']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback3-{{$param['COD_PARAMETRO']}}"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary" id="submitButton-{{$param['COD_PARAMETRO']}}">Guardar</button>
                                                    <a href="{{ url('Parametros') }}" class="btn btn-danger">Cancelar</a>
                                            </div>
                                        </form>
                                        <script>
                                            function validarParametro(id, param) {
                                                var btnGuardar = document.getElementById("submitButton-" + id);
                                                var inputElement = document.getElementById("PARAMETRO-" + id);
                                                var invalidFeedback = document.getElementById("invalid-feedback-" + id);

                                                // Convertir a mayúsculas.
                                                inputElement.value = inputElement.value.toUpperCase();
                                                if (param.length < 5 || param.length > 20 || !/^[a-zA-Z_-]+$/.test(param)) {
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "El nombre del parámetro debe contener al menos 5 letras, no debe ser mayor a 20 letras.";
                                                    btnGuardar.disabled = true;
                                                } else {
                                                    inputElement.classList.remove("is-invalid");
                                                    invalidFeedback.textContent = "";
                                                    btnGuardar.disabled = false;
                                                }
                                            }

                                            function validarDesParametro(id, des_param) {
                                                var btnGuardar = document.getElementById("submitButton-" + id);
                                                var inputElement = document.getElementById("DES_PARAMETRO-" + id);
                                                var invalidFeedback = document.getElementById("invalid-feedback2-" + id);

                                                if (des_param.length < 5) {
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "La descripción debe tener al menos 5 caracteres.";
                                                    btnGuardar.disabled = true;
                                                } else if (des_param.length > 99) {
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "La descripción no puede tener más de 100 carácteres.";
                                                    btnGuardar.disabled = true;
                                                } else {
                                                    inputElement.classList.remove("is-invalid");
                                                    invalidFeedback.textContent = "";
                                                    btnGuardar.disabled = false;
                                                }
                                            }

                                            function validarValParametro(id, valor) {
                                                var btnGuardar = document.getElementById("submitButton-" + id);
                                                var inputElement = document.getElementById("VALOR-" + id);
                                                var invalidFeedback = document.getElementById("invalid-feedback3-" + id);

                                                if (!/^\d+$/.test(valor)) { //Solo debe admitir números.
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "El valor debe ser un número entero.";
                                                    btnGuardar.disabled = true;
                                                } else if (valor < 1 || valor > 5) {
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "El valor debe estar entre 1 y 5.";
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

        @section('css')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="/css/admin_custom.css">
        <style>
            #paramtbl thead th {
                white-space: nowrap; /* Evita que el texto se divida en varias líneas */
                overflow: hidden; /* Oculta el desbordamiento del texto */
                text-overflow: ellipsis; /* Agrega puntos suspensivos al final si el texto es demasiado largo */
                max-width: 200px; /* Establece un ancho máximo para las celdas del encabezado */
            }

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

        #paramtbl_wrapper {
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

        @section('js')
        <script> console.log('Hi!'); </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script> console.log('Hi!'); </script>
            <script>
            <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#paramtbl').DataTable({
                        responsive: true,
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
                        columnDefs: [
                            { width: '5%', target: [0] },
                            { width: '10%', target: [4] },
                        ],
                    });
                });
                </script>
                </script> 
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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