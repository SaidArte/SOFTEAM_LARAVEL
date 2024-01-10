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
        $objeto = 'ANIMALES'; // Por ejemplo, el objeto deseado.
        $rol = session('user_data')['NOM_ROL'];
        $tienePermiso = $authController->tienePermiso($rol, $objeto);
    ?>
    @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
            <center>
                <h1>Información  Animales</h1>
            </center>

       
            

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
            
            <div class="modal fade bd-example-modal-lg" id="Animal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Nuevo Animal</h5>
                            
                        </div>
                        <div class="modal-body container-fluid">
                            <form action="{{ url('Animal/insertar') }}" method="post"  class="needs-validation Animal-form">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="id">DNI Dueño</label>
                                         <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese Identidad del Dueño" maxlength="13" oninput="buscarPersona(this.value)" required>
                                         <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nom">Dueño Fierro</label>
                                         <input type="text"readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA"  required>
                                    </div>
                               
                                    <div class="mb-3">
                                        <input type="hidden"readonly  id="COD_PERSONA" class="form-control" name="COD_PERSONA"  oninput="buscarPersona(this.value)" required>
                                    </div> 
                                    <div class="col-md-6">
        
                                        <label for="nom">N° Fierro</label>
                                        <input type="text" readonly id="COD_FIERRO" class="form-control" name="COD_FIERRO">
                                    </div> 
                               </div>
                                    <div class="col-md-6">
                                        <img id="imagenFierro" src="" alt="Imagen del Fierro" style="display: none; max-width: 60%; max-height: 60%; ">

                                        <label for="nom">Imagen Fierro</label>
                                        <input type="text" readonly id="IMG_FIERRO" class="form-control" name="IMG_FIERRO">
                                    </div> 

                            <div class="row">    
                                <div class="col-md-6">
                                    <label for="CLAS_ANIMAL" >Clases Animal</label>
                                    <input type="text" id="CLAS_ANIMAL" class="form-control" name="CLAS_ANIMAL" placeholder="Ingresar a Clases del Animal" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras"  maxlength="15" required>
                                    <div class="invalid-feedback">Ingrese solo letras en Clases del Animal</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="RAZ_ANIMAL">Raza Animal</label>
                                    <input type="text" class="form-control" id="RAZ_ANIMAL" name="RAZ_ANIMAL" 
                                           placeholder="Ingrese el Raza del Animal" required 
                                           pattern="[A-Za-z ]+" title="Ingrese solo letras y espacios en el color del animal"
                                           minlength="3" maxlength="20">
                                    <div class="invalid-feedback">Ingrese entre 3 y 20 caracteres, solo letras y espacios en el color del animal</div>
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

                                    <label for="DET_ANIMAL">Detalle del Animal</label>
                                    <input type="text" id="DET_ANIMAL" class="form-control" name="DET_ANIMAL" placeholder="Ingrese detalle del animal"  maxlength="200" required >
                                    <div class="invalid-feedback">Ingrese detalle  animal </div>

                                  
                                </div>
                                
                                

                                

                            </div>        
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                    <button type="button" id="CancelarButton" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
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
                            
                                    $('#CLAS_ANIMAL, #RAZ_ANIMAL, #COL_ANIMAL').on('input', function() {
                                        validateInput($(this), /^[A-Za-z\s]+$/);
                                    });

                                    $('#DET_ANIMAL').on('input', function() {
                                         validateInput($(this), /^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9\s]+$/);
                                    });

                                    $('#dni').on('input', function() {
                                       validateInput($(this), /^\d{13}$/);
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

                                    $('#Animal').submit(function(event) {
                                        // ... tu código de validación y guardar existente ...

                                           if (formIsValid) {
                                                showSuccessMessage();
                                                $('#Animal')[0].reset(); // Esto limpia el formulario
                                            }
                                    });

                                });

                                   //Función para buscar personas .
                                   function buscarPersona(idPersona  ) {
                                            var personasArreglo = <?php echo json_encode($personasArreglo); ?>;
                                            var fierroArreglo = <?php echo json_encode($fierroArreglo); ?>;
                                           

                                            var persona = false;

                                            var personaEncontrada = false;

                                            if(idPersona){
                                                // Itera sobre el arreglo de personas en JavaScript (asumiendo que es un arreglo de objetos)
                                                for (var i = 0; i < personasArreglo.length; i++) {
                                                    if (personasArreglo[i].DNI_PERSONA == idPersona) {
                                                        personaEncontrada = true;
                                                        $('#NOM_PERSONA').val(personasArreglo[i].NOM_PERSONA);
                                                        $('#COD_PERSONA').val(personasArreglo[i].COD_PERSONA);
                                            // Verifica si COD_PERSONA está definido
                                            if (personasArreglo[i].COD_PERSONA) {
                                                                var persona = false;

                                                                // Itera sobre el arreglo de fierros
                                                                for (var j = 0; j < fierroArreglo.length; j++) {
                                                                    if (fierroArreglo[j].COD_PERSONA == personasArreglo[i].COD_PERSONA) {
                                                                        persona = true;
                                                                        
                                                                        // Establece los valores para los fierros encontrados
                                                                        $('#COD_FIERRO').val(fierroArreglo[j].COD_FIERRO);
                                                                        //$('#IMG_FIERRO').val(fierroArreglo[j].IMG_FIERRO);
                                                                        var imagenFierroUrl = fierroArreglo[j].IMG_FIERRO;
                                                    $('#imagenFierro').attr('src', imagenFierroUrl);
                                                    $('#imagenFierro').show();  // Asegúrate de que la imagen sea visible

                                                                        break; // Sale del bucle al encontrar un fierro
                                                                    }
                                                                }

                                                                // Verifica si no se encontró un fierro
                                                                if (!persona) {
                                                                    $('#COD_FIERRO').val('Persona no  Tiene Fierro');
                                                                // $('#IMG_FIERRO').val('Persona no encontrada');
                                                                $('#imagenFierro').hide();  // Oculta la imagen si no se encuentra un fierro
                                                                }
                                                            } else {
                                                                // Si COD_PERSONA no está definido
                                                                $('#COD_FIERRO').val('');
                                                                $('#IMG_FIERRO').val('');
                                                            }
                                                                                                    

                                                        break;
                                                    }
                                                }


                                                if (!personaEncontrada) {
                                                    personaEncontrada = false;
                                                    $('#NOM_PERSONA').val('Persona no encontrada');
                                                    $('#COD_PERSONA').val('');
                                                }

                                            }else{
                                                personaEncontrada = false;
                                                $('#NOM_PERSONA').val('');
                                                $('#COD_PERSONA').val('');
                                            }
                                        };
                                        //Función para buscar personas con fierro.
                                function buscarFierro(COD_PERSONA) {
                                            var fierroArreglo = <?php echo json_encode($fierroArreglo); ?>;
                                            var personaEncontrada = false;

                                            if(COD_PERSONA ){
                                                // Itera sobre el arreglo de personas en JavaScript (asumiendo que es un arreglo de objetos)
                                                for (var i = 0; i < fierroArreglo.length; i++) {
                                                    if (fierroArreglo[i].COD_PERSONA ==COD_PERSONA ) {
                                                        personaEncontrada = true;
                                                        
                                                        $('#COD_FIERRO').val(fierroArreglo[i].COD_FIERRO);
                                                        $('#IMG_FIERRO').val(fierroArreglo[i].IMG_FIERRO);
                                                        break;
                                                    }
                                                }

                                                if (!personaEncontrada) {
                                                    personaEncontrada = false;
                                                   
                                                    $('#COD_FIERRO').val('Persona no encontrada');
                                                    $('#IMG_FIERRO').val('Persona no encontrada');
                                                }

                                            }else{
                                                personaEncontrada = false;
                                               
                                                $('#COD_FIERRO').val('');
                                                $('#IMG_FIERRO').val('');

                                            }
                                        }; 
                                
                                 //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                                 function limpiarFormulario() {
                                    document.getElementById("dni").value = "";
                                    document.getElementById("NOM_PERSONA").value = "";
                                    document.getElementById("COD_PERSONA").value = "";
                                    //document.getElementById("IMG_FIERRO").value = "";
                                    document.getElementById("CLAS_ANIMAL").value = "";
                                    document.getElementById("RAZ_ANIMAL").value = "";
                                    document.getElementById("COL_ANIMAL").value = "";
                                    document.getElementById("COD_FIERRO").value = "";
                                    document.getElementById("VEN_ANIMAL").value = "";
                                    document.getElementById("HER_ANIMAL").value = "";
                                    document.getElementById("DET_ANIMAL").value = "";

                                     // Limpiar el campo de imagen y ocultar la imagen
                                  document.getElementById("IMG_FIERRO").value = "";
                                  document.getElementById("imagenFierro").style.display = 'none';
                                    

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
            <table width=100% cellspacing="7" cellpadding="7" class="table table-hover table-bordered mt-1" id="modAnimal" >
                <thead>
                    <th>N°</th>
                    <th>Dueño Fierro</th>
                    <th>Fecha Registro</th>
                    <th>Clase </th>
                    <th>Color </th> 
                    <th>Venteado </th>
                    <th>Herrado</th>
                    <th>Detalle </th>               
                    <th><center><i class="fas fa-cog"></i></center></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Animal)
                        <tr>
                        <td>{{$Animal['COD_ANIMAL']}}</td>
                        <td>{{$Animal['NOM_PERSONA']}}</td>
                        <td>{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}</td>
                        <td>{{$Animal['CLAS_ANIMAL']}}</td>   
                        <td>{{$Animal['COL_ANIMAL']}}</td>
                        <td>{{ $Animal['VEN_ANIMAL'] === 'S' ? 'Si' : 'No' }}</td>
                        <td>{{ $Animal['HER_ANIMAL'] === 'S' ? 'Si' : 'No' }}</td>
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
                        <div class="modal fade bd-example-modal-lg" id="Animal-edit-{{$Animal['COD_ANIMAL']}}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Actualizar Datos Animales</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body container-fluid ">
                                        <form action="{{ url('Animal/actualizar') }}" method="post" class="row g-3 needs-validation">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_ANIMAL" value="{{$Animal['COD_ANIMAL']}}">
                                                <!--
                                                <div class="col-md-6">
                                                    <label for="Animal">Fecha  Registro Animal</label>
                                                    <input type="text" readonly class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}">
                                                    <input type="date" class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{$Animal['FEC_REG_ANIMAL']}}">
                                    
                                                </div>
                                            -->
                                            <div class="row">  
                                            
                                            <div class="col-md-6">
                                                    <label for="Animal">Clase Animal</label>
                                                    <input type="text" class="form-control" id="CLAS_ANIMAL-{{$Animal['COD_ANIMAL']}}" name="CLAS_ANIMAL" placeholder=" Ingrese La clase Del Animal  " value="{{$Animal['CLAS_ANIMAL']}}" oninput=" validarClase('{{$Animal['COD_ANIMAL']}}', this.value)" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" maxlength="30"required>
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Animal['COD_ANIMAL']}}">Solo Se Permirte Ingresar letras</div>
                                            
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Animal">Raza  Animal</label>
                                                    <input type="text" class="form-control" id="RAZ_ANIMAL-{{$Animal['COD_ANIMAL']}}" name="RAZ_ANIMAL" placeholder=" Ingrese La Raza Del Animal  " value="{{$Animal['RAZ_ANIMAL']}}"oninput=" validarRaza('{{$Animal['COD_ANIMAL']}}', this.value)" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" maxlength="30"required>
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Animal['COD_ANIMAL']}}">Solo Se Permirte Ingresar letras</div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Animal">Color  Animal</label>
                                                    <input type="text" class="form-control" id="COL_ANIMAL-{{$Animal['COD_ANIMAL']}}" name="COL_ANIMAL" placeholder=" Ingrese El Color Del animal  " value="{{$Animal['COL_ANIMAL']}}"oninput=" validarColor('{{$Animal['COD_ANIMAL']}}', this.value)" required>
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Animal['COD_ANIMAL']}}">Solo Se Permirte Ingresar letras</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Animal">N° fierro</label>
                                                    <input type="text" class="form-control" readonly  id="COD_FIERRO" name="COD_FIERRO" placeholder=" Ingrese El Codigo Del Fierro  " value="{{$Animal['COD_FIERRO']}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Animal" class="form-label"> Venteado  Animal</label>
                                                
                                                    <select class="form-select  custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" value="{{$Animal['VEN_ANIMAL']}}"required >
                                                        <option value="S" @if($Animal['VEN_ANIMAL'] === 'S') selected @endif>SI</option>
                                                        <option value="N" @if($Animal['VEN_ANIMAL'] === 'N') selected @endif>NO</option>                                                      
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Animal" class="form-label">Herrado Animal</label>
                                                    <select class="form-select custom-select"  id="HER_ANIMAL" name="HER_ANIMAL" value="{{$Animal['HER_ANIMAL']}}" required>
                                                        <option value="S" @if($Animal['HER_ANIMAL'] === 'S') selected @endif>SI</option>
                                                        <option value="N" @if($Animal['HER_ANIMAL'] === 'N') selected @endif>NO</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Animal">Detalle Animal</label>
                                                    <input type="text" class="form-control" id="DET_ANIMAL-{{$Animal['COD_ANIMAL']}}" name="DET_ANIMAL" placeholder=" Ingrese El Detalle Del Animal  " value="{{$Animal['DET_ANIMAL']}}"oninput=" validarDet('{{$Animal['COD_ANIMAL']}}', this.value)"  required>
                                                    <div class="invalid-feedback" id="invalid-feedback6-{{$Animal['COD_ANIMAL']}}">Solo Se Permirte Ingresar letras</div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary" id="submitButton-{{$Animal['COD_ANIMAL']}}">Editar</button>
                                                     <a href="{{ url('Animal') }}" class="btn btn-danger">Cancelar</a>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <script>                                          
                                            function validarClase(id, clase) {
                                                var btnGuardar = document.getElementById("submitButton-" + id);
                                                var inputElement = document.getElementById("CLAS_ANIMAL-" + id);
                                                var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                                if (clase.length < 5 || clase.length > 10 || !/^[a-zA-Z\s]+$/.test(clase)) {
                                                    inputElement.classList.add("is-invalid");
                                                    invalidFeedback.textContent = "La clase debe tener al menos 5 caracteres y no más de 10, sin números";
                                                    btnGuardar.disabled = true;
                                                } else {
                                                    inputElement.classList.remove("is-invalid");
                                                    invalidFeedback.textContent = "";
                                                    btnGuardar.disabled = false;
                                                }
                                            }
                                            function validarRaza(id, raza) {
                                            var btnGuardar = document.getElementById("submitButton-" + id);
                                            var inputElement = document.getElementById("RAZ_ANIMAL-" + id);
                                            var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                            if (raza.length < 5 || raza.length > 10 || !/^[a-zA-Z\s]+$/.test(raza)) {
                                            inputElement.classList.add("is-invalid");
                                            invalidFeedback.textContent = "La raza debe tener al menos 5 caracteres y no más de 10, sin números";
                                            btnGuardar.disabled = true;
                                            } else {
                                            inputElement.classList.remove("is-invalid");
                                            invalidFeedback.textContent = "";
                                            btnGuardar.disabled = false;
                                            }
                                            }

                                            function validarColor(id, color) {
                                            var btnGuardar = document.getElementById("submitButton-" + id);
                                            var inputElement = document.getElementById("COL_ANIMAL-" + id);
                                            var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                            if (color.length < 4 || color.length > 15 || !/^[a-zA-Z\s]+$/.test(color)) {
                                            inputElement.classList.add("is-invalid");
                                            invalidFeedback.textContent = "El color debe tener al menos 4 caracteres y no más de 15, sin números";
                                            btnGuardar.disabled = true;
                                            } else {
                                            inputElement.classList.remove("is-invalid");
                                            invalidFeedback.textContent = "";
                                            btnGuardar.disabled = false;
                                            }
                                            }

                                            function validarDet(id, det) {
                                            var btnGuardar = document.getElementById("submitButton-" + id);
                                            var inputElement = document.getElementById("DET_ANIMAL-" + id);
                                            var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                            if (det.length < 5 || det.length > 100 || !/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9\s]+$/.test(det)) {
                                            inputElement.classList.add("is-invalid");
                                            invalidFeedback.textContent = "El detalle debe tener al menos 5 caracteres y no más de 100, sin números";
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
                $('#modAnimal').DataTable({
                    responsive: true,
                        dom: "Bfrtilp",
                        buttons: [//Botones de Excel, PDF, Imprimir
                            {
                                extend: "excelHtml5",
                                filename: "Animales",
                                text: "<i class='fa-solid fa-file-excel'></i>",
                                tittleAttr: "Exportar a Excel",
                                className: "btn btn-success",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                },
                                filename: "Animales_municipalidad_talanga", // Nombre personalizado para el archivo Excel 
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
                                filename: "Animales",
                                text: "<i class='fa-solid fa-print'></i>",
                                titleAttr: "Imprimir",
                                className: "btn btn-secondary",
                                footer: true,
                                customize: function(win) {
                                // Agrega tu encabezado personalizado aquí
                                $(win.document.head).append("<style>@page { margin-top: 20px; }</style>");
                                
                                // Agrega dos logos al encabezado
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS DE ANIMALES  </h5>");
                                $(win.document.body).prepend("<div style='text-align: center;'><img src='vendor/adminlte/dist/img/Encabezado.jpg' alt='Logo 1' width='1500' height='400' style='float: left; margin-right: 20px;' />");

                                
                                // Agrega la fecha actual
                                var currentDate = new Date();
                                var formattedDate = currentDate.toLocaleDateString();
                                $(win.document.body).prepend("<p style='text-align: right;'>Fecha de impresión: " + formattedDate + "</p>");
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                                stripHtml: false,
                            },
                        }
                        ],
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
                                    previous: "Anterior"
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