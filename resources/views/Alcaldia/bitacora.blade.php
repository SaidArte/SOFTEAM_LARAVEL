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
            /* Estilo para alinear texto en encabezados */
            #sysbitacora thead th {
                white-space: nowrap; /* Evita que el texto se divida en varias líneas */
                overflow: hidden; /* Oculta el desbordamiento del texto */
                text-overflow: ellipsis; /* Agrega puntos suspensivos al final si el texto es demasiado largo */
                max-width: 200px; /* Establece un ancho máximo para las celdas del encabezado */
            }

            /*Estilo para el interruptor de activado y desactivado*/
            .switch {
                display: inline-flex;
                align-items: center;
                cursor: pointer;
            }

            .switch .switch-text {
                margin-right: 10px; /* Ajusta el valor según tu preferencia */
            }

            .switch input {
                display: none;
            }

            .slider {
                width: 40px;
                height: 20px;
                background-color: #ccc;
                transition: 0.4s;
                border-radius: 34px;
                position: relative;
            }

            .slider:before {
                content: "";
                height: 16px;
                width: 16px;
                background-color: white;
                transition: 0.4s;
                border-radius: 50%;
                position: absolute;
                left: 2px;
                bottom: 2px;
            }

            input:checked + .slider {
                background-color: #2196F3;
            }

            input:checked + .slider:before {
                transform: translateX(20px);
            }
            /*Fin del estilo del botón de activar*/
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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
             @if(session('user_data')['NOM_ROL'] == "ADMINISTRADOR")
                <center><br>
                    <h1>Bitácora del Sistema</h1>
                </center></br>
                
            @stop
            
            @section('content')
            <label for="toggle-triggers" class="switch">
                <span class="switch-text">Activar</span>
                <input type="checkbox" id="toggle-triggers" {{$triggerText === 'S' ? 'checked' : ''}}>
                <span class="slider"></span>
            </label>
            @csrf
                <div class="card">
                    <div class="card-body">
                        <div style="overflow-x: auto; width: 100%;">
                            <table width=100% cellspacing="8" cellpadding="8" class="table table-hover table-bordered mt-1" id="sysbitacora">
                                <thead>
                                    <tr>
                                        <th><center>Nº</center></th>
                                        <th><center>Tipo de Evento</center></th>
                                        <th><center>Usuario D.B.</center></th>
                                        <th><center>Fecha/hora Evento</center></th>
                                        <th><center>Nombre Objeto</center></th>
                                        <th><center>Modulo</center></th>
                                        <th><center>Estado Objeto</center></th>
                                        @for ($i = 1; $i <= 14; $i++)
                                        <th><center>Registro Nuevo #{{ $i }}</center></th>
                                        <th><center>Registro Anterior #{{ $i }}</center></th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop through $citaArreglo and show data -->
                                    @foreach($bitacoraArreglo as $Bitacora)
                                        <tr>
                                            <td>{{$Bitacora['COD_BITACORA']}}</td>
                                            <td>{{$Bitacora['TIP_EVENTO']}}</td>
                                            <td>{{$Bitacora['USUARIO_DB']}}</td>
                                            <td>{{date('d-m-Y h:i:s', strtotime($Bitacora['FEC_REG_TIP_EVENTO']))}}</td>  
                                            <td>{{$Bitacora['NOM_TABLA']}}</td> 
                                            <td>{{$Bitacora['MOD_TABLA']}}</td>
                                            <td>{{$Bitacora['IND_TABLA']}}</td>
                                            <td>{{$Bitacora['REG1']}}</td>
                                            <td>{{$Bitacora['REG2']}}</td>
                                            <td>{{$Bitacora['REG3']}}</td>
                                            <td>{{$Bitacora['REG4']}}</td>
                                            <td>{{$Bitacora['REG5']}}</td>
                                            <td>{{$Bitacora['REG6']}}</td>
                                            <td>{{$Bitacora['REG7']}}</td>
                                            <td>{{$Bitacora['REG8']}}</td>
                                            <td>{{$Bitacora['REG9']}}</td>
                                            <td>{{$Bitacora['REG10']}}</td>
                                            <td>{{$Bitacora['REG11']}}</td>
                                            <td>{{$Bitacora['REG12']}}</td>
                                            <td>{{$Bitacora['REG13']}}</td>
                                            <td>{{$Bitacora['REG14']}}</td>
                                            <td>{{$Bitacora['REG15']}}</td>
                                            <td>{{$Bitacora['REG16']}}</td>
                                            <td>{{$Bitacora['REG17']}}</td>
                                            <td>{{$Bitacora['REG18']}}</td>
                                            <td>{{$Bitacora['REG19']}}</td>
                                            <td>{{$Bitacora['REG20']}}</td>
                                            <td>{{$Bitacora['REG21']}}</td>
                                            <td>{{$Bitacora['REG22']}}</td>
                                            <td>{{$Bitacora['REG23']}}</td>
                                            <td>{{$Bitacora['REG24']}}</td>
                                            <td>{{$Bitacora['REG25']}}</td>
                                            <td>{{$Bitacora['REG26']}}</td>
                                            <td>{{$Bitacora['REG27']}}</td>
                                            <td>{{$Bitacora['REG28']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                            const runButton = document.getElementById('toggle-triggers');

                            runButton.addEventListener('click', () => {
                            runButton.classList.toggle('active'); // Alternar la clase 'active' al hacer clic
                            });
                        });

                        $(document).ready(function() {
                            $('#sysbitacora').DataTable({
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
                                        },
                                    ],
                                    lengthMenu : [5, 10, 20, 30, 40, 50],
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
                <script>
                    $(document).ready(function () {
                        const toggleTriggers = document.getElementById('toggle-triggers');
                        
                        toggleTriggers.addEventListener('change', function () {
                            const route = this.checked ? '{{ route('activar-bitacora') }}' : '{{ route('desactivar-bitacora') }}';

                            fetch(route, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Incluye el token CSRF
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error en la solicitud: ' + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data && data.message) {
                                    // Realizar acciones con la respuesta si es necesario
                                } else {
                                    throw new Error('Respuesta vacía o no válida');
                                }
                            })
                            .catch(error => {
                                // Manejar el error
                                console.error(error);
                            });
                        });
                    });

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
                window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta.
            </script>   
    @endif
@stop