@extends('plantilla')
@section('title', 'Catálogo')
@section('content')

	
	<!-- ================== Sector: Sub-Titulo =================== -->
	<div class="text-center">
		<small class="font-italic">Nuestro catálogo cuenta con stock real y precios actualizados<br></small>
	</div>
	
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
			<select class="custom-select custom-select-sm col-12 col-md-6 col-lg-5" id="idFiltroRubro"></select>  
		</div>
	</div>

	<!-- =============== Sector: Lista de Lista ================ -->
	<div class="col-12">
		<table class="table table-sm">
			<thead>
				<tr class="bg-secondary text-white">
					<th class="align-text-top" width="10%"><small>#</small></th>
					<th class="align-text-top"><small>Denominación</small></th>
					<th class="align-text-top"><small>Precio</small></th>
					<th class="align-text-top"><small></small></th>
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
					<h5 class="modal-title">Artículo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						@csrf
						<img src="" class="img-fluid rounded mb-2" alt="" id="idImagenVista">
						<div class="form-row">
							<div class="form-group col-12">
								<label for="idDenominacion"><small>Denominación</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacion">
							</div>
							<div class="form-group col-12">
								<label for="idDescripcion"><small>Descripción</small></label>
								<textarea rows = "3" cols = "80" class="tabFocus form-control form-control-sm" id="idDescripcion"></textarea>
							</div>
							<div class="form-group col-4">
								<label for="idUnidad"><small>Unidad</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idUnidad" readonly>
							</div>	
							<div class="form-group col-4">
								<label for="idAlicuotaIVA"><small>IVA Alícuota</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idAlicuotaIVA" readonly>
							</div>
							<div class="form-group col-4">
								<label for="idPrecioAR"><small>Precio</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idPrecioAR" readonly>
							</div>				
						</div>
						<div class="text-center">
							<a class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('script')
<script src="{{ asset('js/cotizacion.js') }}" defer></script>
<script src="{{ asset('js/models/catalogo_articulo.js') }}" defer></script>
<script src="{{ asset('js/models/rubro.js') }}" defer></script>
<script>

	var objCatalogoArticulo = null;
	function formarVisualizacion(id){
		this.obtener(id);
	}

	function formarLista(listaPaginada = 'listaARTICULO'){
		var filtros = '';
		if (listaPaginada == 'listaARTICULO'){
			filtros += ( $('#idFiltroTipo').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroTipo').val() == 'id' ) ? '&id=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroRubro').val() != null ) ? '&denominacion_rubro=' + $('#idFiltroRubro').val() : '';
			filtros += '&stock=1&estado=ACTIVO';
			this.crearPaginacion('/catalogo_articulos_list', filtros, 'listaARTICULO');
			$('#idTabla').empty().append(this.obtenerListaCatalogoArticulo(this.paginaSelecionada, filtros));
		}
	}

	function mostrar(){
		$('#idDenominacion').val(this.objCatalogoArticulo.tipo + ' ' + this.objCatalogoArticulo.marca + ' ' + this.objCatalogoArticulo.modelo);
		$('#idDescripcion').val(this.objCatalogoArticulo.descripcion);
		$('#idUnidad').val(this.objCatalogoArticulo.unidad);
		$('#idAlicuotaIVA').val('%' + parseFloat(this.objCatalogoArticulo.iva_alicuota).toFixed(1));
		$('#idPrecioAR').val('$' + this.objCatalogoArticulo.usd_precio);
		$('#idImagenVista').attr('src', ((this.objCatalogoArticulo.imagen_nombre.trim() == '') ? '' : '\\img\\articulos\\' + this.objCatalogoArticulo.imagen_nombre) );
	}

	function obtener(id){
		if (this.obtenerCatalogoArticulo(id) != null) mostrar();
	}

	async function obtenerDesplegable_Rubros(){
		var items = await this.obtenerDesplegableRubros();
		$('#idFiltroRubro').empty().append(items.paraFiltro);
	}

	$('document').ready( function() { obtenerDesplegable_Rubros(); irPaginaInicial('listaARTICULO'); });
	$('#idFiltroTipo, #idFiltroRubro').change( function() { irPaginaInicial('listaARTICULO'); });
	$('#idFiltroTexto').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaARTICULO'); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

</script>
@endsection