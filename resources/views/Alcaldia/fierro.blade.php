@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<center>
    <h3>DEPARTAMENTO DE JUSTICIA MUNICIPAL</h3>
    <h1>REGISTRO DE FIERROS</h1>
</center>

@stop

@section('content')
    <p>Equipo SOFTEAM</p>
    
    <div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Fierros <a href="categoria/create"><button class="btn btn-success">Nuevo</button></a></h3>
		
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Codigo Fierro</th>
					<th>Fecha Tramite</th>
					<th>Dueño Fierro</th>
                    <th>Tipo Fierro</th>
                    <th>Img Fierro</th>
                    <th>Numero Folio</th>
                    <th>Monto Certifico</th>
					<th>Opciones</th>

				</thead>
    
                                 
                
</tr>		
			
			
			</table>
		</div>
		
	</div>
</div>

    
            <div class="form-group">
            	<label for="FEC_TRAMITE_FIERRO">Fecha de Tramite</label>
            	<input type="date" id="FEC_TRAMITE_FIERRO" class="form-control" placeholder="inserte la fecha de tramite.">
            </div>
            <div class="form-group">
            	<label for="COD_PERSONA">CODIGO DE PERSONA</label>
            	<input type="text" id="CODIGO DE PERSONA" class="form-control" placeholder="Ingrese el codigo del dueño del fierro">
            </div>
            <div class="mb-3">
            	<label for="TIP_FIERRO" class="form-control" >TIPO DE FIERRO</label>
            	<Select class= "form-select" id= "TIP_FIERRO" name="TIP_FIERRO" >
                <option value= "L" selected>Letra</option>
                <option value= "F" selected>Figura</option>
                <option value= "N" selected>Numero</option>
                <option value= "S" selected>Simbolo</option>
            </select>              
            </div>

            <div class="mb-2">
            	<label for=" IMG_FIERRO" class="form-control"> Seleccione la imagen del fierro</label>
            	<Select class= "form-select" id= "IMG_FIERRO" name="IMG_FIERRO" >
                <option value= "S" selected>SELECCIONAR IMAGEN</option> 
                </select> 
            </div>

            <div class="form-group">
            	<label for="NUM_FOLIO_FIERRO">NUM_FOLIO_FIERRO</label>
            	<input type="text" id="NUM_FOLIO_FIERRO" class="form-control" placeholder="Ingrese el numerode folio del firro">
            </div>
            <div class="form-group">
            	<label for="MON_CERTIFICO_FIERRO">Monto del Certifico</label>
            	<input type="text" id="MON_CERTIFICO_FIERRO" class="form-control" placeholder="Ingrese el numerode folio del firro">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

				
            
		</div>
	</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop