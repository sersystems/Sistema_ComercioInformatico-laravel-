@extends('plantilla')
@section('title', 'Proveedores')
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
				<input type="checkbox" class="form-check form-check-inline" checked id="idFiltroEstadoActivo">
				<small class="align-text-bottom">Activos</small>
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
					<th class="align-text-top"><small>CUIL/CUIT</small></th>
					<th class="align-text-top"><small>Saldo</small></th>
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
							<div class="form-group col-12">
								<label for="idDenominacion"><small>Denominación</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacion">
							</div>
							<div class="form-group col-6">
								<label for="idCUIT"><small>CUIT</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCUIT">
							</div>
							<div class="form-group col-6">
								<label for="idIVA"><small>IVA</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idIVA">
									<option value="RESPONSABLE INSCRIPTO">RESP. INSCRIPTO</option>
									<option value="RESPONSABLE MONOTRIBUTO">RESP. MONOTRIBUTO</option>									
									<option value="SUJETO EXENTO">SUJETO EXENTO</option>									
								</select>  
							</div>
							<div class="form-group col-12">
								<label for="idDomicilio"><small>Domicilio</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDomicilio">
							</div>
							<div class="form-group col-5">
								<label for="idProvincia"><small>Provincia</small></label>
								<input type="text" list="idProvinciaLista" class="tabFocus form-control form-control-sm" id="idProvincia">
								<datalist id="idProvinciaLista">
									<option value="BUENOS AIRES">
									<option value="CATAMARA">
									<option value="CHACO">
									<option value="CHUBUT">
									<option value="CORDOBA">
									<option value="CORRIENTES">
									<option value="ENTRE RIOS">
									<option value="FORMOSA">
									<option value="JUJUY">
									<option value="LA PAMPA">
									<option value="LA RIOJA">
									<option value="MENDOZA">
									<option value="MISIONES">
									<option value="NEUQUEN">
									<option value="RIO NEGRO">
									<option value="SALTA">
									<option value="SAN JUAN">
									<option value="SAN LUIS">
									<option value="SANTA CRUZ">
									<option value="SANTA FE">
									<option value="SANTIAGO DEL ESTERO">
									<option value="TIERRA DEL FUEGO">
									<option value="TUCUMAN">
								</datalist>
							</div>
							<div class="form-group col-5">
								<label for="idDistrito"><small>Distrito</small></label>
								<input type="text" list="idDistritoLista" class="tabFocus form-control form-control-sm" id="idDistrito">
								<datalist id="idDistritoLista">
									<option value="25 DE MAYO">
									<option value="9 DE JULIO">
									<option value="ALBARDON">
									<option value="ANGACO NORTE">
									<option value="ANGACO SUD">
									<option value="CALINGASTA">
									<option value="CAPITAL">
									<option value="CAUCETE">
									<option value="CHIMBAS">
									<option value="IGLESIA">
									<option value="JACHAL">
									<option value="POCITO">
									<option value="RAWSON">
									<option value="RIVADAVIA">
									<option value="SAN MARTIN">
									<option value="SANTA LUCIA">
									<option value="SARMIENTO">
									<option value="ULLUM">
									<option value="VALLE FERTIL">
									<option value="ZONDA">
								</datalist>
							</div>
							<div class="form-group col-2">
								<label for="idCP"><small>C.P.</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCP">
							</div>	
							<div class="form-group col-4">
								<label for="idTelefono"><small>Teléfono</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idTelefono">
							</div>	
							<div class="form-group col-4">
								<label for="idCelular1"><small>Celular 1</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCelular1">
							</div>	
							<div class="form-group col-4">
								<label for="idCelular2"><small>Celular 2</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCelular2">
							</div>	
							<div class="form-group col-12">
								<label for="idEmail"><small>E-mail</small></label>
								<input type="email" class="tabFocus form-control form-control-sm" id="idEmail">
							</div>
							<div class="form-group col-6">
								<label for="idSaldo"><small>Saldo</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idSaldo" readonly>
							</div>
							<div class="form-group col-6">
								<label for="idEstado"><small>Estado</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idEstado">
									<option value="ACTIVO">ACTIVO</option>
									<option value="BAJA">BAJA</option>								
								</select> 	
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
<script src="{{ asset('js/models/proveedor.js') }}" defer></script>
<script>

	var objProveedor = null;
	function formarCreacion(){
		$('#titulo').text('Crear Proveedor');
		this.objProveedor = new Proveedor();
		mostrar();
	}

	function formarEdicion(id){
		$('#titulo').text('Editar Proveedor');
		this.obtener(id);
	}

	function formarEliminacion(id){
		$('#modalMesajeConfirmacion').modal('toggle');
		$('#idTituloMesajeConfirmacion').text('¿Esta seguro que desea eliminar este registro?');
		$('#idAceptarMesajeConfirmacion').attr('onclick', 'eliminar(' + id + ')');
	}

	function formarLista(listaPaginada = 'listaPROVEEDOR'){
		var filtros = '';
		if (listaPaginada == 'listaPROVEEDOR'){
			filtros += ( $('#idFiltroTipo').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroTipo').val() == 'id' ) ? '&id=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroEstadoActivo').prop('checked') ) ? '&estado=ACTIVO' : '';
			this.crearPaginacion('/proveedores_list', filtros, 'listaPROVEEDOR');
			$('#idTabla').empty().append(this.obtenerListaProveedor(this.paginaSelecionada, filtros, 'btnELIMINAR'));
		}
	}

	function eliminar(id){
		if (this.eliminarProveedor(id)) this.formarLista();
	}

	function guardar(){
		this.objProveedor.denominacion = $('#idDenominacion').val();
		this.objProveedor.cuit = $('#idCUIT').val();
		this.objProveedor.iva = $('#idIVA').val();
		this.objProveedor.domicilio = $('#idDomicilio').val();
		this.objProveedor.provincia = $('#idProvincia').val();
		this.objProveedor.distrito = $('#idDistrito').val();
		this.objProveedor.cp = $('#idCP').val();
		this.objProveedor.telefono = $('#idTelefono').val();
		this.objProveedor.celular1 = $('#idCelular1').val();
		this.objProveedor.celular2 = $('#idCelular2').val();
		this.objProveedor.email = $('#idEmail').val();
		this.objProveedor.saldo = $('#idSaldo').val();
		this.objProveedor.estado = $('#idEstado').val();
		if (this.guardarProveedor(this.objProveedor) == true) irPaginaInicial('listaPROVEEDOR');
	}

	function mostrar(){
		$('#idDenominacion').val(this.objProveedor.denominacion);
		$('#idCUIT').val(this.objProveedor.cuit);
		$('#idIVA').val(this.objProveedor.iva);
		$('#idDomicilio').val(this.objProveedor.domicilio);
		$('#idProvincia').val(this.objProveedor.provincia);
		$('#idDistrito').val(this.objProveedor.distrito);
		$('#idCP').val(this.objProveedor.cp);
		$('#idTelefono').val(this.objProveedor.telefono);
		$('#idCelular1').val(this.objProveedor.celular1);
		$('#idCelular2').val(this.objProveedor.celular2);
		$('#idEmail').val(this.objProveedor.email);
		$('#idSaldo').val(parseFloat(this.objProveedor.saldo).toFixed(2));
		$('#idEstado').val(this.objProveedor.estado);
	}

	function obtener(id){
		if (this.obtenerProveedor(id) != null) mostrar();
	}

	$('document').ready( function() { irPaginaInicial('listaPROVEEDOR'); });
	$('#idFiltroTipo, #idFiltroEstadoActivo').change( function() { irPaginaInicial('listaPROVEEDOR'); });
	$('#idFiltroTexto').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaPROVEEDOR'); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

</script>
@endsection