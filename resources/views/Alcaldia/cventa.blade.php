@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('content_header')
    @if(session()->has('user_data'))
            <center>
                <h1>Información de Expedientes Cartas De Ventas</h1>
            </center>
            
            <blockquote class="blockquote text-center">
                <p class="mb-0">Registro de Expediente Cartas De Ventas.</p>
                <footer class="blockquote-footer">Expedientes_Cventas <cite title="Source Title">Registrados</cite></footer>
            </blockquote>

        @section('content')

        <p align="right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Cventa">+ Nuevo</button>
        </p>
            
            <div class="modal fade bd-example-modal-sm" id="Cventa" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo Expedientes_Cventas</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Cventa/insertar') }}" method="post">
                                @csrf
                                <!--metodo de inserta en codigo de vendedor  atraendo los datos ya existente de la tabla persona-->
                                <div class="mb-3 mt-3">
                                    <label for="COD_VENDEDOR" >Nombre Vendedor</label>
                                    <select class="form-select custom-select" id="COD_VENDEDOR" name="COD_VENDEDOR" required>
                                        <option value="" disabled selected>Seleccione el Nombre del vendedor</option>
                                        @foreach ($personasArreglo as $personas)
                                            <option value="{{$personas['COD_PERSONA']}}">{{$personas['NOM_PERSONA']}}</option>
                                        @endforeach 
                                        
                                    
                                    </select>
                                </div>

                                <!--metodo de inserta en codigo de comprador  atraendo los datos ya existente de la tabla persona-->
                                <div class="mb-3">
                                    <label for="NOM_COMPRADOR">Nombre del Comprador</label>
                                    <input type="text" id="NOM_COMPRADOR" class="form-control" name="NOM_COMPRADOR" placeholder="Ingresar el nombre completo de la Comprador" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="DNI_COMPRADOR">Numero de Identidad comprador</label>
                                    <input type="text" id="DNI_COMPRADOR" class="form-control" name="DNI_COMPRADOR" placeholder="Ingresar el numero de identidad de comprador" required>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <!--metodo de inserta en codigo de animal  atraendo los datos ya existente de la tabla persona-->
                                <div class="mb-3 mt-3">
                                    <label for="COD_ANIMAL" >Animal</label>
                                    <select class="form-select custom-select" id="COD_ANIMAL" name="COD_ANIMAL" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        @foreach ($AnimalArreglo as $Animal)
                                            <option value="{{$Animal['COD_ANIMAL']}}">{{$Animal['COD_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['RAZ_ANIMAL']}} {{$Animal['COL_ANIMAL']}} {{$Animal['COD_FIERRO']}} {{$Animal['VEN_ANIMAL']}} {{$Animal['HER_ANIMAL']}} {{$Animal['DET_ANIMAL']}}</option>
                                            

                                        @endforeach 
                                        
                                    
                                    </select>
                                </div>
                            

                                <div class="mb-3">
                                    <label for="FOL_CVENTA">Folios De Cartas </label>
                                    <select class="form-select  custom-select " id="FOL_CVENTA" name="FOL_CVENTA"required>
                                        <option value="" disabled selected>Seleccione una opción del folio</option>
                                        <option value="0001">Folio  #0001</option>
                                        <option value="0002">Folio  #0002</option>
                                        <option value="0003">Folio  #0003</option>
                                        <option value="0004">Folio  #0004</option>
                                        <option value="0005">Folio  #0005</option>
                                        <option value="0006">Folio  #0006</option>
                                        <option value="0007">Folio  #0007</option>
                                        <option value="0008">Folio  #0008</option>
                                        <option value="0009">Folio  #0009</option>
                                        <option value="00010">Folio #00010</option>
                                        <option value="00011">Folio #00011</option>
                                        <option value="00012">Folio #00012</option>
                                        <option value="00013">Folio #00013</option>
                                        <option value="00014">Folio #00014</option>
                                        <option value="00015">Folio #00015</option>
                                        <option value="00016">Folio #00016</option>


                                    </select>
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="ANT_CVENTA">Antecedentes de carta venta</label>
                                    <select class="form-select custom-select"  id="ANT_CVENTA" name="ANT_CVENTA" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="SI" selected >SI</option>
                                        <option value="NO" selected >NO</option>
                                    
                                    </select>
                                </div>
                            
                            

                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>

                                // Validación del formulario
                                $(document).ready(function() {
                                    // Validación del formulario

                                    //Validaciones del nombre persona, no permite que se ingrese numeros solo letras
                                    $('#NOM_COMPRADOR').on('input', function() {
                                        var nombre = $(this).val();
                                        var errorMessage = 'El nombre debe tener al menos 5 letras';
                                        if (nombre.length < 5 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                                    });
                                    //Validaciones del campo DNI el cual no permite el ingreso de letras (las bloquea y no se muestra)
                                    //y solo permite el ingreso de numeros
                                    $('#DNI_COMPRADOR').on('input', function() {
                                        var dni = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                        $(this).val(dni); // Actualizar el valor del campo solo con números
                                        var errorMessage = 'El DNI debe tener exactamente 13 dígitos numéricos ';
                                        if (dni.length !== 13) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        
                                    $("#Cventa form").validate({
                                        rules: {
                                            COD_VENDEDOR: "required",
                                            ,
                                            COD_ANIMAL: "required",
                                            FOL_CVENTA: "required",
                                            ANT_CVENTA: "required"
                                            },
                                            messages: {
                                            COD_VENDEDOR: "Por favor, seleccione el nombre del vendedor",
                                            
                                            COD_ANIMAL: "Por favor, seleccione un animal",
                                            FOL_CVENTA: "Por favor, seleccione un folio",
                                            ANT_CVENTA: "Por favor, seleccione una opció"
                                            },
                                            errorElement: "div",
                                            errorPlacement: function(error, element) {
                                                error.addClass("invalid-feedback");
                                                element.closest(".mb-3").append(error);
                                            },
                                            highlight: function(element, errorClass, validClass) {
                                                $(element).addClass("is-invalid").removeClass("is-valid");
                                            },
                                            unhighlight: function(element, errorClass, validClass) {
                                                $(element).removeClass("is-invalid").addClass("is-valid");
                                            }
                                    });
                                });
                


        
                            

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
                                    document.getElementById("COD_VENDEDOR").value = "";
                                    document.getElementById("NOM_COMPRADOR").value = "";
                                    document.getElementById("DNI_COMPRADOR").value = "";
                                    document.getElementById("COD_ANIMAL").value = "";
                                    document.getElementById("FOL_CVENTA").value = "";
                                    document.getElementById("ANT_CVENTA").value = "";
                                

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
                                // Mostrar el modal de registro exitoso cuando se envíe el formulario
                                $('#Cventa form').submit(function() {
                                    $('#registroExitosoModal').modal('show');
                                });    
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <table cellspacing="9" cellpadding="9" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime ; " id="modCventa" >
                <thead>
                    <th>Código Cventas</th>
                    <th>Fecha Venta</th>
                    <th>Código Vendedor</th>
                    <th>Nombre Vendedor</th>
                    <th>Nombre Comprador</th>
                    <th>DNI Comprador</th>
                    <th>Código Animal </th>
                    <th>Folio cventas</th>
                    <th>Antecedentes Cventas </th>
                
                    <th></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($citaArreglo as $Cventa)
                        <tr>
                            <td>{{$Cventa['COD_CVENTA']}}</td>
                            <td>{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}</td>
                            <td>{{$Cventa['COD_VENDEDOR']}}</td> 
                            <td>{{$Cventa['NombreVendedor']}}</td>
                            <td>{{$Cventa['NOM_COMPRADOR']}}</td> 
                            <td>{{$Cventa['DNI_COMPRADOR']}}</td> 
                            <td>{{$Cventa['COD_ANIMAL']}}</td>
                            <td>{{$Cventa['FOL_CVENTA']}}</td> 
                            <td>{{$Cventa['ANT_CVENTA']}}</td>
                            <td>
                                <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Cventa-edit-{{$Cventa['COD_CVENTA']}}">
                                    <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                                </button>
                                
                                <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Cventa['COD_CVENTA']}})">
                                    <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                                </button>
                                

                            </td>
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-sm" id="Cventa-edit-{{$Cventa['COD_CVENTA']}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Actualizar datos de cartas Ventas</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ingresar nuevos datos</p>
                                        <form action="{{ url('Cventa/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_CVENTA" value="{{$Cventa['COD_CVENTA']}}">

                                                <div class="mb-3">
                                                    <label for="Cventa">Fecha  Registro Cventa</label>
                                                    <input type="text" readonly class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{date('d-m-y', strtotime($Cventa['FEC_CVENTA']))}}">
                                                    <input type="date" class="form-control" id="FEC_CVENTA" name="FEC_CVENTA" value="{{$Cventa['FEC_CVENTA']}}">
                                    
                                                </div>

                                                <div class="mb-3">
                                                    <label for="Cventa">Codigo Vendedor</label>
                                                    <input type="text" class="form-control" id="COD_VENDEDOR" name="COD_VENDEDOR" placeholder=" Ingrese el codigo del vendedor  " value="{{$Cventa['COD_VENDEDOR']}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Cventa">nombre Comprador</label>
                                                    <input type="text" class="form-control" id="NOM_COMPRADOR" name="NOM_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$Cventa['NOM_COMPRADOR']}}">
                                                </div>

        <div class="mb-3">
                                                    <label for="Cventa">DNI Comprador</label>
                                                    <input type="text" class="form-control" id="DNI_COMPRADOR" name="DNI_COMPRADOR" placeholder=" Ingrese el codigo del comprador  " value="{{$Cventa['DNI_COMPRADOR']}}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="Cventa">Codigo Animal</label>
                                                    <input type="text" class="form-control" id="COD_ANIMAL" name="COD_ANIMAL" placeholder=" Ingrese el codigo del animal  " value="{{$Cventa['COD_ANIMAL']}}">
                                                    <select class="form-select custom-select" id="COD_ANIMAL" name="COD_ANIMAL" required>
                                                        <option value="" disabled selected>Seleccione una opción</option>
                                        @                      @foreach ($AnimalArreglo as $Animal)
                                                                <option value="{{$Animal['COD_ANIMAL']}}">{{$Animal['COD_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['CLAS_ANIMAL']}} {{$Animal['RAZ_ANIMAL']}} {{$Animal['COL_ANIMAL']}} {{$Animal['COD_FIERRO']}} {{$Animal['VEN_ANIMAL']}} {{$Animal['HER_ANIMAL']}} {{$Animal['DET_ANIMAL']}}</option>
                                            

                                                                @endforeach 
                                        
                                    
                                                    </select>
                    
                                        
                                    
                                    
                                                </div>


                                                <div class="mb-3">
                                                    <label for="Cventa">Folio de Carta De Venta</label>
                                                    <input type="text" class="form-control" id="FOL_CVENTA" name="FOL_CVENTA" placeholder=" Ingrese el numero de folio  " value="{{$Cventa['FOL_CVENTA']}}">
                                                    <select class="form-select  custom-select " id="FOL_CVENTA" name="FOL_CVENTA"required>
                                                        <option value="" disabled selected>Seleccione una opción del folio</option>
                                                        <option value="0001">Folio  #0001</option>
                                                        <option value="0002">Folio  #0002</option>
                                                        <option value="0003">Folio  #0003</option>
                                                        <option value="0004">Folio  #0004</option>
                                                        <option value="0005">Folio  #0005</option>
                                                        <option value="0006">Folio  #0006</option>
                                                        <option value="0007">Folio  #0007</option>
                                                        <option value="0008">Folio  #0008</option>
                                                        <option value="0009">Folio  #0009</option>
                                                        <option value="00010">Folio #00010</option>
                                                        <option value="00011">Folio #00011</option>
                                                        <option value="00012">Folio #00012</option>
                                                        <option value="00013">Folio #00013</option>
                                                        <option value="00014">Folio #00014</option>
                                                        <option value="00015">Folio #00015</option>
                                                        <option value="00016">Folio #00016</option
                                                    </select>
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="Cventa" class="form-label">Antecedentes Carta De Venta</label>
                                                    <input type="text" readonly class="form-control" id="ANT_CVENTA" name="ANT_CVENTA" value="{{$Cventa['ANT_CVENTA']}}">
                                                    <select class="form-select" id="ANT_CVENTA" name="ANT_CVENTA">
                                                        <option value="SI" selected >SI</option>
                                                        <option value="NO" selected >NO</option>
                                                        
                                                    </select>
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
                        <!--agregado -->
            



                    @endforeach
                </tbody>
            </table>
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
                        $('#modCventa').DataTable({
                            responsive: true
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
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop