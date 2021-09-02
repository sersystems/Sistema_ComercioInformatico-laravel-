@extends('plantilla')
@section('title', 'Mensajes')
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
		<div class="input-group justify-content-center mb-1">
			<div class="form-control form-control-sm col-12 col-md-6 col-lg-5">
				<input type="checkbox" class="form-check form-check-inline" checked id="idFiltroEstadoSinResponder">
				<small class="align-text-bottom">Sin Responder</small>
			</div>
		</div>
	</div>

	<!-- =============== Sector: Lista de Objetos ================ -->
	<div class="col-12">
		<table class="table table-sm">
			<thead>
				<tr class="bg-secondary text-white">
					<th class="align-text-top" width="10%"><small>#</small></th>
					<th class="align-text-top"><small>Denominación</small></th>
					<th class="align-text-top"><small>Celular</small></th>
					<th class="align-text-top"><small>Estado</small></th>
					<th></th>
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
					<form>
						@csrf
						<div class="form-row">
							<div class="form-group col-12">
								<label for="idDenominacion"><small>Denominación</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacion" readonly>
							</div>
							<div class="form-group col-12 col-md-3">
								<label for="idCelular"><small>Celular</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCelular">
							</div>	
							<div class="form-group col-12 col-md-9">
								<label for="idEmail"><small>E-mail</small></label>
								<input type="email" class="tabFocus form-control form-control-sm" id="idEmail">
							</div>
							<div class="form-group col-12">
								<label for="idConsulta"><small>Consulta</small></label>
								<textarea rows = "3" cols = "80" class="tabFocus form-control form-control-sm" id="idConsulta" readonly></textarea>
							</div>
							<div class="form-group col-12">
								<label for="idRespuesta"><small>Respuesta</small></label>
								<textarea rows = "3" cols = "80" class="tabFocus form-control form-control-sm" id="idRespuesta"></textarea>
							</div>
						</div>
						<div class="text-center">
							<a class="btn btn-primary" data-dismiss="modal" onclick="guardar()">Responder</a>
							<a class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('script')
<script src="{{ asset('js/models/mensaje.js') }}" defer></script>
<script>

	var objMensaje = null;
	function formarVisualizacion(id){
		$('#titulo').text('Mensaje');
		this.obtener(id);
	}

	function formarEliminacion(id){
		$('#modalMesajeConfirmacion').modal('toggle');
		$('#idTituloMesajeConfirmacion').text('¿Esta seguro que desea eliminar este registro?');
		$('#idAceptarMesajeConfirmacion').attr('onclick', 'eliminar(' + id + ')');
	}

	function formarLista(listaPaginada = 'listaMENSAJE'){
		var filtros = '';
		if (listaPaginada == 'listaMENSAJE'){
			filtros += ( $('#idFiltroTipo').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroTipo').val() == 'id' ) ? '&id=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroEstadoSinResponder').prop('checked') ) ? '&estado=S/RESPONDER' : '';
			this.crearPaginacion('/rubros_list', filtros, 'listaMENSAJE');
			$('#idTabla').empty().append(this.obtenerListaMensaje(this.paginaSelecionada, filtros, 'btnELIMINAR'));
		}
	}

	function eliminar(id){
		if (this.eliminarMensaje(id)) this.formarLista();
	}

	function guardar(){
		this.objMensaje.celular = $('#idCelular').val();
		this.objMensaje.email = $('#idEmail').val();
		this.objMensaje.respuesta = $('#idRespuesta').val();
		if (this.guardarMensaje(this.objMensaje) == true) irPaginaInicial('listaMENSAJE');
	}

	function mostrar(){
		$('#idDenominacion').val(this.objMensaje.denominacion);
		$('#idCelular').val(this.objMensaje.celular);
		$('#idEmail').val(this.objMensaje.email);
		$('#idConsulta').val(this.objMensaje.consulta);
		$('#idRespuesta').val(this.objMensaje.respuesta);
	}

	function obtener(id){
		if (this.obtenerMensaje(id) != null) mostrar();
	}

	$('document').ready( function() { irPaginaInicial('listaMENSAJE'); });
	$('#idFiltroTipo, #idFiltroEstadoSinResponder').change( function() { irPaginaInicial('listaMENSAJE'); });
	$('#idFiltroTexto').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaMENSAJE'); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

</script>
@endsection