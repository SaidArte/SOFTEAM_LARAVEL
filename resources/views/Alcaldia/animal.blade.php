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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop
@section('content_header')
    <center>
        <h1>Información de Animales</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Registro de Animales.</p>
        <footer class="blockquote-footer">Animales <cite title="Source Title">Registrados</cite></footer>
    </blockquote>
@stop

@section('content')
<p align="right">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Animal">+ Nuevo</button>
</p>
    
    <div class="modal fade bd-example-modal-sm" id="Animal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar un nuevo Animal</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Favor, ingrese los datos solicitados:</p>
                    <form action="{{ url('Animal/insertar') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-3">
                            <label for="CLAS_ANIMAL" >clases de Animal</label>
                            <select class="form-select custom-select" id="CLAS_ANIMAL" name="CLAS_ANIMAL" placeholder="Seleccione una clase de animal" required >
                                <option value="" disabled selected>Seleccione una clase de animal</option>
                                <option value="Vaca" selected >Vaca</option>
                                <option value="Caballo" selected >Caballo</option>
                                <option value="Cerdo" selected >Cerdo</option>
                                <option value="Burro" selected >Burro</option>
                                <option value="Mula" selected >Mula</option>
                                <option value="Yegua" selected >Yegua</option>
                               
                               
                            </select>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="RAZ_ANIMAL" >Raza de Animal</label>
                            <select class="form-select custom-select" id="RAZ_ANIMAL" name="RAZ_ANIMAL"placeholder="Seleccione una Raza de Animal" required >
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


                               
                            </select>
                        </div>
                       

                    <div class="mb-3 mt-3">
                        <label for="COL_ANIMAL" >Color del Animal</label>
                        <select class="form-select custom-select" id="COL_ANIMAL" name="COL_ANIMAL" placeholder="Seleccione el color del Ganado"required >
                            <option value="" disabled selected>Seleccione el color del Ganado</option>

                            <option value=" castaño" selected >castaño</option>
                            <option value="marron" selected >marron</option>
                            <option value="blanco" selected >blanco</option>
                            <option value=" negro" selected >negro</option>
                            <option value="cafes" selected >cafes</option>
                            <option value="manchado " selected >manchado </option>
                            <option value="Gris " selected >Gris </option>
                           
                        </select>
                    </div>

                    <!--metodo de inserta en codigo de fierro  atraendo los datos ya existente de la tabla persona-->
                    <div class="mb-3 mt-3">
                        <label for="COD_FIERRO" >Datos de Fierro</label>
                        <select class="form-select custom-select" id="COD_FIERRO" name="COD_FIERRO" placeholder="Seleccione Datos de Fierro"required >
                            <option value="" disabled selected>Seleccione Datos de Fierro </option>
                            @foreach ($fierroArreglo as $fierro)
                                  <option value="{{$fierro['COD_FIERRO']}}">{{$fierro['COD_FIERRO']}} {{$fierro['COD_PERSONA']}} {{$fierro['TIP_FIERRO']}} {{$fierro['NUM_FOLIO_FIERRO']}} </option>
                                

                            @endforeach 
                            
                           
                        </select>
                    </div>
                  

                
                        <div class="mb-3 mt-3">
                            <label for="VEN_ANIMAL" >Venteado Animal</label>
                            <select class="form-select custom-select" id="VEN_ANIMAL" name="VEN_ANIMAL" placeholder="Seleccione una opción Venteado"required >
                                <option value="" disabled selected>Seleccione una opción Venteado</option>
                                <option value="S" selected >SI</option>
                                <option value="N" selected >NO</option>
                                
                               
                            </select>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="HER_ANIMAL">Herrado Animal</label>
                            <select class="form-select custom-select" id="HER_ANIMAL" name="HER_ANIMAL" placeholder="Seleccione una opción de Herrado"required >
                                <option value="" disabled selected>Seleccione una opción de Herrado</option>

                                <option value="S" selected >SI</option>
                                <option value="N" selected >NO</option>
                               
                               
                            </select>
                        </div>
    
                
                        
                        
                        <div class="mb-3 mt-3">
                            <label for="DET_ANIMAL">Detalle del Animal</label>
                            <input type="text" id="DET_ANIMAL" class="form-control" name="DET_ANIMAL" placeholder="Ingrese detalle del animal"required >
                        </div>
                       
                       


                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                    </form>
                    <script>
                        $(document).ready(function() {
                             // Validación del formulario
                            $("#Cventa form").validate({
                                   rules: {
                                       CLAS_ANIMAL: "required",
                                       RAZ_ANIMAL: "required",
                                       COL_ANIMAL: "required",
                                       COD_FIERRO: "required",
                                       VEN_ANIMAL: "required",
                                       HER_ANIMAL: "required",
                                       DET_ANIMAL: "required"


                                       
                                    },
                                    messages: {
                                       CLAS_ANIMAL: "Seleccione una clase de animal",
                                       RAZ_ANIMAL: "Seleccione una Raza de Animal",
                                       COL_ANIMAL: "Seleccione el color del Ganado",
                                       COD_FIERRO: "Seleccione Datos de Fierro ",
                                       VEN_ANIMAL: "Seleccione una opción Venteado",
                                       HER_ANIMAL: "Seleccione una opción de Herrado",
                                       DET_ANIMAL: "Ingrese detalle del animal"

                                       
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
                            document.getElementById(" CLAS_ANIMAL").value = "";
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

                        document.getElementById("btnCancelar").addEventListener("click", function() {
                            limpiarFormulario();
                        });
                        // Mostrar el modal de registro exitoso cuando se envíe el formulario
                        $('#Animal form').submit(function() {
                            $('#registroExitosoModal').modal('show');
                        });    
                    </script>


                </div>
            </div>
        </div>
    </div>

    <table cellspacing="9" cellpadding="9" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;" " id="modAnimal" >
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
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Animal-edit-{{$Animal['COD_ANIMAL']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
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
                                            <select class="form-select custom-select" id="CLAS_ANIMAL" name="CLAS_ANIMAL" placeholder="Seleccione una clase de animal" required >
                                                <option value="" disabled selected>Seleccione una clase de animal</option>
                                                <option value="Vaca" selected >Vaca</option>
                                                <option value="Caballo" selected >Caballo</option>
                                                <option value="Cerdo" selected >Cerdo</option>
                                                <option value="Burro" selected >Burro</option>
                                                <option value="Mula" selected >Mula</option>
                                                <option value="Yegua" selected >Yegua</option>
                                               
                                               
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Animal">Raza Del Animal</label>
                                            <input type="text" class="form-control" id="RAZ_ANIMAL" name="RAZ_ANIMAL" placeholder=" Ingrese La Raza Del Animal  " value="{{$Animal['RAZ_ANIMAL']}}">
                                            <select class="form-select custom-select" id="RAZ_ANIMAL" name="RAZ_ANIMAL"placeholder="Seleccione una Raza de Animal" required >
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
                
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label for="Animal">Color Del Animal</label>
                                            <input type="text" class="form-control" id="COL_ANIMAL" name="COL_ANIMAL" placeholder=" Ingrese El Color Del animal  " value="{{$Animal['COL_ANIMAL']}}">
                                            <select class="form-select custom-select" id="COL_ANIMAL" name="COL_ANIMAL" placeholder="Seleccione el color del Ganado"required >
                                                <option value="" disabled selected>Seleccione el color del Ganado</option>
                    
                                                <option value=" castaño" selected >castaño</option>
                                                <option value="marron" selected >marron</option>
                                                <option value="blanco" selected >blanco</option>
                                                <option value=" negro" selected >negro</option>
                                                <option value="cafes" selected >cafes</option>
                                                <option value="manchado " selected >manchado </option>
                                                <option value="Gris " selected >Gris </option>
                                               
                                            </select>

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
