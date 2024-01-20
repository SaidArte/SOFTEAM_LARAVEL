
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
            $objeto = 'CARTA'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
        @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <center><br>
            <h1>Información Carta</h1>
        </center></br>

        @section('content')
            <!-- Boton Nuevo -->
            @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
            <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#carta">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
            @endif
            
            <div class="modal fade bd-example-modal-sm" id="carta" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Nuevo </h5>
                        </div>
                        
                        <div class="modal-body">
                            <!-- Inicio del nuevo formulario -->
                            <form action="{{ url('carta/insertar') }}" method="post" enctype="multipart/form-data" class="needs-validation carta-form">

                                @csrf


                                <!-- Método para insertar en código de vendedor atrayendo los datos ya existentes de la tabla persona -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dni">DNI Vendedor</label>
                                        <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese Identidad del Vendedor" maxlength="13" oninput="buscarPersona(this.value)" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nom">Nombre Vendedor</label>
                                        <input type="text" readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" required>
                                    </div>
                                    <!-- prueba -->
                                    <div class="col-md-6">
                                        <label for="nom">Cod</label>
                                       <input type="text" readonly id="COD_PERSONA" class="form-control" name="COD_PERSONA" oninput="buscarPersona(this.value)" required>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="col-md-6">
                                    
                                        <label for="NOM_COMPRADOR">Nombre Comprador</label>
                                        <input type="text" id="NOM_COMPRADOR" class="form-control" name="NOM_COMPRADOR" placeholder="Ingresar Nombre Completo del Comprador" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" maxlength="35" required>
                                        <div class="invalid-feedback">Ingrese Nombre Completo del Comprador</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DNI_COMPRADOR">DNI Comprador</label>
                                        <input type="text" id="DNI_COMPRADOR" class="form-control @error('DNI_COMPRADOR') is-invalid @enderror" name="DNI_COMPRADOR" placeholder="Ingrese Identidad del Comprador" required pattern="[0-9]+" title="Ingrese solo números" maxlength="13">
                                        <div class="invalid-feedback">Ingresar la Identidad del Comprador</div>
                                        @error('DNI_COMPRADOR')
                                            <div class="invalid-feedback">Ingresar Identidad del Comprador</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="CLAS_ANIMAL" >Clases Animal</label>
                                        <input type="text" id="CLAS_ANIMAL" class="form-control" name="CLAS_ANIMAL" placeholder="Ingresar a Clases del Animal" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras"  maxlength="15" required>
                                        <div class="invalid-feedback">Ingrese solo letras en Clases del Animal</div>
                                    </div>
    
                                   
                                   
                                    <div class="col-md-6">
                                        <label for="COL_ANIMAL">Color Animal</label>
                                        <input type="text" class="form-control" id="COL_ANIMAL" name="COL_ANIMAL" 
                                               placeholder="Ingrese el color del Animal" required 
                                               pattern="[A-Za-z ]+" title="Ingrese solo letras y espacios en el color del animal"
                                               minlength="3" maxlength="20">
                                        <div class="invalid-feedback">Ingrese entre 3 y 20 caracteres, solo letras y espacios en el color del animal</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="COD_FIERRO" >Fierro</label>
                                        <input type="text" id="COD_FIERRO" class="form-control" name="COD_FIERRO" placeholder="Ingrese El Fierro" required>
                                        <div class="invalid-feedback">Ingrese solo numero</div>
                                    </div>
            
                                    
      
                                    <div class="col-md-6">
                                        <label for="VEN_ANIMAL" >Venteado Animal</label>
                                        <select class="form-select custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL"required >
                                            <option value="" disabled selected>Seleccione una opción Venteado</option>
                                            <option value="S" selected >SI</option>
                                            <option value="N" selected >NO</option>
                                                                                  
                                           
                                        </select>
                                    </div>
            
                                    <div class="col-md-6">
                                        <label for="HER_ANIMAL">Herrado Animal</label>
                                        <select class="form-select custom-select" id="HER_ANIMAL" name="HER_ANIMAL"required >
                                            <option value="" disabled selected>Seleccione una opción de Herrado</option>
                                            <option value="S" selected >SI</option>
                                            <option value="N" selected >NO</option>
                                                                                   
                                        </select>
                                    </div> 
                                    
                                    <div class="col-md-6">

                                        <label for="CANT_CVENTA">Monto</label>
                                        <input type="text" id="CANT_CVENTA" class="form-control" name="CANT_CVENTA" placeholder="Ingrese Antecedentes Carta Venta"   required >
                                        <div class="invalid-feedback">Ingrese Monto </div>
    
                                      
                                    </div>



                                    <div class="col-md-6">
                                        <label for="FOL_CVENTA">Folios Carta</label>
                                        <input type="text" id="FOL_CVENTA" class="form-control @error('FOL_CVENTA') is-invalid @enderror" name="FOL_CVENTA" placeholder="Ingrese numero de Folio" required pattern="[0-9]+" title="Ingrese solo números" maxlength="5">
                                        <div class="invalid-feedback">Ingresar el numero de folio</div>
                                        @error('FOL_CVENTA')
                                            <div class="invalid-feedback">Ingresar el numero de folio</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">

                                        <label for="ANT_CVENTA">Antecedentes Carta Venta</label>
                                        <input type="text" id="ANT_CVENTA" class="form-control" name="ANT_CVENTA" placeholder="Ingrese Antecedentes Carta Venta"  maxlength="200" required >
                                        <div class="invalid-feedback">Ingrese Antecedentes Carta Venta </div>
    
                                      
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="IND_CVENTA">Estado</label>
                                            <select class="form-select custom-select" id="IND_CVENTA" name="IND_CVENTA" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="A">ACTIVO</option>
                                                <option value="I">INACTIVO</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                    </div>   
                                    
                                </div>


                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>

                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Inicio de la tabla -->
                    <table  width="100%" cellspacing="14 " cellpadding="14" class="table table-hover table-bordered mt-1" id="carta">
                    <thead>
                            <tr>
                                <th>Nº</th>
                                <th><center>Fecha</center></th>
                                <th><center>Vendedor</center></th>
                                <th><center>Comprador</center></th>
                                <th><center>DNI Comprador</center></th>
                                <th><center>Clase </center></th>
                                <th><center>Color</center></th>
                                <th><center>Fierro</center></th>
                                <th><center>Venteado</center></th>
                                <th><center>Herrado</center></th>
                                <th><center>Monto</center></th>
                                <th><center>Folio</center></th>
                                <th><center>Antecedentes</center></th>
                                <th><center>Estado</center></th>
                                <th><center>Opción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through $citaArreglo and show data -->
                            @foreach($cartaArreglo as $carta)
                                <tr>
                                    
                                    <td>{{$carta['COD_CVENTA']}}</td>
                                    <td>{{date('d-m-y', strtotime($carta['FEC_CVENTA']))}}</td>
                            
                                    <td>{{$carta['NOMBRE_VENDEDOR']}}</td>
                                    <td>{{$carta['NOM_COMPRADOR']}}</td> 
                                    <td>{{$carta['DNI_COMPRADOR']}}</td> 
                                    
                                    <td>{{$carta['CLAS_ANIMAL']}}</td>   
                                    <td>{{$carta['COL_ANIMAL']}}</td>
                                    <td><center>
                                        <img src="{{ asset($carta['IMG_FIERRO']) }}" alt="Imágen del fierro" class="img-fluid" style="max-height: 60px;">
                                    </center></td>
                                    <td>{{ $carta['VEN_ANIMAL']}}</td>
                                    <td>{{ $carta['HER_ANIMAL']}}</td>
                                     <td>{{$carta['CANT_CVENTA']}}</td>
                                    <td>{{$carta['FOL_CVENTA']}}</td> 
                                    <td>{{$carta['ANT_CVENTA']}}</td> 

                                      <td>{{ $carta['IND_CVENTA']}}</td>
                                    <td>
                                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                        <!-- Boton de Editar -->
                                        <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#carta-edit-{{$carta['COD_CVENTA']}}">
                                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                        </button>
                                    @endif
                                        <!-- Boton de PDF -->
                                        <button onclick="mostrarVistaPrevia({{$carta['COD_CVENTA']}})" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                                        </button>
                                    </td>
                                </tr>
                               <!-- Aqui va editar -->
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
                    $('#carta').DataTable({
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
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS CARTA  </h5>");
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