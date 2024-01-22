
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
            <h1>Información Carta Venta</h1>
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
            
            <div class="modal fade bd-example-modal-lg" id="carta" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Nuevo Registro</h5>
                        </div>
                        
                        <div class="modal-body container-fluid">
                            <!-- Inicio del nuevo formulario -->
                            <form action="{{ url('carta/insertar') }}" method="post" enctype="multipart/form-data" class="needs-validation carta-form">

                                @csrf


                                <!-- Método para insertar en código de vendedor atrayendo los datos ya existentes de la tabla persona -->
                              <!-- comentado para probar el inserta de forma normal
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
                                  
                                    <div class="col-md-6">
                                        <label for="nom">Cod</label>
                                       <input type="text" readonly id="COD_PERSONA" class="form-control" name="COD_PERSONA" oninput="buscarPersona(this.value)" required>
                                    </div>
                                </div>-->

                                <div class="row">

                                    <div class="col-md-4">
                                    
                                        <label for="COD_PERSONA">cod vendedor</label>
                                        <input type="text" id="COD_PERSONA" class="form-control" name="COD_PERSONA"  required>
                                        <div class="invalid-feedback">Ingrese Nombre Completo</div>
                                    </div>


                                    <div class="col-md-4">
                                    
                                        <label for="NOM_COMPRADOR">Nombre Comprador</label>
                                        <input type="text" id="NOM_COMPRADOR" class="form-control" name="NOM_COMPRADOR" placeholder="Ingrese Nombre Completo " pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" maxlength="35" required>
                                        <div class="invalid-feedback">Ingrese Nombre Completo del Comprador</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="DNI_COMPRADOR">DNI Comprador</label>
                                        <input type="text" id="DNI_COMPRADOR" class="form-control @error('DNI_COMPRADOR') is-invalid @enderror" name="DNI_COMPRADOR" placeholder="Ingrese DNI Comprador" required pattern="[0-9]+" title="Ingrese solo números" maxlength="13">
                                        <div class="invalid-feedback">Ingresar la Identidad del Comprador</div>
                                        @error('DNI_COMPRADOR')
                                            <div class="invalid-feedback">Ingresar DNI del Comprador</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="CLAS_ANIMAL" >Clases Animal</label>
                                        <input type="text" id="CLAS_ANIMAL" class="form-control" name="CLAS_ANIMAL" placeholder="Ingrese Clases del Animal" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras"  maxlength="15" required>
                                        <div class="invalid-feedback">Ingrese solo letras en Clases Animal</div>
                                    </div>
    
                                   
                                   
                                    <div class="col-md-4">
                                        <label for="COL_ANIMAL">Color Animal</label>
                                        <input type="text" class="form-control" id="COL_ANIMAL" name="COL_ANIMAL" 
                                               placeholder="Ingrese el color del Animal" required 
                                               pattern="[A-Za-z ]+" title="Ingrese solo letras y espacios en el color del animal"
                                               minlength="3" maxlength="50">
                                        <div class="invalid-feedback">Ingrese entre 3 y 50 caracteres, solo letras y espacios en el color del animal</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="COD_FIERRO" >Fierro</label>
                                        <input type="text" id="COD_FIERRO" class="form-control" name="COD_FIERRO" placeholder="Ingrese El Fierro" required>
                                        <div class="invalid-feedback">Ingrese solo numero</div>
                                    </div>
            
                                    
      
                                    <div class="col-md-4">
                                        <label for="VEN_ANIMAL" >Venteado Animal</label>
                                        <select class="form-select custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL"required >
                                            <option value="" disabled selected>Seleccione una opción Venteado</option>
                                            <option value="S" selected >SI</option>
                                            <option value="N" selected >NO</option>
                                                                                  
                                           
                                        </select>
                                    </div>
            
                                    <div class="col-md-4">
                                        <label for="HER_ANIMAL">Herrado Animal</label>
                                        <select class="form-select custom-select" id="HER_ANIMAL" name="HER_ANIMAL"required >
                                            <option value="" disabled selected>Seleccione una opción de Herrado</option>
                                            <option value="S" selected >SI</option>
                                            <option value="N" selected >NO</option>
                                                                                   
                                        </select>
                                    </div> 
                                    
                                    <div class="col-md-4">

                                        <label for="CANT_CVENTA">Monto Animal</label>
                                        <input type="text" id="CANT_CVENTA" class="form-control" name="CANT_CVENTA" placeholder="Ingrese Monto Animal"   required >
                                        <div class="invalid-feedback">Ingrese Monto </div>
    
                                      
                                    </div>


                                    <div class="col-md-4">
                                        <label for="FOL_CVENTA">Folios Carta</label>
                                        <input type="text" id="FOL_CVENTA" class="form-control @error('FOL_CVENTA') is-invalid @enderror" name="FOL_CVENTA" placeholder="Ingrese numero de Folio" required pattern="[0-9]+" title="Ingrese solo números" maxlength="5">
                                        <div class="invalid-feedback">Ingrese numero folio</div>
                                        @error('FOL_CVENTA')
                                            <div class="invalid-feedback">Ingrese numero folio</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">

                                        <label for="ANT_CVENTA">Antecedentes Animal</label>
                                        <input type="text" id="ANT_CVENTA" class="form-control" name="ANT_CVENTA" placeholder="Ingrese Antecedentes"  maxlength="200" required >
                                        <div class="invalid-feedback">Ingrese Antecedentes Animal </div>
    
                                      
                                    </div>
                                    
                                    <div class="col-md-4">
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
                                        <button type="button" id="CancelarButton" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                           <script>
                                $(document).ready(function() {
                                   function validateInput(input, regex, errorMessage) {
                                       const value = input.val();
                                       const invalidFeedback = input.siblings('.invalid-feedback');

                                       if (regex.test(value)) {
                                          input.removeClass('is-invalid');
                                          invalidFeedback.text('').hide();
                                        } else {
                                           input.addClass('is-invalid');
                                           invalidFeedback.text(errorMessage).show();
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

                                   $('#NOM_COMPRADOR, #DNI_COMPRADOR, #FOL_CVENTA, #ANT_CVENTA, #dni').on('input', function() {
                                      switch ($(this).attr('id')) {
                                          case 'NOM_COMPRADOR':
                                               validateInput($(this), /^[A-Za-z\s]+$/, 'Ingrese un nombre válido.');
                                              break;
                                          case 'DNI_COMPRADOR':
                                          case 'dni':
                                               validateInput($(this), /^\d{13}$/, 'Ingrese un DNI válido.');
                                              break;
                                          case 'FOL_CVENTA':
                                              validateInput($(this), /^[0-9]+$/, 'Ingrese un número válido.');
                                              break;
                                          case 'ANT_CVENTA':
                                              validateInput($(this), /^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9\s]+$/, 'Ingrese un valor válido.');
                                              break;
                                        }
                                    });

                                    $('#CLAS_ANIMAL, #RAZ_ANIMAL, #COL_ANIMAL, #DET_ANIMAL').on('input', function() {
                                        validateInput($(this), /^[A-Za-z\s]+$/, 'Ingrese un valor válido.');
                                    });

                                    $('select').on('change', function() {
                                         validateSelection($(this));
                                    });


                                    $('#carta').submit(function(event) {
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


                                 //Función para buscar personas . USO DE LA BUSQUEDA COMENTADO AUN 
                                 /*function buscarPersona(idPersona  ) {
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
                                        };*/
                                         //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                                function limpiarFormulario() {
                                   /* BUSQUEDA
                                    document.getElementById("dni").value = "";
                                    document.getElementById("NOM_PERSONA").value = "";*/
                                    document.getElementById("COD_PERSONA").value = "";
                                    //document.getElementById("IMG_FIERRO").value = "";
                                   
                                   
                                    document.getElementById("NOM_COMPRADOR").value = "";
                                    document.getElementById("DNI_COMPRADOR").value = "";
                                    document.getElementById("CLAS_ANIMAL").value = "";
                                    document.getElementById("COL_ANIMAL").value = "";
                                    document.getElementById("COD_FIERRO").value = "";
                                    document.getElementById("VEN_ANIMAL").value = "";
                                    document.getElementById("HER_ANIMAL").value = "";
                                    
                                    document.getElementById("CANT_CVENTA").value = "";
                                    document.getElementById("FOL_CVENTA").value = "";
                                    document.getElementById("ANT_CVENTA").value = "";
                                    document.getElementById("IND_CVENTA").value = "";

                                     // Limpiar el campo de imagen y ocultar la imagen
                                 // document.getElementById("IMG_FIERRO").value = "";
                                 // document.getElementById("imagenFierro").style.display = 'none';
                                    

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
            <div class="d-flex align-items-center">
                    <div class="me-2">
                        <label for="fechaInicio" class="me-2">Dia Inicial:</label>
                        <input type="date" id="fechaInicio" class="form-control form-control-sm">
                    </div>
                    <div class="me-2">
                        <label for="fechaFin" class="me-2">Dia Final:</label>
                        <input type="date" id="fechaFin" class="form-control form-control-sm">
                    </div>
                    <button onclick="filtrarPorFecha()" class="btn btn-sm btn-primary">Buscar</button>
                </div>
                    <div class="card-body">
                    <!-- Inicio de la tabla -->
                    <table  width="100%" cellspacing="14 " cellpadding="14" class="table table-hover table-bordered mt-1" id="modCventa">
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
                    <!-- Modal para editar -->
                    <div class="modal fade bd-example-modal-lg" id="carta-edit-{{$carta['COD_CVENTA']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Registro</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <!-- Contenido del formulario de edición -->
                                    <form action="{{ url('carta/actualizar') }}" method="post" class="row g-3 needs-validation">
                                        
                                        <!-- ... (otros campos) ... -->
                                        @csrf
                                        <input type="hidden" class="form-control" name="COD_CVENTA" value="{{$carta['COD_CVENTA']}}">

                                      


                                        <div class="row">

                                            <div class="col-md-4">
                                                <label for="FEC_CVENTA">Fecha Registro Venta</label>
                                                <?php
                                                $fecha_formateada = date('Y-m-d', strtotime($carta['FEC_CVENTA']));
                                                ?>
                                               <input type="date" class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{ $fecha_formateada }}">
                                            </div>

                                        <div class="col-md-4">
                                            <label for="carta">Nombre Vendedor</label>
                                            <input type="text" class="form-control" readonly id="NOMBRE_VENDEDOR-{{$carta['COD_CVENTA']}}" name="NOMBRE_VENDEDOR" placeholder=" Ingrese el codigo del vendedor  " value="{{$carta['NOMBRE_VENDEDOR']}}   ">
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['COD_CVENTA']}}"></div>
                                        </div>

                                        

                                        <div class="col-md-4">
                                            <label for="carta">Nombre Comprador</label>
                                            <input type="text" class="form-control" id="NOM_COMPRADOR-{{$carta['COD_CVENTA']}}" name="NOM_COMPRADOR" placeholder="Ingrese el nombre del comprador" value="{{$carta['NOM_COMPRADOR']}}" oninput=" validarNombre('{{$carta['COD_CVENTA']}}', this.value)" required>
                                             <div class="invalid-feedback" id="invalid-feedback6-{{$carta['COD_CVENTA']}}">Solo Se Permirte Ingresar letras</div>
                                        </div>

                                       <div class="col-md-4">
                                            <label for="carta">DNI Comprador</label>
                                            <input type="text" class="form-control" id="DNI_COMPRADOR-{{$carta['COD_CVENTA']}}" name="DNI_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$carta['DNI_COMPRADOR']}}"oninput=" validarDNI('{{$carta['COD_CVENTA']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['COD_CVENTA']}}">Solo Se Permirte Ingresar Numeros</div>
                                        </div>
                                        <!-- Animal-->

                                        <div class="col-md-4">
                                            <label for="carta">Clase Animal</label>
                                            <input type="text" class="form-control" id="CLAS_ANIMAL-{{$carta['COD_CVENTA']}}" name="CLAS_ANIMAL" placeholder=" Ingrese La clase Del Animal  " value="{{$carta['CLAS_ANIMAL']}}" oninput=" validarClase('{{$carta['COD_CVENTA']}}', this.value)" pattern="^[A-Za-z\s]+$" title="Ingrese solo letras" maxlength="30"required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['COD_CVENTA']}}">Solo Se Permirte Ingresar letras</div>
                                    
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <label for="carta">Color  Animal</label>
                                            <input type="text" class="form-control" id="COL_ANIMAL-{{$carta['COD_CVENTA']}}" name="COL_ANIMAL" placeholder=" Ingrese El Color Del animal  " value="{{$carta['COL_ANIMAL']}}"oninput=" validarColor('{{$carta['COD_CVENTA']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['COD_CVENTA']}}">Solo Se Permirte Ingresar letras</div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="carta">N° fierro</label>
                                            <input type="text" class="form-control" readonly  id="IMG_FIERRO" name="IMG_FIERRO" placeholder=" Ingrese El Codigo Del Fierro  " value="{{$carta['IMG_FIERRO']}}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="carta" class="form-label"> Venteado  Animal</label>
                                        
                                            <select class="form-select  custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" value="{{$carta['VEN_ANIMAL']}}"required >
                                                <option value="SI" @if($carta['VEN_ANIMAL'] === 'SI') selected @endif>SI</option>
                                                <option value="NO" @if($carta['VEN_ANIMAL'] === 'NO') selected @endif>NO</option>                                                      
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="carta" class="form-label">Herrado Animal</label>
                                            <select class="form-select custom-select"  id="HER_ANIMAL" name="HER_ANIMAL" value="{{$carta['HER_ANIMAL']}}" required>
                                                <option value="SI" @if($carta['HER_ANIMAL'] === 'SI') selected @endif>SI</option>
                                                <option value="NO" @if($carta['HER_ANIMAL'] === 'NO') selected @endif>NO</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>


                                        <div class="col-md-4">
                                            <label for="carta">Monto </label>
                                            <input type="text" class="form-control" id="CANT_CVENTA-{{$carta['CANT_CVENTA']}}" name="CANT_CVENTA" placeholder="Ingrese Antecedente" value="{{$carta['CANT_CVENTA']}}" oninput="validarMonto('{{$carta['CANT_CVENTA']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['CANT_CVENTA']}}">Debe tener entre 1 y 5 dígitos numéricos</div>
                                        </div>

        


                                        <div class="col-md-4">
                                            <label for="carta">Folio Carta Venta</label>
                                            <input type="text" class="form-control" id="FOL_CVENTA-{{$carta['COD_CVENTA']}}" name="FOL_CVENTA" placeholder=" Ingrese el numero de folio  " value="{{$carta['FOL_CVENTA']}}"oninput=" validarFolio('{{$carta['COD_CVENTA']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['COD_CVENTA']}}">Solo Se Permir Ingrese Numeros</div>
                                         
                                        </div>

                                      
                                        <div class="col-md-4">
                                            <label for="carta">Antecedentes </label>
                                            <input type="text" class="form-control" id="ANT_CVENTA-{{$carta['ANT_CVENTA']}}" name="ANT_CVENTA" placeholder="Ingrese Antecedente" value="{{$carta['ANT_CVENTA']}}" oninput="validarAntecedente('{{$carta['ANT_CVENTA']}}', this.value)" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['ANT_CVENTA']}}">Solo Se Permite Ingresar letras</div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="carta">Estado</label>
                                            <input type="text" class="form-control" id="IND_CVENTA-{{$carta['IND_CVENTA']}}" name="IND_CVENTA" placeholder="Ingrese Antecedente" value="{{$carta['IND_CVENTA']}}" required>
                                            <div class="invalid-feedback" id="invalid-feedback6-{{$carta['IND_CVENTA']}}">Solo Se Permite Ingresar letras</div>
                                        </div>


                                      <!-- ... ( campos boto editar) ... -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary" id="submitButton-{{$carta['COD_CVENTA']}}">Editar</button>
                                                 <a href="{{ url('carta') }}" class="btn btn-danger">Cancelar</a>
                                            </div>
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

                                            function validarMonto
                                            (id, monto) {
                                                    var btnGuardar = document.getElementById("submitButton-" + id);
                                                    var inputElement = document.getElementById("CANT_CVENTA-" + id);
                                                    var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                                    
                                                    if (!/^\d{5}$/.test(monto)) {
                                                        inputElement.classList.add("is-invalid");
                                                        invalidFeedback.textContent = " debe tener exactamente 5 dígitos";
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


                                                function validarAntecedente(id, antecedente) {
                                                   var btnGuardar = document.getElementById("submitButton-" + id);
                                                   var inputElement = document.getElementById("ANT_CVENTA-" + id);
                                                  var invalidFeedback = document.getElementById("invalid-feedback6-" + id);

                                                  if (antecedente.length < 5 || antecedente.length > 100 || !/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9\s]+$/.test(antecedente)) {
                                                      inputElement.classList.add("is-invalid");
                                                      invalidFeedback.textContent = "El antecedente debe tener al menos 5 caracteres y no más de 100, sin números";
                                                      btnGuardar.disabled = true;
                                                   } else {
                                                      inputElement.classList.remove("is-invalid");
                                                      invalidFeedback.textContent = "";
                                                      btnGuardar.disabled = false;
                                                    }
                                                }






                                                function mostrarVistaPrevia(idcarta) {
                                                   // URL de la acción del controlador que genera el PDF
                                                  var nuevaVentana = window.open("{{ url('carta/generar-pdf') }}/" + idcarta, '_blank');

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
                             filename: "Cartas de Venta",
                             text: "<i class='fa-solid fa-file-excel'></i>",
                             tittleAttr: "Exportar a Excel",
                             className: "btn btn-success",
                             exportOptions: {
                                 columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                             },
                             filename: "Cartas_Ventas_municipalidad_talanga", // Nombre personalizado para el archivo Excel

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
                    filename: "Cartas de Venta",
                    text: "<i class='fa-solid fa-print'></i>",
                    titleAttr: "Imprimir",
                    className: "btn btn-secondary",
                    footer: true,
                    customize: function(win) {
                        // Agrega tu encabezado personalizado aquí
                        $(win.document.head).append("<style>@page { margin-top: 20px; }</style>");
                        
                        // Agrega dos logos al encabezado
                    
                        
                        $(win.document.body).prepend("<h5 style='text-align: center;'>           REGISTROS CARTA DE VENTA  </h5>");
                        $(win.document.body).prepend("<div style='text-align: center;'><img src='vendor/adminlte/dist/img/Encabezado.jpg' alt='Logo 1' width='1500' height='400' style='float: left; margin-right: 20px;' />");

                        
                        // Agrega la fecha actual
                        var currentDate = new Date();
                        var formattedDate = currentDate.toLocaleDateString();
                        $(win.document.body).prepend("<p style='text-align: right;'>Fecha de impresión: " + formattedDate + "</p>");
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
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