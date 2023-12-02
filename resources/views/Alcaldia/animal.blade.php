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
                                        <label for="id">DNI</label>
                                         <input type="text" id="dni" class="form-control" name="dni" placeholder="Ingrese el número de identidad" oninput="buscarPersona(this.value)" required>
                                         <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nom">Dueño Fierro</label>
                                         <input type="text"readonly id="NOM_PERSONA" class="form-control" name="NOM_PERSONA"  required>
                                    </div>
                               
                                    <div class="mb-3">
                                        <input type="hidden"readonly  id="COD_PERSONA" class="form-control" name="COD_PERSONA"  oninput="buscarPersona(this.value)" required>
                                    </div> 
                                    <div class="mb-3">
        
                                        <label for="nom">N° Fierro</label>
                                        <input type="text" readonly id="COD_FIERRO" class="form-control" name="COD_FIERRO">
                                    </div> 
                               </div>
                                    <div class="mb-3">
                                        <img id="imagenFierro" src="" alt="Imagen del Fierro" style="display: none;">
                                        <label for="nom">Imagen Fierro</label>
                                        <input type="text" readonly id="IMG_FIERRO" class="form-control" name="IMG_FIERRO">
                                    </div> 

                            <div class="row">    

                                <div class="col-md-6">
                                    <label for="CLAS_ANIMAL" >Clases Animal</label>
                                    <select class="form-select custom-select" id="CLAS_ANIMAL" name="CLAS_ANIMAL" required >
                                        <option value="" disabled selected>Seleccione una clase de animal</option>
                                        <option value="Vaca" selected >Vaca</option>
                                        <option value="Caballo" selected >Caballo</option>
                                        <option value="Cerdo" selected >Cerdo</option>
                                        <option value="Burro" selected >Burro</option>
                                        <option value="Mula" selected >Mula</option>
                                        <option value="Yegua" selected >Yegua</option>
                                        <option value="" disabled selected>Seleccione una clase de animal</option>
                                       
                                       
                                    </select>
                                </div>
        
                                <div class="col-md-6">
                                    <label for="RAZ_ANIMAL" >Raza Animal</label>
                                    <select class="form-select custom-select" id="RAZ_ANIMAL" name="RAZ_ANIMAL"required >
                                        <option value="" disabled selected>Seleccione una Raza de Animal</option>
                                       <!--Raza de Vaca-->
                                        <option value="Holstein" selected >Vaca Holstein</option>
                                        <option value="criolla" selected >Vaca criolla</option>
                                        <option value="Hereford" selected >Vaca Hereford</option>
                                        <option value="simmental<" selected >Vaca simmental</option>
                                        <option value="Angus " selected >Vaca Angus </option>
                                        <option value="Angus rojo" selected >Vaca Angus rojo</option>
                                        <option value="Brangus" selected >Vaca Brangus</option>
                                        <option value="Ganado Lechero" selected >Vaca Ganado Lechero</option>
                                       <!--Raza de caballlo-->
                                        <option value="criollo" selected >Caballo criollo</option>
                                        <option value="mustang" selected >Caballo mustang</option>
                                        <option value="shire" selected >Caballo shire</option>
                                        <option value="frison" selected >Caballo frison</option>
                                        <option value="arabe" selected >Caballo arabe</option>
                                        <option value="pura sangre ingles" selected >Caballo pura sangre ingles</option>
                                        <!--Raza de Cerdo-->
                                        <option value="criollo" selected >Cerdo criollo</option>
                                        <!--Raza de Burro-->
                                        <option value="criollo" selected >Burro criollo</option>
                                        <!--Raza de Yegua-->
                                        <option value="criollo" selected >Yegua criollo</option>
                                        <option value="" disabled selected>Seleccione una Raza de Animal</option>
        
        
                                       
                                    </select>
                                </div>
                               
        
                            <div class="col-md-6">
                                <label for="COL_ANIMAL" >Color  Animal</label>
                                <select class="form-select custom-select" id="COL_ANIMAL" name="COL_ANIMAL" required >
                                    <option value="" disabled selected>Seleccione el color del Ganado</option>
        
                                    <option value=" castaño" selected >castaño</option>
                                    <option value="marron" selected >marron</option>
                                    <option value="blanco" selected >blanco</option>
                                    <option value=" negro" selected >negro</option>
                                    <option value="cafes" selected >cafes</option>
                                    <option value="manchado " selected >manchado </option>
                                    <option value="Gris" selected >Gris </option>
                                    <option value="" disabled selected>Seleccione el color del Ganado</option>
                                   
                                </select>
                            </div>
        
                            
                          

                        
                                <div class="col-md-6">
                                    <label for="VEN_ANIMAL" >Venteado Animal</label>
                                    <select class="form-select custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL"required >
                                        <option value="" disabled selected>Seleccione una opción Venteado</option>
                                        <option value="S" selected >SI</option>
                                        <option value="N" selected >NO</option>
                                        <option value="" disabled selected>Seleccione una opción Venteado</option>
                                        
                                       
                                    </select>
                                </div>
        
                                <div class="col-md-6">
                                    <label for="HER_ANIMAL">Herrado Animal</label>
                                    <select class="form-select custom-select" id="HER_ANIMAL" name="HER_ANIMAL"required >
                                        <option value="" disabled selected>Seleccione una opción de Herrado</option>
        
                                        <option value="S" selected >SI</option>
                                        <option value="N" selected >NO</option>
                                        <option value="" disabled selected>Seleccione una opción de Herrado</option>
                                       
                                    </select>
                                </div>
            
                        
                                
                                <div class="col-md-6">
                                    <label for="DET_ANIMAL">Detalle  Animal</label>
                                    <input type="text" id="DET_ANIMAL" class="form-control" name="DET_ANIMAL" placeholder="Ingrese detalle del animal"required >
                                    <div class="invalid-feedback">Ingrese solo letras en detalle del animal </div>
                                </div>
                            </div>  
                               
        
        
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button"id="CancelarButton"  class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
                                    document.getElementById("IMG_FIERRO").value = "";
                                    document.getElementById("CLAS_ANIMAL").value = "";
                                    document.getElementById("RAZ_ANIMAL").value = "";
                                    document.getElementById("COL_ANIMAL").value = "";
                                    document.getElementById("COD_FIERRO").value = "";
                                    document.getElementById("VEN_ANIMAL").value = "";
                                    document.getElementById("HER_ANIMAL").value = "";
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
            <table cellspacing="9" cellpadding="9" class="Table table-hover table-bordered mt-1 " id="modAnimal" >
                <thead>
                    <th>N° Animal</th>
                    <th>Fecha registro</th>
                    <th>Clase Animal</th>
                    
                    <th>color Animal</th>
                   
                    <th>Dueño Del Fierro </th>
                    <th>Venteado Animal</th>
                    <th>Herrado Animal</th>
                    <th>Detalle Animal</th>
                    
                
                    <th><center><i class="fas fa-cog"></i></center></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Animal)
                        <tr>
                            <td>{{$Animal['COD_ANIMAL']}}</td>
                            <td>{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}</td>
                            <td>{{$Animal['CLAS_ANIMAL']}}</td>   
                         
                            <td>{{$Animal['COL_ANIMAL']}}</td>
                           
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
                                        <h5 class="modal-title">Actualizar Datos Animales</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('Animal/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_ANIMAL" value="{{$Animal['COD_ANIMAL']}}">
                                                <!--
                                                <div class="mb-3">
                                                    <label for="Animal">Fecha  Registro Animal</label>
                                                    <input type="text" readonly class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{date('d-m-y', strtotime($Animal['FEC_REG_ANIMAL']))}}">
                                                    <input type="date" class="form-control" id="FEC_REG_ANIMAL" name="FEC_REG_ANIMAL" value="{{$Animal['FEC_REG_ANIMAL']}}">
                                    
                                                </div>
                                            -->
                                                <div class="mb-3">
                                                    <label for="Animal">Clase Animal</label>
                                                    <input type="text" class="form-control" id="CLAS_ANIMAL" name="CLAS_ANIMAL" placeholder=" Ingrese La clase Del Animal  " value="{{$Animal['CLAS_ANIMAL']}}">
                                            
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Animal">Raza  Animal</label>
                                                    <input type="text" class="form-control" id="RAZ_ANIMAL" name="RAZ_ANIMAL" placeholder=" Ingrese La Raza Del Animal  " value="{{$Animal['RAZ_ANIMAL']}}">
                                                    
                                                </div>


                                                <div class="mb-3">
                                                    <label for="Animal">Color  Animal</label>
                                                    <input type="text" class="form-control" id="COL_ANIMAL" name="COL_ANIMAL" placeholder=" Ingrese El Color Del animal  " value="{{$Animal['COL_ANIMAL']}}">
                                                  

                                                </div>


                                                <div class="mb-3">
                                                    <label for="Animal">Codigo fierro</label>
                                                    <input type="text" class="form-control" id="COD_FIERRO" name="COD_FIERRO" placeholder=" Ingrese El Codigo Del Fierro  " value="{{$Animal['COD_FIERRO']}}">
                                                    <select class="form-select custom-select" id="COD_FIERRO" name="COD_FIERRO" >
                                                        <option value="" disabled selected>Seleccione Datos de Fierro </option>
                                                   
                                                        
                                                    
                                                    </select>

                                                </div>

                                                

                                                <div class="mb-3 mt-3">
                                                    <label for="Animal" > Venteado  Animal</label>
                                                
                                                    <select class="form-select  custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" value="{{$Animal['VEN_ANIMAL']}}">
                                                        <option value="" disabled selected>Seleccione una opción</option>
                                                        <option value="S" selected >SI</option>
                                                        <option value="N" selected >NO</option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="Animal" class="form-label">Herrado Animal</label>
                                                
                                                    <select class="form-select  custom-select" id="HER_ANIMAL" name="HER_ANIMAL" value="{{$Animal['HER_ANIMAL']}}" >
                                                        <option value="" disabled selected>Seleccione una opción</option>
                                                        <option value="S" selected >SI</option>
                                                        <option value="N" selected >NO</option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="Animal">Detalle Animal</label>
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
            $(document).ready(function() {
                $('#modAnimal').DataTable({
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
                            
                                
                                $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS DE FIERROS  </h5>");
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