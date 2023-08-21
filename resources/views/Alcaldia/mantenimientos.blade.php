@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
            <?php
                $authController = app(\App\Http\Controllers\AuthController::class);
                $objeto = 'Mantenimientos'; // Por ejemplo, el objeto deseado
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
            <div class="modal fade bd-example-modal-sm" id="Mantenimientos" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo mantenimiento</h5>
                            <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Mantenimientos/insertar') }}" method="post" class="needs-validation">
                                @csrf
                                    
                                    <div class="mb-3">
                                        <label for="FEC_HR_MANTENIMIENTO">Fecha y Hora de mantenimiento</label>
                                        <input type="datetime-local" id="FEC_HR_MANTENIMIENTO" class="form-control" name="FEC_HR_MANTENIMIENTO" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="TIP_MANTENIMIENTO">Tipo de Mantenimiento</label>
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
                                        <label for="DES_MANTENIMIENTO">Descripción del Mantenimiento</label>
                                        <input type="text" id="DES_MANTENIMIENTO" class="form-control" name="DES_MANTENIMIENTO" placeholder="Ingresar la descripción del mantenimiento" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="COD_USUARIO">Código de Usuario</label>
                                        <input type="text" id="COD_USUARIO" class="form-control" name="COD_USUARIO" placeholder="Ingresar el código de usuario" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="MON_MANTENIMIENTO">Monto del Mantenimiento</label>
                                        <input type="number" prefix="L. " id="MON_MANTENIMIENTO" class="form-control" name="MON_MANTENIMIENTO" placeholder="Ingrese el costo del mantenimiento" min="1" step="any" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
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
            <table cellspacing="7" cellpadding="7" class="table table-hover table-bordered mt-1" id="ajustes">
                <thead>
                    <th>Nº</th>
                    <th>Fecha de Registro Mantenimiento</th>
                    <th>Fecha y hora Mantenimiento</th>
                    <th>Tipo de Mantenimiento</th>
                    <th>Descripción Mantenimiento</th>
                    <th>Nº</th>
                    <th>Nombre de Usuario</th>
                    <th>Monto Mantenimiento</th>
                    <th>Opciones de la Tabla</th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Mantenimientos)
                        <tr>
                            <td>{{$Mantenimientos['COD_MANTENIMIENTO']}}</td>
                            <td>{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_REG_MANTENIMIENTO']))}}</td>   
                            <td>{{date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_HR_MANTENIMIENTO']))}}</td> 
                            <td>{{$Mantenimientos['TIP_MANTENIMIENTO']}}</td>
                            <td>{{$Mantenimientos['DES_MANTENIMIENTO']}}</td>
                            <td>{{$Mantenimientos['COD_USUARIO']}}</td>
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
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ingresar nuevos datos</p>
                                        <form action="{{ url('Mantenimientos/actualizar') }}" method="post" class="needs-validation">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_MANTENIMIENTO" value="{{$Mantenimientos['COD_MANTENIMIENTO']}}">
                                                
                                                <div class="mb-3">
                                                    <label for="Mantenimientos">Fecha y hora de mantenimiento</label>
                                                    <?php $fecha_formateada = date('d-m-Y h:i:s', strtotime($Mantenimientos['FEC_HR_MANTENIMIENTO'])); ?>
                                                    <input type="datetime-local" class="form-control" id="FEC_HR_MANTENIMIENTO" name="FEC_HR_MANTENIMIENTO" value="{{$fecha_formateada}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LTIP_MANTENIMIENTO">Tipo de Mantenimiento</label>
                                                    <select class="form-select custom-select"  id="TIP_MANTENIMIENTO" name="TIP_MANTENIMIENTO"  value="{{$Mantenimientos['TIP_MANTENIMIENTO']}}">
                                                        <option value="Mantenimiento predictivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_predictivo') selected @endif>Mantenimiento predictivo</option>
                                                        <option value="Mantenimiento preventivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_preventivo') selected @endif>Mantenimiento preventivo</option>
                                                        <option value="Mantenimiento correctivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_correctivo') selected @endif>Mantenimiento correctivo</option>
                                                        <option value="Mantenimiento evolutivo" @if($Mantenimientos['TIP_MANTENIMIENTO'] === 'Mantenimiento_evolutivo') selected @endif>Mantenimiento evolutivo</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LDES_MANTENIMIENTO">Descripción del Mantenimiento</label>
                                                    <input type="text" class="form-control" id="DES_MANTENIMIENTO" name="DES_MANTENIMIENTO" value="{{$Mantenimientos['DES_MANTENIMIENTO']}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LCOD_USUARIO">Código de Usuario</label>
                                                    <input type="text" class="form-control" id="COD_USUARIO" name="COD_USUARIO" value="{{$Mantenimientos['COD_USUARIO']}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LMON_MANTENIMIENTO">Monto del Mantenimiento</label>
                                                    <input type="number" prefix="L. " class="form-control" id="MON_MANTENIMIENTO" name="MON_MANTENIMIENTO" value="{{$Mantenimientos['MON_MANTENIMIENTO']}}" min="1" step="any">
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
                    $('#ajustes').DataTable({
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
                            { width: '10%', target: [8] },
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

