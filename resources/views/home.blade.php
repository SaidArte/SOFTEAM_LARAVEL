@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <center>
    <h1>Alcaldia Municipal de Talanga</h1>
    <div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Departamento de Justicia Municipal</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
                    @foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
</center>
@stop

@section('content')
    <p>Equipo SOFTEAM</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop