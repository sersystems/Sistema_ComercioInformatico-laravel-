@extends('plantilla')
@section('title', 'Usuarios')
@section('content')
	
	<!-- =================== Sector: Buscador ==================== -->
	<div class="col-12">
		<div class="input-group justify-content-center mb-1">
			<select class="custom-select custom-select-sm col-7 col-md-3 col-lg-3" id="idFiltroTipo">
				<option value="denominacion">BUSCAR POR NOMBRE</option>
				<option value="id">BUSCAR POR ID</option>
			</select>  
			<input type="text" class="form-control form-control-sm col-5 col-md-3 col-lg-2" id="idFiltroTexto" placeholder="Buscar...">
		</div>
	</div>

	<!-- =============== Sector: Lista de Objetos ================ -->
	<div class="col-12">
		<table class="table table-sm">
			<thead>
				<tr class="bg-secondary text-white">
					<th class="align-text-top" width="10%"><small>#</small></th>
					<th class="align-text-top"><small>Tipo</small></th>
					<th class="align-text-top"><small>Denominación</small></th>
					<th class="d-flex justify-content-end"><button class="btn-sm btn-dark" data-toggle="modal" data-target="#modalFormulario" onclick="formarCreacion()"><i class="fas fa-plus"></i></button></th>
				</tr>
			</thead>
			<tbody id="idTabla">
			</tbody>
		</table>
		<div id="idPaginacion"></div>
	</div>

	<!-- ================ Sector: Formulario Modal ================ -->
	<div class="modal fade" id="modalFormulario" tabindex="-1" role="dialog" aria-labelledby="titulo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content justify-content-center">
				<div class="modal-header">
					<h5 class="modal-title" id="titulo"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="form">
						@csrf
						<div class="form-row">
							<div class="form-group col-12 col-md-4">
								<label for="idSesion"><small>Sesión</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idSesion">
									<option value="ADMIN">ADMINISTRATIVO</option>
									<option value="GREMIO">CLIENTE GREMIO</option>								
								</select> 	
							</div>
							<div class="form-group col-12 col-md-8">
								<label for="idDenominacion"><small>Denominación</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacion">
							</div>
							<div class="form-group col-12 col-md-8">
								<label for="idEmail"><small>E-mail</small></label>
								<input type="email" class="tabFocus form-control form-control-sm" id="idEmail">
							</div>
							<div class="form-group col-12 col-md-4">
								<label for="idPassword"><small>Password</small></label>
								<input type="password" class="tabFocus form-control form-control-sm" id="idPassword">
							</div>
						</div>
						<div class="text-center">
							<a class="btn btn-primary" data-dismiss="modal" onclick="guardar()">Guardar</a>
							<a class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('script')
<script src="{{ asset('js/models/usuario.js') }}" defer></script>
<script>

	var objUsuario = null;
	function formarCreacion(){
		$('#titulo').text('Crear Usuario');
		this.objUsuario = new Usuario();
		mostrar();
	}

	function formarEdicion(id){
		$('#titulo').text('Editar Usuario');
		this.obtener(id);
	}

	function formarEliminacion(id){
		$('#modalMesajeConfirmacion').modal('toggle');
		$('#idTituloMesajeConfirmacion').text('¿Esta seguro que desea eliminar este registro?');
		$('#idAceptarMesajeConfirmacion').attr('onclick', 'eliminar(' + id + ')');
	}

	function formarLista(listaPaginada = 'listaUSUARIO'){
		var filtros = '';
		if (listaPaginada == 'listaUSUARIO'){
			filtros += ( $('#idFiltroTipo').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroTipo').val() == 'id' ) ? '&id=' + $('#idFiltroTexto').val() : '';
			this.crearPaginacion('/usuarios_list', filtros, 'listaUSUARIO');
			$('#idTabla').empty().append(this.obtenerListaUsuario(this.paginaSelecionada, filtros, 'btnELIMINAR'));
		}
	}

	function eliminar(id){
		if (this.eliminarUsuario(id)) this.formarLista();
	}

	function guardar(){
		this.objUsuario.sesion = $('#idSesion').val();
		this.objUsuario.denominacion = $('#idDenominacion').val();
		this.objUsuario.email = $('#idEmail').val();
		this.objUsuario.password = $('#idPassword').val();
		if (this.guardarUsuario(this.objUsuario) == true) irPaginaInicial('listaUSUARIO');
	}

	function mostrar(){
		$('#idSesion').val(this.objUsuario.sesion);
		$('#idDenominacion').val(this.objUsuario.denominacion);
		$('#idEmail').val(this.objUsuario.email);
		$('#idPassword').val(this.objUsuario.password);
	}

	function obtener(id){
		if (this.obtenerUsuario(id) != null) mostrar();
	}

	$('document').ready( function() { irPaginaInicial('listaUSUARIO'); });
	$('#idFiltroTipo, #idFiltroEstadoActivo').change( function() { irPaginaInicial('listaUSUARIO'); });
	$('#idFiltroTexto').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaUSUARIO'); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

</script>
@endsection