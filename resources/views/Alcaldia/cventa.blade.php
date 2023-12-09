@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp



@section('title', 'Alcaldia')
@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php
                $authController = app(\App\Http\Controllers\AuthController::class);
                $objeto = 'EXPEDIENTECV'; // Por ejemplo, el objeto deseado
                $rol = session('user_data')['NOM_ROL'];
                $tienePermiso = $authController->tienePermiso($rol, $objeto);
            ?>
             @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
            <center><br>
                <h1>Información </h1>
            </center></br>
            <center><br>
                <h1>Expedientes Cartas  Ventas</h1>
            </center></br>
           

        @section('content')
        @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
        <p align="right">
            <button type="button" class="Btn" data-toggle="modal" data-target="#Cventa">
                <div class="sign">+</div>
                <div class="text">Nuevo</div>
            </button>
        </p>
        @endif
       
            <div class="modal fade bd-example-modal-lg" id="Cventa" tabindex="-1">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo Expedientes_Cventas</h5>
                           
                        </div>
                        <div class="modal-body  container-fluid">
                            <form action="{{ url('Cventa/insertar') }}" method="post" class="needs-validation cventa-form" >
                                @csrf
                                <!--metodo de inserta en codigo de vendedor  atraendo los datos ya existente de la tabla persona-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="id">DNI</label>
                                         <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese el número de identidad" oninput="buscarPersona(this.value)" required>
                                         <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nom">Nombre Vendedor</label>
                                         <input type="text"readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA"  required>
                                    </div>
                               
                                    <div class="mb-3">
                                        <label for="nom"></label>
                                        <input type="hidden"readonly  id="COD_PERSONA" class="form-control" name="COD_PERSONA"  oninput="buscarPersona(this.value)" required>
                                    </div> 
                                    
                               </div>

                                
                                
                                
                                
                                
                                
                                
                                <div class="row"> 
                                <div class="col-md-6">
                                    <label for="COD_VENDEDOR" >COD Vendedor</label>
                                    <input type="text" id="COD_VENDEDOR" class="form-control" name="COD_VENDEDOR" readonly>
                                </div>

                                <!--metodo de inserta en codigo de comprador  atraendo los datos ya existente de la tabla persona-->
                               <div class="col-md-6">
                                    <label for="NOM_COMPRADOR">Nombre  Comprador</label>
                                    <input type="text" id="NOM_COMPRADOR" class="form-control" name="NOM_COMPRADOR" placeholder="Ingresar el nombre completo de la Comprador"   pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" maxlength="35"  required>
                                    <div class="invalid-feedback">Ingresar el nombre completo de la Comprador</div>
                                </div>
                        
                             <!--    <div class="mb-3">
                                    <label for="DNI_COMPRADOR">Numero de Identidad comprador</label>
                                    <input type="text" id="DNI_COMPRADOR" class="form-control" name="DNI_COMPRADOR" placeholder="Ingresar el numero de identidad de comprador" required>
                                    <div class="invalid-feedback"></div>
                                </div>-->
                                <div class="col-md-6">
                                    <label for="DNI_COMPRADOR">DNI comprador</label>
                                    <input type="text" id="DNI_COMPRADOR" class="form-control @error('DNI_COMPRADOR') is-invalid @enderror" name="DNI_COMPRADOR" placeholder="Ingresar el numero de identidad de comprador" required pattern="[0-9]+" title="Ingrese solo números" maxlength="13">
                                    <div class="invalid-feedback"> Ingresar el DNI completo de la Comprador</div>
                                    @error('DNI_COMPRADOR')
                                        <div class="invalid-feedback">Ingresar el DNI ompleto de la Comprador</div>
                                    @enderror
                                </div>



                                <!--metodo de inserta en codigo de animal  atraendo los datos ya existente de la tabla persona-->
                                

                                <div class="col-md-6">
                                    <label for="COD_ANIMAL">Animal</label>
                                    <select class="form-select custom-select" id="COD_ANIMAL" name="COD_ANIMAL" placeholder="Seleccione Datos de Animal" oninput="buscarAnimal(this.value)" required>
                                        <option value="" disabled selected>Seleccione Datos</option>
                                        @foreach (array_slice($AnimalArreglo, -5) as $Animal)
                                            <option value="{{$Animal['COD_ANIMAL']}}">{{$Animal['COD_ANIMAL']}}</option>
                                        @endforeach 
                                    </select>
                                </div>

                                <!--DATOS DEL ANIMAL-->
                                <div class="col-md-6">
        
                                    <label for="nom">N° Fierro</label>
                                    <input type="text" readonly id="COD_FIERRO" class="form-control" name="COD_FIERRO">
                                </div> 
                              
                              
                              
                               <div class="col-md-6">
                                      
                                    <label for="nom">Clase Animal</label>
                                    <input type="text" readonly id="CLAS_ANIMAL" class="form-control" name="CLAS_ANIMAL">
                                </div>
                              
                               <div class="col-md-6">
                                      
                                    <label for="nom">Color Animla </label>
                                    <input type="text" readonly id="COL_ANIMAL" class="form-control" name="COL_ANIMAL">
                                </div>
                              
                               <div class="col-md-6">
                                      
                                    <label for="nom">Detalle Animal</label>
                                    <input type="text" readonly id="DET_ANIMAL" class="form-control" name="DET_ANIMAL">
                                </div>








                                <div class="col-md-6">
                                    <label for="FOL_CVENTA">Folios Cartas</label>
                                    <input type="text" id="FOL_CVENTA" class="form-control"  @error('FOL_CVENTA') is-invalid @enderror "   name="FOL_CVENTA" placeholder="Ingrese numero de Folio "required pattern="[0-9]+" title="Ingrese solo números" maxlength="5" >
                                    
                                    <div class="invalid-feedback">Ingresar el numero de folio </div>
                                    @error('FOL_CVENTA')
                                        <div class="invalid-feedback">Ingresar el numero de folio</div>
                                    @enderror
                                    
                                    
                                </div>
                            


                                <div class="col-md-6">
                                    <label for="ANT_CVENTA">Antecedentes carta venta</label>
                                    <select class="form-select custom-select"  id="ANT_CVENTA" name="ANT_CVENTA" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="SI" selected >SI</option>
                                        <option value="NO" selected >NO</option>
                                        
                                    
                                    </select>
                                    <div class="invalid-feedback" id="antCventaError">Seleccione una opción válida.</div>
                                </div>
                            </div>
                            
                            

                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="CancelarButton"  class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                        <script>
                            $(document).ready(function() {
                                $('#NOM_COMPRADOR').on('input', function() {
                                    var nombreComprador = $(this).val();
                                    if (!/^[A-Za-z\s]+$/.test(nombreComprador) || nombreComprador.trim().length < 5) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#DNI_COMPRADOR').on('input', function() {
                                    var dniComprador = $(this).val();
                                    var dniRegex = /^[0-9]+$/;
                                    if (dniComprador === "" || !dniComprador.match(dniRegex) || dniComprador.length !== 13) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#FOL_CVENTA').on('input', function() {
                                    var folCventa = $(this).val();
                                    if (!/^[0-9]+$/.test(folCventa) || folCventa.length > 5) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#ANT_CVENTA').on('change', function() {
                                    var antCventa = $(this).val();
                                    if (antCventa === "") {
                                        $(this).addClass('is-invalid');
                                        $('#antCventaError').text('Seleccione una opción.');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                        $('#antCventaError').text('');
                                    }
                                });
                    
                                $('select[required]').on('change', function() {
                                    if ($(this).val() === '' || $(this).val() === null) {
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                    }
                                });
                    
                                $('#Cventa').submit(function(event) {
                                    var formIsValid = true;
                    
                                    if ($('#NOM_COMPRADOR').val().trim().length < 5) {
                                        $('#NOM_COMPRADOR').addClass('is-invalid');
                                        formIsValid = false;
                                    } else {
                                        $('#NOM_COMPRADOR').removeClass('is-invalid');
                                    }
                    
                                    var dniComprador = $('#DNI_COMPRADOR').val();
                                    var dniRegex = /^[0-9]+$/;
                                    if (dniComprador === "" || !dniComprador.match(dniRegex) || dniComprador.length !== 13) {
                                        $('#DNI_COMPRADOR').addClass('is-invalid');
                                        formIsValid = false;
                                    } else {
                                        $('#DNI_COMPRADOR').removeClass('is-invalid');
                                    }
                    
                                    var folCventa = $('#FOL_CVENTA').val();
                                    if (!/^[0-9]+$/.test(folCventa) || folCventa.length > 5) {
                                        $('#FOL_CVENTA').addClass('is-invalid');
                                        formIsValid = false;
                                    } else {
                                        $('#FOL_CVENTA').removeClass('is-invalid');
                                    }
                    
                                    var antCventa = $('#ANT_CVENTA').val();
                                    if (antCventa === "") {
                                        $('#ANT_CVENTA').addClass('is-invalid');
                                        $('#antCventaError').text('Seleccione una opción.');
                                        formIsValid = false;
                                    } else {
                                        $('#ANT_CVENTA').removeClass('is-invalid');
                                        $('#antCventaError').text('');
                                    }


                                                      
                                    if (!formIsValid) {
                                        event.preventDefault();
                                    } else {
                                        showSuccessMessage();
                                    }
                                });
                    
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

                             //Función para buscar personas.
                             function buscarPersona(idPersona) {
                                            var personasArreglo = <?php echo json_encode($personasArreglo); ?>;
                                            var personaEncontrada = false;

                                            if(idPersona){
                                                // Itera sobre el arreglo de personas en JavaScript (asumiendo que es un arreglo de objetos)
                                                for (var i = 0; i < personasArreglo.length; i++) {
                                                    if (personasArreglo[i].DNI_PERSONA == idPersona) {
                                                        personaEncontrada = true;
                                                        $('#NOM_PERSONA').val(personasArreglo[i].NOM_PERSONA);
                                                        $('#COD_PERSONA').val(personasArreglo[i].COD_PERSONA);
                                                         // Asigna el valor de COD_PERSONA a COD_VENDEDOR
                                                          $('#COD_VENDEDOR').val(personasArreglo[i].COD_PERSONA);
                                                        break;
                                                    }
                                                }

                                                if (!personaEncontrada) {
                                                    personaEncontrada = false;
                                                    $('#NOM_PERSONA').val('Persona no encontrada');
                                                    $('#COD_PERSONA').val('');
                                                    $('#COD_VENDEDOR').val(''); // Si no se encuentra la persona, limpia COD_VENDEDOR
                                                }

                                            }else{
                                                personaEncontrada = false;
                                                $('#NOM_PERSONA').val('');
                                                $('#COD_PERSONA').val('');
                                                $('#COD_VENDEDOR').val(''); // Si no hay ID, limpia COD_VENDEDOR
                                            }
                                        };


                                //Función para buscar animal.
                                function buscarAnimal(idAnimal) {
                                            var AnimalArreglo = <?php echo json_encode($AnimalArreglo); ?>;
                                            var AnimalEncontrada = false;

                                            if(idAnimal){
                                                // Itera sobre el arreglo de personas en JavaScript (asumiendo que es un arreglo de objetos)
                                                for (var i = 0; i < AnimalArreglo.length; i++) {
                                                    if (AnimalArreglo[i].COD_ANIMAL == idAnimal) {
                                                        AnimalEncontrada = true;
                                                        $('#CLAS_ANIMAL').val(AnimalArreglo[i].CLAS_ANIMAL);
                                                        $('#COL_ANIMAL').val(AnimalArreglo[i].COL_ANIMAL);
                                                        $('#COD_FIERRO').val(AnimalArreglo[i].COD_FIERRO);
                                                        $('#DET_ANIMAL').val(AnimalArreglo[i].DET_ANIMAL);

                                                        break;
                                                    }
                                                }

                                                if (!AnimalEncontrada) {
                                                    AnimalEncontrada = false;
                                                    $('#CLAS_ANIMAL').val();
                                                        $('#COL_ANIMAL').val();
                                                        $('#COD_FIERRO').val(); 
                                                        $('#DET_ANIMAL').val('');
                                                   
                                                }

                                            }else{
                                                AnimalEncontrada = false;
                                                $('#CLAS_ANIMAL').val('');
                                                $('#COL_ANIMAL').val('');
                                                $('#COD_FIERRO').val('');
                                                $('#DET_ANIMAL').val('');


                                               
                                        }; 
                                    } 


                                       
             

                     


                           

                   


                             //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                             function limpiarFormulario() {
                                    document.getElementById("dni").value = "";
                                    document.getElementById("NOM_PERSONA").value = "";
                                    document.getElementById("COD_PERSONA").value = "";
                                    document.getElementById("COD_VENDEDOR").value = "";
                                    document.getElementById("NOM_COMPRADOR").value = "";
                                    document.getElementById("DNI_COMPRADOR").value = "";
                                    document.getElementById("COD_ANIMAL").value = "";
                                    document.getElementById("FOL_CVENTA").value = "";
                                    document.getElementById("ANT_CVENTA").value = "";

                                    //ANIMAL
                                    document.getElementById("CLAS_ANIMAL").value = "";
                                    
                                    document.getElementById("COL_ANIMAL").value = "";
                                    document.getElementById("COD_FIERRO").value = "";
                                    
                                    document.getElementById("DET_ANIMAL").value = "";

                                    
                                    

                                    const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
                                    invalidFeedbackElements.forEach(element => {
                                        element.textContent = "";
                                    });

                                    const invalidFields = document.querySelectorAll(".form-control.is-invalid");
                                    invalidFields.forEach(field => {
                                        field.classList.remove("is-invalid");
                                    });
                                }
                                document.getElementById("CancelarButton").addEventListener("click", function() {
                                    limpiarFormulario();
                                });


                                





                        </script>









                         
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
            <table  width="100%"  cellspacing="9" cellpadding="9" class="Table table-hover table-bordered mt-1 " id="modCventa" >
                <thead>
                    <th>Código Cventas</th>
                    <th>Fecha Venta</th>
                    
                    <th>Nombre Vendedor</th>
                    <th>Nombre Comprador</th>
                    <th>DNI Comprador</th>
                  
                    <th>Folio Cventa</th>
                  
                    <th><center><i class="fas fa-cog"></i></center></th>
                   
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Cventa)
                        <tr>
                            <td>{{$Cventa['COD_CVENTA']}}</td>
                            <td>{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}</td>
                            
                            <td>{{$Cventa['NombreVendedor']}}</td>
                            <td>{{$Cventa['NOM_COMPRADOR']}}</td> 
                            <td>{{$Cventa['DNI_COMPRADOR']}}</td> 
                          
                            <td>{{$Cventa['FOL_CVENTA']}}</td> 
                            
                            <td>
                            @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                                    <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Cventa-edit-{{$Cventa['COD_CVENTA']}}">
                                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                                    </button>
                            @endif

                             <!-- Boton de PDF -->
                             <button onclick="mostrarVistaPrevia()" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                            </button>
    

                            </td>   
                               
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-lg" id="Cventa-edit-{{$Cventa['COD_CVENTA']}}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <h5 class="modal-title">Actualizar Datos cartas Ventas</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body container-fluid">
                                        <form action="{{ url('Cventa/actualizar') }}" method="post" class="row g-3 needs-validation" >
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_CVENTA" value="{{$Cventa['COD_CVENTA']}}">

                                              


                                                <div class="row">

                                                <div class="col-md-6">
                                                    <label for="Cventa">Fecha  Registro Cventa</label>
                                                    <input type="text" readonly class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}">
                                                    <input type="date" class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{$Cventa['FEC_CVENTA']}}">
                                    
                                                </div>

                                                







                                                <div class="col-md-6">
                                                    <label for="Cventa">Codigo Vendedor</label>
                                                    <input type="text" class="form-control" id="COD_VENDEDOR-{{$Cventa['COD_CVENTA']}}" name="COD_VENDEDOR" placeholder=" Ingrese el codigo del vendedor  " value="{{$Cventa['COD_VENDEDOR']}}   ">
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Cventa['COD_CVENTA']}}"></div>
                                                </div>

                                                

                                                <div class="col-md-6">
                                                    <label for="Cventa">Nombre Comprador</label>
                                                    <input type="text" class="form-control" id="NOM_COMPRADOR-{{$Cventa['COD_CVENTA']}}" name="NOM_COMPRADOR" placeholder="Ingrese el nombre del comprador" value="{{$Cventa['NOM_COMPRADOR']}}" oninput=" validarNombre('{{$Cventa['COD_CVENTA']}}', this.value)" required>
                                                     <div class="invalid-feedback" id="invalid-feedback6-{{$Cventa['COD_CVENTA']}}">Solo Se Permirte Ingresar letras</div>
                                                </div>

                                               <div class="col-md-6">
                                                    <label for="Cventa">DNI Comprador</label>
                                                    <input type="text" class="form-control" id="DNI_COMPRADOR-{{$Cventa['COD_CVENTA']}}" name="DNI_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$Cventa['DNI_COMPRADOR']}}"oninput=" validarDNI('{{$Cventa['COD_CVENTA']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Cventa['COD_CVENTA']}}">Solo Se Permirte Ingresar Numeros</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="Cventa">Codigo Animal</label>
                                                    <input type="text" class="form-control" id="COD_ANIMAL-{{$Cventa['COD_CVENTA']}}" name="COD_ANIMAL" placeholder=" Ingrese el codigo del animal  " value="{{$Cventa['COD_ANIMAL']}}">
                                                   
                    
                                        
                                    
                                    
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="Cventa">Folio Carta Venta</label>
                                                    <input type="text" class="form-control" id="FOL_CVENTA-{{$Cventa['COD_CVENTA']}}" name="FOL_CVENTA" placeholder=" Ingrese el numero de folio  " value="{{$Cventa['FOL_CVENTA']}}"oninput=" validarFolio('{{$Cventa['COD_CVENTA']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Cventa['COD_CVENTA']}}">Solo Se Permir Ingrese Numeros</div>
                                                 
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="Cventa" class="form-label">Antecedentes Carta Venta</label>
                                                    <select class="form-select custom-select" id="ANT_CVENTA" name="ANT_CVENTA" value="{{$Cventa['ANT_CVENTA']}}" required>
                                                   
                                                   
                                                        <option value="SI" @if($Cventa['ANT_CVENTA'] === 'SI') selected @endif>SI</option>
                                                        <option value="NO" @if($Cventa['ANT_CVENTA'] === 'NO') selected @endif>NO</option>
                                                        
                                                        
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                  

                                             <!--   <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">Editar</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            </div>-->

                                            <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary" id="submitButton-{{$Cventa['COD_CVENTA']}}">Editar</button>
                                                     <a href="{{ url('Cventa') }}" class="btn btn-danger">Cancelar</a>
                                            </div>
                                        </form>
                                   

                                        <script>
                                            function validarNombre(id, nombre) {
                                                var btnGuardar = document.getElementById("submitButton-" + id);
                                                var inputElement = document.getElementById("NOM_COMPRADOR-" + id);
                                                var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                               if (nombre.length < 5 || nombre.length > 100 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "El nombre debe tener al menos 5 caracteres y no más de 100, sin números";
                                                    btnGuardar.disabled = true;
                                               } else {
                                                   inputElement.classList.remove("is-invalid");
                                                    invalidFeedback.textContent = "";
                                                 btnGuardar.disabled = false;
                                                }
                                            }
       

   
                                                    function validarDNI(id, dni) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("DNI_COMPRADOR-" + id);
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
                                                    function validarFolio(id, folio) {
                                                        var btnGuardar = document.getElementById("submitButton-" + id);
                                                        var inputElement = document.getElementById("FOL_CVENTA-" + id);
                                                        var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                                        
                                                        if (!/^\d{5}$/.test(folio)) {
                                                            inputElement.classList.add("is-invalid");
                                                            invalidFeedback.textContent = " debe tener exactamente 5 dígitos";
                                                            btnGuardar.disabled = true;
                                                        } else {
                                                            inputElement.classList.remove("is-invalid");
                                                            invalidFeedback.textContent = "";
                                                            btnGuardar.disabled = false;
                                                        }
                                                    }

                                                    function mostrarVistaPrevia() {
                                                        // URL de la acción del controlador que genera el PDF
                                                        var nuevaVentana = window.open("{{ url('Cventa/generar-pdf', ['id' => $Cventa['COD_CVENTA']]) }}", '_blank');

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
                        <!--agregado -->
            


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
        <script> console.log('Hi!'); </script>
        <script>
             <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
             <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            
             <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
                 <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>
     
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
                 
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
                     $('#modCventa').DataTable({
                         responsive: true,
                             dom: "Bfrtilp",
                             buttons: [//Botones de Excel, PDF, Imprimir
                                 {
                                     extend: "excelHtml5",
                                     text: "<i class='fa-solid fa-file-excel'></i>",
                                     tittleAttr: "Exportar a Excel",
                                     className: "btn btn-success",
                                     exportOptions: {
                                         columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                     },
                                 },/*
                                 {
                                     extend: "pdfHtml5",
                                     text: "<i class='fa-solid fa-file-pdf'></i>",
                                     tittleAttr: "Exportar a PDF",
                                     className: "btn btn-danger",
                                     exportOptions: {
                                         columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                     },
                                 },*/
                                 {
                                     extend: "print",
                                     text: "<i class='fa-solid fa-print'></i>",
                                     tittleAttr: "Imprimir",
                                     className: "btn btn-secondary",
                                     footer: true,
                            customize: function(win) {
                                // Agrega tu encabezado personalizado aquí
                                $(win.document.head).append("<style>@page { margin-top: 20px; }</style>");
                                
                                // Agrega dos logos al encabezado
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS DE CARTAS DE VENTAS  </h5>");
                                $(win.document.body).prepend("<h6 style='text-align: center;'>  Correo: alcaldiamunicipaltalanga@gmail.com  </h6>");
                                $(win.document.body).prepend("<h6 style='text-align: center;'>Telefonos: 2775-8010, 2775-8018, 2775-8735</h6>");
                                $(win.document.body).prepend("<h6 style='text-align: center;'>=======================================================</h6>");
                                $(win.document.body).prepend("<h6 style='text-align: center;'>DEPARTAMENTO DE FRANCISCO MORAZÁN- HONDURAS, C.A.</h6>");
                                $(win.document.body).prepend("<div style='text-align: center;'><img src='vendor/adminlte/dist/img/Talanga.png' alt='Logo 1' width='100' height='100' style='float: left; margin-right: 20px;' /><img src='vendor/adminlte/dist/img/Honduras.png' alt='Logo 2' width='100' height='100' style='float: right; margin-left: 20px;' /></div>");
                                $(win.document.body).prepend("<h6 style='text-align: center;'>MUNICIPALIDAD TALANGA</h6>");
                                
                                // Agrega la fecha actual
                                var currentDate = new Date();
                                var formattedDate = currentDate.toLocaleDateString();
                                $(win.document.body).prepend("<p style='text-align: right;'>Fecha de impresión: " + formattedDate + "</p>");
                            },
                                     exportOptions: {
                                         columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                     },
                                 },
                             ],
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
                             order: [[0, 'desc']], 
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

