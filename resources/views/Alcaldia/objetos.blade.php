@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))

        @if(session('user_data')['NOM_ROL'] == "ADMINISTRADOR")
            <center><br>
                <h1>Información de Objetos</h1>
            </center></br>

        @section('content')

        <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#Objetos">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>

            <div class="modal fade bd-example-modal-sm" id="Objetos" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo objeto</h5>
                            <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Objetos/insertar') }}" method="post">
                                @csrf              
                                    <div class="mb-3">
                                        <label for="OBJETO">Nombre del objeto</label>
                                        <input type="text" id="OBJETO" class="form-control" name="OBJETO" placeholder="Ingresar el nombre del objeto" oninput="this.value = this.value.toUpperCase()" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="DES_OBJETO">Descripción del objeto</label>
                                        <input type="text" id="DES_OBJETO" class="form-control" name="DES_OBJETO" placeholder="Ingresar la descripción del objeto" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="TIP_OBJETO">Tipo del objeto</label>
                                        <select class="form-select custom-select" id="TIP_OBJETO" name="TIP_OBJETO" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="Primordial">Primordial</option>
                                            <option value="Servicio">Servicio</option>
                                            <option value="Seguridad">Seguridad</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
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
                                    document.getElementById("OBJETO").value = "";
                                    document.getElementById("DES_OBJETO").value = "";
                                    document.getElementById("TIP_OBJETO").value = "";
                                    
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
            <table cellspacing="7" cellpadding="7" class="table table-hover table-bordered mt-1" id="objetoss">
                <thead>
                    <th>Nº</th>
                    <th>Nombre del Objeto</th>
                    <th>Descripción del Objeto</th>
                    <th>Tipo de Objeto</th>
                    <th>Opciones de la Tabla</th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Objetos)
                        <tr>
                            <td>{{$Objetos['COD_OBJETO']}}</td>
                            <td>{{$Objetos['OBJETO']}}</td>   
                            <td>{{$Objetos['DES_OBJETO']}}</td> 
                            <td>{{$Objetos['TIP_OBJETO']}}</td>
                            <td>
                            
                                <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Objetos-edit-{{$Objetos['COD_OBJETO']}}">
                                <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                </button>
                            
                            </td>
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-sm" id="Objetos-edit-{{$Objetos['COD_OBJETO']}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Actualizar datos del objetos</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ingresar nuevos datos</p>
                                        <form action="{{ url('Objetos/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_OBJETO" value="{{$Objetos['COD_OBJETO']}}">
                                                
                                                <div class="mb-3">
                                                    <label for="OBJETO">Nombre del objeto</label>
                                                    <input type="text" class="form-control" id="OBJETO" name="OBJETO" value="{{$Objetos['OBJETO']}}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="DES_OBJETO">Descripción del objeto</label>
                                                    <input type="text" class="form-control" id="DES_OBJETO" name="DES_OBJETO" value="{{$Objetos['DES_OBJETO']}}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="TIP_OBJETO">Tipo de objeto</label>
                                                    <select class="form-select custom-select" id="TIP_OBJETO" name="TIP_OBJETO" value="{{$Objetos['TIP_OBJETO']}}" required>
                                                        <option value="Primordial" @if($Objetos['TIP_OBJETO'] === 'Primordial') selected @endif>Primordial</option>
                                                        <option value="Servicio" @if($Objetos['TIP_OBJETO'] === 'Servicio') selected @endif>Servicio</option>
                                                        <option value="Seguridad" @if($Objetos['TIP_OBJETO'] === 'Seguridad') selected @endif>Seguridad</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">Editar</button>
                                                    <a href="{{ url('Objetos') }}" class="btn btn-danger">Cancelar</a>
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

        @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
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
                    $('#objetoss').DataTable({
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