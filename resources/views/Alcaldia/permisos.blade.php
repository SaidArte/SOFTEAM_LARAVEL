@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
        <center>
            <h1>Información de Permisos</h1>
        </center>
        <blockquote class="blockquote text-center">
            <p class="mb-0">Registro de Permisos.</p>
            <footer class="blockquote-footer">Permisos <cite title="Source Title">Registrados</cite></footer>
        </blockquote>
    @endif
@stop

@section('content')
    @if(session()->has('user_data'))
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Permisos">+ Nuevo</button>
        <div class="modal fade bd-example-modal-sm" id="Permisos" tabindex="-1">
        <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar un nuevo permiso</h5>
                            <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese los datos solicitados:</p>
                            <form action="{{ url('Permisos/insertar') }}" method="post">
                                @csrf              
                                    <div class="mb-3">
                                        <label for="NOM_ROL">Rol</label>
                                        <select class="form-select custom-select" id="NOM_ROL" name="NOM_ROL"required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @foreach ($rolesArreglo as $roles)
                                                <option value="{{$roles['NOM_ROL']}}">{{$roles['NOM_ROL']}}</option>
                                            @endforeach 
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="OBJETO">OBJETO</label>
                                        <select class="form-select custom-select" id="OBJETO" name="OBJETO" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @foreach ($objetosArreglo as $objetos)
                                                <option value="{{$objetos['OBJETO']}}">{{$objetos['OBJETO']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <!-- Insertar -->
                                        <div class="mb-3">
                                            <p>Seleccione las funciones que desea que realice este permiso</p>
                                            <label for="PRM_INSERTAR">Permiso de Insertar</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="PRM_INSERTAR" name="PRM_INSERTAR" value="S" onclick="updateValue()">
                                                <input type="hidden" id="PRM_INSERTAR_HIDDEN" name="PRM_INSERTAR" value="N">
                                                    <script>
                                                        function updateValue() {
                                                            var checkbox = document.getElementById("PRM_INSERTAR");
                                                            var hiddenInput = document.getElementById("PRM_INSERTAR_HIDDEN");

                                                            if (checkbox.checked) {
                                                                hiddenInput.value = "S";
                                                            } else {
                                                                hiddenInput.value = "N";
                                                            }
                                                        }
                                                    </script>
                                            </div>
                                        </div>
                                        <!-- Actualizar -->
                                        <div class="mb-3">
                                            <label for="PRM_ACTUALIZAR">Permiso de Actualizar</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR" value="S" onclick="updateValue()">
                                                <input type="hidden" id="PRM_ACTUALIZAR_HIDDEN" name="PRM_ACTUALIZAR" value="N">
                                                    <script>
                                                        function updateValue() {
                                                            var checkbox = document.getElementById("PRM_ACTUALIZAR");
                                                            var hiddenInput = document.getElementById("PRM_ACTUALIZAR_HIDDEN");

                                                            if (checkbox.checked) {
                                                                hiddenInput.value = "S";
                                                            } else {
                                                                hiddenInput.value = "N";
                                                            }
                                                        }
                                                    </script>
                                            </div>
                                        </div>

                                        <!-- Consultar -->
                                        <div class="mb-3">
                                            <label for="PRM_CONSULTAR">Permiso de Consultar</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="PRM_CONSULTAR" name="PRM_CONSULTAR" value="S" onclick="updateValue()">
                                                <input type="hidden" id="PRM_CONSULTAR_HIDDEN" name="PRM_CONSULTAR" value="N">
                                                    <script>
                                                        function updateValue() {
                                                            var checkbox = document.getElementById("PRM_CONSULTAR");
                                                            var hiddenInput = document.getElementById("PRM_CONSULTAR_HIDDEN");

                                                            if (checkbox.checked) {
                                                                hiddenInput.value = "S";
                                                            } else {
                                                                hiddenInput.value = "N";
                                                            }
                                                        }
                                                    </script>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                // Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                                function limpiarFormulario() {
                                    document.getElementById("NOM_ROL").value = "";
                                    document.getElementById("OBJETO").value = "";
                                    
                                    const checkboxes = document.querySelectorAll(".form-check-input");
                                    checkboxes.forEach(checkbox => { //limpiando los check
                                        checkbox.checked = false;
                                    });

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
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-hover table-responsive table-verde-claro table-striped mt-1" style="border: 2px solid lime;">
            <thead>
                <tr>
                    <th>Código Rol</th>
                    <th>Rol</th>
                    <th>Código del Objeto</th>
                    <th>Objeto</th>
                    <th>Permisos Insertar</th>
                    <th>Permisos Actualizar</th>
                    <th>Permisos Consultar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through $citaArreglo and show data -->
                @foreach($citaArreglo as $Permisos)
                    <tr>
                        <td>{{$Permisos['COD_ROL']}}</td>
                        <td>{{$Permisos['NOM_ROL']}}</td>
                        <td>{{$Permisos['COD_OBJETO']}}</td>
                        <td>{{$Permisos['OBJETO']}}</td>
                        <td>
                            @if ($Permisos['PRM_INSERTAR'] === 'S')
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($Permisos['PRM_ACTUALIZAR'] === 'S')
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($Permisos['PRM_CONSULTAR'] === 'S')
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <!-- Esta vez se llamaran dos parametros para poder ser actualizados -->
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Permisos-edit-{{$Permisos['COD_ROL']}}-{{$Permisos['COD_OBJETO']}}">
                                <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                            </button>
                            <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Permisos['COD_OBJETO']}})">
                                <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                            </button>
                        </td>
                    </tr>
                   <!-- Modal que esta vez toma dos parametros primarios -->
                   <div class="modal fade bd-example-modal-sm" id="Permisos-edit-{{$Permisos['COD_ROL']}}-{{$Permisos['COD_OBJETO']}}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualizar datos del permiso</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p>Si desea agregar un permiso, marque la casilla; en caso contrario, déjela desmarcada.</p>
                    <form action="{{ url('Permisos/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_ROL" value="{{$Permisos['COD_ROL']}}"> 
                        <input type="hidden" class="form-control" name="COD_OBJETO" value="{{$Permisos['COD_OBJETO']}}">
                        
                        <!-- Insertar -->
                        <div class="mb-3">
                            <label for="LPRM_INSERTAR">Permiso de Insertar</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="PRM_INSERTAR" name="PRM_INSERTAR" {{$Permisos['PRM_INSERTAR'] === 'S' ? 'checked' : ''}} onchange="updateValue(this)">
                                <input type="hidden" id="PRM_INSERTAR_HIDDEN" name="PRM_INSERTAR" value="{{$Permisos['PRM_INSERTAR']}}">
                            </div>
                        </div>

                        <!-- Actualizar -->
                        <div class="mb-3">
                            <label for="LPRM_ACTUALIZAR">Permiso de Actualizar</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="PRM_ACTUALIZAR" name="PRM_ACTUALIZAR" {{$Permisos['PRM_ACTUALIZAR'] === 'S' ? 'checked' : ''}} onchange="updateValue(this)">
                                <input type="hidden" id="PRM_ACTUALIZAR_HIDDEN" name="PRM_ACTUALIZAR" value="{{$Permisos['PRM_ACTUALIZAR']}}">
                            </div>
                        </div>

                        <!-- Consultar -->
                        <div class="mb-3">
                            <label for="LPRM_CONSULTAR">Permiso de Consultar</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="PRM_CONSULTAR" name="PRM_CONSULTAR" {{$Permisos['PRM_CONSULTAR'] === 'S' ? 'checked' : ''}} onchange="updateValue(this)">
                                <input type="hidden" id="PRM_CONSULTAR_HIDDEN" name="PRM_CONSULTAR" value="{{$Permisos['PRM_CONSULTAR']}}">
                            </div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>

                    <script>
                        function updateValue(checkbox) {
                            var hiddenInput = checkbox.nextElementSibling;

                            if (checkbox.checked) {
                                hiddenInput.value = "S";
                            } else {
                                hiddenInput.value = "N";
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
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop