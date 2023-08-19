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
            
            <center>
                <h1>Información de Animales</h1>
            </center>

        <br>
            <center>
                <footer class="blockquote-footer">Animales <cite title="Source Title">Registrados</cite></footer>

            </center>
        </br>
            

        @section('content')
        <p align="right">
            <button type="button" class="Btn" data-toggle="modal" data-target="#Animal">
                <div class="sign">+</div>
                <div class="text">Nuevo</div>
            </button>
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
                            <form action="{{ url('Animal/insertar') }}" method="post"  class="needs-validation Animal-form">
                                @csrf
                                <div class="mb-3 mt-3">
                                    <label for="CLAS_ANIMAL" >clases de Animal</label>
                                    <select class="form-select custom-select" id="CLAS_ANIMAL" name="CLAS_ANIMAL" required >
                                        <option value="" disabled selected>Seleccione una clase de animal</option>
                                        <option value="Vaca" selected >Vaca</option>
                                        <option value="Caballo" selected >Caballo</option>
                                        <option value="Cerdo" selected >Cerdo</option>
                                        <option value="Burro" selected >Burro</option>
                                        <option value="Mula" selected >Mula</option>
                                        <option value="Yegua" selected >Yegua</option>
                                        <option value="Vaca" selected >Vaca</option>

                                    
                                    
                                    </select>

                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="RAZ_ANIMAL" >Raza de Animal</label>
                                    <select class="form-select custom-select" id="RAZ_ANIMAL" name="RAZ_ANIMAL" required >
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
                                         <!--Raza de mula-->
                                         <option value="criollo" selected >Mula criollo</option>
                                         <option value="" disabled selected>Seleccione una Raza de Animal</option>


                                    
                                    </select>

                                </div>
                            

                            <div class="mb-3 mt-3">
                                <label for="COL_ANIMAL" >Color del Animal</label>
                                <select class="form-select custom-select" id="COL_ANIMAL" name="COL_ANIMAL" required >
                                    <option value="" disabled selected>Seleccione el color del Ganado</option>

                                    <option value=" castaño" selected >castaño</option>
                                    <option value="marron" selected >marron</option>
                                    <option value="blanco" selected >blanco</option>
                                    <option value=" negro" selected >negro</option>
                                    <option value="cafes" selected >cafes</option>
                                    <option value="manchado " selected >manchado </option>
                                    <option value="Gris " selected >Gris </option>
                                    <option value="" disabled selected>Seleccione el color del Ganado</option>
                                
                                </select>

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
                                    $("#Animal form").validate({
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
                                
                                <button value="Editar" title="Editar" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#Animal-edit-{{$Animal['COD_ANIMAL']}}">
                                    <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
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
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop
