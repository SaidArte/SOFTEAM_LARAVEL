@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')
@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Agrega la clase CSS personalizada aquí -->
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php
        $authController = app(\App\Http\Controllers\AuthController::class);
        $objeto = 'Animales'; // Por ejemplo, el objeto deseado.
        $rol = session('user_data')['NOM_ROL'];
        $tienePermiso = $authController->tienePermiso($rol, $objeto);
    ?>
    @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
            <center>
                <h1>Información de Animales</h1>
            </center>

        <br>
            <center>
                <footer class="blockquote-footer">Animales <cite title="Source Title">Registrados</cite></footer>

            </center>
        </br>
            

        @section('content')
        @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#Animal">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
        @endif
            
            <div class="modal fade bd-example-modal-sm" id="Animal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo Animal</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Animal/insertar') }}" method="post"  class="needs-validation Animal-form">
                                @csrf
                                <div class="mb-3 mt-3">
                                    <label for="CLAS_ANIMAL" >clases de Animal</label>
                                    <input type="text" id="CLAS_ANIMAL" class="form-control" name="CLAS_ANIMAL" placeholder="Ingresar a Clases del Animal" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" required>
                                    <div class="invalid-feedback">Ingresar a Clases del Animal</div>

                                </div>
                                  

                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="RAZ_ANIMAL" >Raza de Animal</label>
                                    <input type="text" id="RAZ_ANIMAL" class="form-control" name="RAZ_ANIMAL" placeholder="Ingresar la  Raza del Animal"pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" required >
                                    <div class="invalid-feedback">Ingresar la Raza del Animal</div>

                                </div>

                            

                            <div class="mb-3 mt-3">
                                <label for="COL_ANIMAL" >Color del Animal</label>
                                <input type="text" id="COL_ANIMAL" class="form-control" name="COL_ANIMAL" placeholder="Ingresar el Color del Animal"pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" required>
                               <!-- <div class="invalid-feedback">Ingresar el Color del Animal</div>-->
                                <div class="invalid-feedback">Ingrese solo letras en el color</div>
                            </div>



                                

                            <!--metodo de inserta en codigo de fierro  atraendo los datos ya existente de la tabla persona-->
                            <div class="mb-3 mt-3">
                                <label for="COD_FIERRO" >Datos de Fierro</label>
                                <select class="form-select custom-select" id="COD_FIERRO" name="COD_FIERRO" required >
                                    <option value="" disabled selected>Seleccione Datos de Fierro </option>
                                    @foreach ($fierroArreglo as $fierro)
                                        <option value="{{$fierro['COD_FIERRO']}}">{{$fierro['COD_FIERRO']}} {{$fierro['COD_PERSONA']}} {{$fierro['TIP_FIERRO']}} {{$fierro['NUM_FOLIO_FIERRO']}} </option>
                                        

                                    @endforeach 
                                    
                                
                                </select>
                            </div>
                        

                        
                                <div class="mb-3 mt-3">
                                    <label for="VEN_ANIMAL" >Venteado Animal</label>
                                    <select class="form-select custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" required >
                                        <option value="" disabled selected>Seleccione una opción Venteado</option>
                                        <option value="S" selected >SI</option>
                                        <option value="N" selected >NO</option>
                                        <option value="" disabled selected>Seleccione una opción Venteado</option>
                                        
                                    
                                    </select>
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="HER_ANIMAL">Herrado Animal</label>
                                    <select class="form-select custom-select" id="HER_ANIMAL" name="HER_ANIMAL" required >
                                        <option value="" disabled selected>Seleccione una opción de Herrado</option>

                                        <option value="S" selected >SI</option>
                                        <option value="N" selected >NO</option>
                                        <option value="" disabled selected>Seleccione una opción de Herrado</option>
                                    
                                    
                                    </select>

                                </div>
            
                        
                                
                                
                                <div class="mb-3 mt-3">
                                    <label for="DET_ANIMAL">Detalle del Animal</label>
                                    <input type="text" id="DET_ANIMAL" class="form-control" name="DET_ANIMAL" placeholder="Ingrese detalle del animal" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras"required >
                                    <div class="invalid-feedback">Ingrese detalle del animal </div>

                                </div>
                            
                            


                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                $(document).ready(function() {
                                    function validateInput(input, regex) {
                                        const value = input.val();
                                        const invalidFeedback = input.siblings('.invalid-feedback');
                            
                                        if (regex.test(value)) {
                                            input.removeClass('is-invalid');
                                            invalidFeedback.hide();
                                        } else {
                                            input.addClass('is-invalid');
                                            invalidFeedback.show();
                                        }
                                    }
                            
                                    function validateSelection(input) {
                                        const value = input.val();
                                        const invalidFeedback = input.siblings('.invalid-feedback');
                            
                                        if (value !== null && value !== '') {
                                            input.removeClass('is-invalid');
                                            invalidFeedback.hide();
                                        } else {
                                            input.addClass('is-invalid');
                                            invalidFeedback.show();
                                        }
                                    }
                            
                                    $('#CLAS_ANIMAL, #RAZ_ANIMAL, #COL_ANIMAL, #DET_ANIMAL').on('input', function() {
                                        validateInput($(this), /^[A-Za-z\s]+$/);
                                    });
                            
                                    $('select').on('change', function() {
                                        validateSelection($(this));
                                    });
                            
                                    $('#Animal').submit(function(event) {
                                        let formIsValid = true;
                            
                                        $('input[required]').each(function() {
                                            if ($(this).val() === '') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('Este campo es requerido').show();
                                                formIsValid = false;
                                            }
                                        });
                            
                                        $('select[required]').each(function() {
                                            if ($(this).val() === '' || $(this).val() === null) {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('Este campo es requerido').show();
                                                formIsValid = false;
                                            }
                                        });
                            
                                        if (!formIsValid) {
                                            event.preventDefault();
                                        } else {
                                                showSuccessMessage();
                                        }
                                    });
                            
                                    // Función para mostrar el mensaje de éxito
                                    function showSuccessMessage() {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Registro Exitoso',
                                                text: 'El registro ha sido guardado exitosamente.',
                                                showConfirmButton: false,
                                                timer: 6000,
                                            });
                                    }
                                    
                            
                                });
                            </script>
                          


                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
            <table cellspacing="9" cellpadding="9" class="Table table-hover table-bordered mt-1 " id="modAnimal" >
                <thead>
                    <th>Código Animal</th>
                    <th>Fecha registro</th>
                    <th>Clase Animal</th>
                    <th>Raza Animal</th>
                    <th>color Animal</th>
                    <th>Código Fierro </th>
                    <th>Dueño Del Fierro </th>
                    <th>Venteado Animal</th>
                    <th>Herrado Animal</th>
                    <th>Detalle Animal</th>
                    
                
                    <th></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Animal)
                        <tr>
                            <td>{{$Animal['COD_ANIMAL']}}</td>
                            <td>{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}</td>
                            <td>{{$Animal['CLAS_ANIMAL']}}</td>   
                            <td>{{$Animal['RAZ_ANIMAL']}}</td> 
                            <td>{{$Animal['COL_ANIMAL']}}</td>
                            <td>{{$Animal['COD_FIERRO']}}</td> 
                            <td>{{$Animal['NOM_PERSONA']}}</td>
                            <td>{{$Animal['VEN_ANIMAL']}}</td>
                            <td>{{$Animal['HER_ANIMAL']}}</td>
                            <td>{{$Animal['DET_ANIMAL']}}</td>


                            <td>
                            @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Animal-edit-{{$Animal['COD_ANIMAL']}}">
                                    <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                </button>
                            @endif
                                <!--
                                <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Animal['COD_ANIMAL']}})">
                                    <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                                </button>
                            -->


                            </td>

                        
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-sm" id="Animal-edit-{{$Animal['COD_ANIMAL']}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Actualizar Datos De Animales</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ingresar Nuevos Datos</p>
                                        <form action="{{ url('Animal/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_ANIMAL" value="{{$Animal['COD_ANIMAL']}}">
                                                <!--
                                                <div class="mb-3">
                                                    <label for="Animal">Fecha De Registro Animal</label>
                                                    <input type="text" readonly class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}">
                                                    <input type="date" class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{$Animal['FEC_REG_ANIMAL']}}">
                                    
                                                </div>
                                            -->
                                                <div class="mb-3">
                                                    <label for="Animal">Clase Del Animal</label>
                                                    <input type="text" class="form-control" id="CLAS_ANIMAL" name="CLAS_ANIMAL" placeholder=" Ingrese La clase Del Animal  " value="{{$Animal['CLAS_ANIMAL']}}">
                                            
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Animal">Raza Del Animal</label>
                                                    <input type="text" class="form-control" id="RAZ_ANIMAL" name="RAZ_ANIMAL" placeholder=" Ingrese La Raza Del Animal  " value="{{$Animal['RAZ_ANIMAL']}}">
                                                    
                                                </div>


                                                <div class="mb-3">
                                                    <label for="Animal">Color Del Animal</label>
                                                    <input type="text" class="form-control" id="COL_ANIMAL" name="COL_ANIMAL" placeholder=" Ingrese El Color Del animal  " value="{{$Animal['COL_ANIMAL']}}">
                                                  

                                                </div>


                                                <div class="mb-3">
                                                    <label for="Animal">Codigo Del fierro</label>
                                                    <input type="text" class="form-control" id="COD_FIERRO" name="COD_FIERRO" placeholder=" Ingrese El Codigo Del Fierro  " value="{{$Animal['COD_FIERRO']}}">
                                                    <select class="form-select custom-select" id="COD_FIERRO" name="COD_FIERRO" >
                                                        <option value="" disabled selected>Seleccione Datos de Fierro </option>
                                                        @foreach ($fierroArreglo as $fierro)
                                                            <option value="{{$fierro['COD_FIERRO']}}">{{$fierro['COD_FIERRO']}} {{$fierro['COD_PERSONA']}} {{$fierro['TIP_FIERRO']}} {{$fierro['NUM_FOLIO_FIERRO']}} </option>
                                                            
                            
                                                        @endforeach 
                                                        
                                                    
                                                    </select>

                                                </div>

                                                

                                                <div class="mb-3 mt-3">
                                                    <label for="Animal" >Esta Venteado El Animal</label>
                                                
                                                    <select class="form-select  custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" value="{{$Animal['VEN_ANIMAL']}}">
                                                        <option value="" disabled selected>Seleccione una opción</option>
                                                        <option value="S" selected >SI</option>
                                                        <option value="N" selected >NO</option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="Animal" class="form-label">Esta Herrado El Animal</label>
                                                
                                                    <select class="form-select  custom-select" id="HER_ANIMAL" name="HER_ANIMAL" value="{{$Animal['HER_ANIMAL']}}" >
                                                        <option value="" disabled selected>Seleccione una opción</option>
                                                        <option value="S" selected >SI</option>
                                                        <option value="N" selected >NO</option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="Animal">Detalle Del Animal</label>
                                                    <input type="text" class="form-control" id="DET_ANIMAL" name="DET_ANIMAL" placeholder=" Ingrese El Detalle Del Animal  " value="{{$Animal['DET_ANIMAL']}}">
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
        <script> console.log('Hi!'); </script>
        <script>
                <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#modAnimal').DataTable({
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

        @section('js')
        <script> console.log('Hi!'); </script>
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
