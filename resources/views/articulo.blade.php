@extends('plantilla')
@section('title', 'Artículos')
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
			<select class="custom-select custom-select-sm col-8 col-md-4 col-lg-3" id="idFiltroRubro"></select>  
			<div class="form-control form-control-sm col-4 col-md-2 col-lg-2 ml-1">
				<input type="checkbox" class="form-check form-check-inline" checked id="idFiltroEstadoActivo">
				<small class="align-text-bottom">Activos</small>
			</div>
		</div>
	</div>

	<!-- =============== Sector: Lista de Lista ================ -->
	<div class="col-12">
		<table class="table table-sm">
			<thead>
				<tr class="bg-secondary text-white">
					<th class="align-text-top" width="10%"><small>#</small></th>
					<th class="align-text-top"><small>Denominación</small></th>
					<th class="align-text-top"><small>Stock</small></th>
					<th class="align-text-top"><small>P.Público</small></th>
					<th class="align-text-top"><small>P.Gremio</small></th>
					<th class="d-flex justify-content-end"><button class="btn-sm btn-dark" data-toggle="modal" data-target="#modalFormulario" onclick="formarCreacion()"><i class="fas fa-plus"></i></button></th>
				</tr>
			</thead>
			<tbody id="idTabla">
			</tbody>
		</table>
		<div id="idPaginacion"></div>
	</div>

	<!-- ================ Sector: Cotizació Dólar ================= -->
	<div class="col-12 text-right"><small>Cotización Dólar: <b>U$D</b></small><small><b id="idCotizacionDolar">0.00</b></small></div>

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
								<label for="idDenominacionTipo"><small>Denominación - Tipo</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacionTipo">
							</div>
							<div class="form-group col-6">
								<label for="idDenominacionMarca"><small>Denominación - Marca</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacionMarca">
							</div>
							<div class="form-group col-6">
								<label for="idDenominacionModelo"><small>Denominación - Modelo</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacionModelo">
							</div>
							<div class="form-group col-12">
								<label for="idDescripcion"><small>Descripción</small></label>
								<textarea rows = "3" cols = "80" class="tabFocus form-control form-control-sm" id="idDescripcion"></textarea>
							</div>
							<div class="form-group col-12 col-md-5">
								<label for="idRubro"><small>Rubro</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idRubro"></select>  
							</div>
							<div class="form-group col-9 col-md-5">
								<label for="idCodigoBarras"><small>Código de Barras</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idCodigoBarras">
							</div>
							<div class="form-group col-3 col-md-2">
								<label for="idGarantia"><small>Garantia</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idGarantia">
									<option value="S/D">S/D</option>
									<option value="72hs">72hs</option>
									<option value="30d">30d</option>									
									<option value="90d">90d</option>									
									<option value="180d">180d</option>									
									<option value="360d">360d</option>									
								</select>  
							</div>
							<div class="form-group col-3">
								<label for="idUnidad"><small>Unidad</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idUnidad">
									<option value="KGS">KGS</option>
									<option value="LTS">LTS</option>								
									<option value="MTS">MTS</option>								
									<option value="PAQ">PAQ</option>								
									<option value="UNI">UNI</option>								
								</select>  				
							</div>
							<div class="form-group col-3">
								<label for="idStock"><small>Stock</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idStock">
							</div>
							<div class="form-group col-3">
								<label for="idStockMinimo"><small>Stock Min.</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idStockMinimo">
							</div>
							<div class="form-group col-3">
								<label for="idStockMaximo"><small>Stock Max.</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idStockMaximo">
							</div>
							<div class="form-group col-3">
								<label for="idCostoBrutoUSD"><small>C.Bruto U$D</small></label>
								<input type="number" step="0.01" class="tabFocus form-control form-control-sm" id="idCostoBrutoUSD" onblur="calcularCosto('idCostoBrutoUSD')">			
							</div>
							<div class="form-group col-3">
								<label for="idAlicuotaIVA"><small>IVA Alic. %</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idAlicuotaIVA" onchange="calcularCosto('costoBrutoUSD')">
									<option value="0">%00.0</option>
									<option value="10.5">%10.5</option>
									<option value="21.0">%21.0</option>								
									<option value="27.0">%27.0</option>														
								</select> 
							</div>
							<div class="form-group col-3">
								<label for="idCostoBaseUSD"><small>IVA Base U$D</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCostoBaseUSD" readonly>
							</div>
							<div class="form-group col-3">
								<label for="idCostoNetoUSD"><small>C.Neto U$D</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCostoNetoUSD" onblur="calcularCosto('idCostoNetoUSD')">
							</div>
							<div class="form-group col-3">
								<label for="idUtilidad"><small>Utilidad %</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idUtilidad" onblur="calcularCosto('idUtilidad')">			
							</div>
							<div class="form-group col-3">
									<label for="idMargenUSD"><small>Margen U$D</small></label>
									<input type="number" class="tabFocus form-control form-control-sm" id="idMargenUSD" readonly>			
							</div>
							<div class="form-group col-3">
								<label for="idPrecioUSD"><small>Precio U$D</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idPrecioUSD" onblur="calcularCosto('idPrecioUSD')">
							</div>
							<div class="form-group col-3">
								<label for="idEstado"><small>Estado</small></label>
								<select class="tabFocus custom-select custom-select-sm" id="idEstado">
									<option value="ACTIVO">ACTIVO</option>
									<option value="BAJA">BAJA</option>								
								</select> 	
							</div>
							<div class="form-group col-3"><small>C.Neto</small><br><small><b id="idCostoNetoAR"></b></small></div>			
							<div class="form-group col-3"><small>Margen</small><br><small><b id="idMargenAR"></b></small></div>			
							<div class="form-group col-3"><small>P.Público</small><br><small><b id="idPrecioPublicoAR"></b></small></div>			
							<div class="form-group col-3"><small>P.Gremio</small><br><small><b id="idPrecioGremioAR"></b></small></div>			
							<div class="form-group col-12">
								<input type="file" accept="image/jpg" class="tabFocus form-control form-control-sm" id="idImagen" capture>
							</div>
						</div>
						<img src="" class="img-fluid rounded mb-2" alt="" id="idImagenVista">
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
<script src="{{ asset('js/cotizacion.js') }}" defer></script>
<script src="{{ asset('js/models/articulo.js') }}" defer></script>
<script src="{{ asset('js/models/rubro.js') }}" defer></script>
<script>
    var imagen = new Image();

	var objArticulo = null;
	function formarCreacion(){
		$('#titulo').text('Crear Artículo');
		this.objArticulo = new Articulo();
		mostrar();
	}

	function formarEdicion(id){
		$('#titulo').text('Editar Artículo');
		this.obtener(id);
	}

	function formarEliminacion(id){
		$('#modalMesajeConfirmacion').modal('toggle');
		$('#idTituloMesajeConfirmacion').text('¿Esta seguro que desea eliminar este registro?');
		$('#idAceptarMesajeConfirmacion').attr('onclick', 'eliminar(' + id + ')');
	}

	function formarLista(listaPaginada = 'listaARTICULO'){
		var filtros = '';
		if (listaPaginada == 'listaARTICULO'){
			filtros += ( $('#idFiltroTipo').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroTipo').val() == 'id' ) ? '&id=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroRubro').val() != null ) ? '&denominacion_rubro=' + $('#idFiltroRubro').val() : '';
			filtros += ( $('#idFiltroEstadoActivo').prop('checked') ) ? '&estado=ACTIVO' : '';
			this.crearPaginacion('/articulos_list', filtros, 'listaARTICULO');
			$('#idTabla').empty().append(this.obtenerListaArticulo(this.paginaSelecionada, filtros, 'btnELIMINAR'));
		}
	}

	function eliminar(id){
		if (this.eliminarArticulo(id)) this.formarLista();
	}

	function guardar(){
		this.objArticulo.tipo = $('#idDenominacionTipo').val();
		this.objArticulo.marca = $('#idDenominacionMarca').val();
		this.objArticulo.modelo = $('#idDenominacionModelo').val();
		this.objArticulo.descripcion = $('#idDescripcion').val();
		this.objArticulo.rubro_id = $('#idRubro').val();
		this.objArticulo.codigo_barras = $('#idCodigoBarras').val();
		this.objArticulo.garantia = $('#idGarantia').val();
		this.objArticulo.unidad = $('#idUnidad').val();
		this.objArticulo.stock = $('#idStock').val();
		this.objArticulo.stock_minimo = $('#idStockMinimo').val();
		this.objArticulo.stock_maximo = $('#idStockMaximo').val();
		this.objArticulo.usd_costo_bruto = parseFloat($('#idCostoBrutoUSD').val()).toFixed(3);
		this.objArticulo.iva_alicuota = parseFloat($('#idAlicuotaIVA').val()).toFixed(1);
		this.objArticulo.usd_iva_base = parseFloat($('#idCostoBaseUSD').val()).toFixed(3);
		this.objArticulo.usd_costo_neto = parseFloat($('#idCostoNetoUSD').val()).toFixed(3);
		this.objArticulo.utilidad = parseFloat($('#idUtilidad').val()).toFixed(3);
		this.objArticulo.usd_margen = parseFloat($('#idMargenUSD').val()).toFixed(3);
		this.objArticulo.usd_precio = parseFloat($('#idPrecioUSD').val()).toFixed(3);
		this.objArticulo.estado = $('#idEstado').val();
		if (this.guardarArticulo(this.objArticulo, $('#idImagen')[0].files[0]) == true) irPaginaInicial('listaARTICULO');
	}

	function mostrar(){
		let costoNetoAR = parseFloat(this.objArticulo.usd_costo_neto * this.cotizacionDolar).toFixed(2);
		let precioPublicoAR = parseFloat(this.regularPrecioPublico(this.objArticulo.usd_precio * (1 + (this.comisionMedioDeCobro/100)) * this.cotizacionDolar)).toFixed(2);
		let precioGremioAR = parseFloat(this.regularPrecioGremio(this.objArticulo.usd_precio * this.cotizacionDolar)).toFixed(2);
		$('#idDenominacionTipo').val(this.objArticulo.tipo);
		$('#idDenominacionMarca').val(this.objArticulo.marca);
		$('#idDenominacionModelo').val(this.objArticulo.modelo);
		$('#idDescripcion').val(this.objArticulo.descripcion);
		$('#idRubro').val(this.objArticulo.rubro_id);
		$('#idCodigoBarras').val(this.objArticulo.codigo_barras);
		$('#idGarantia').val(this.objArticulo.garantia);
		$('#idUnidad').val(this.objArticulo.unidad);
		$('#idStock').val(this.objArticulo.stock);
		$('#idStockMinimo').val(this.objArticulo.stock_minimo);
		$('#idStockMaximo').val(this.objArticulo.stock_maximo);
		$('#idCostoBrutoUSD').val(parseFloat(this.objArticulo.usd_costo_bruto).toFixed(3));
		$('#idAlicuotaIVA').val(this.objArticulo.iva_alicuota);
		$('#idCostoBaseUSD').val(parseFloat(this.objArticulo.usd_iva_base).toFixed(3));
		$('#idCostoNetoUSD').val(parseFloat(this.objArticulo.usd_costo_neto).toFixed(3));
		$('#idUtilidad').val(parseFloat(this.objArticulo.utilidad).toFixed(3));
		$('#idMargenUSD').val(parseFloat(this.objArticulo.usd_margen).toFixed(3));
		$('#idPrecioUSD').val(parseFloat(this.objArticulo.usd_precio).toFixed(3));
		$('#idEstado').val(this.objArticulo.estado);
		$('#idCostoNetoAR').text('$' + costoNetoAR);
		$('#idMargenAR').text('$' + parseFloat(precioGremioAR - costoNetoAR).toFixed(2));
		$('#idPrecioPublicoAR').text('$' + precioPublicoAR);
		$('#idPrecioGremioAR').text('$' + precioGremioAR);
		$('#idImagenVista').attr('src', ((this.objArticulo.imagen_nombre.trim() == '') ? '' : '\\img\\articulos\\' + this.objArticulo.imagen_nombre) );
		$('#idImagen').val(null); //Importante: Libera el "input file"
	}

	function obtener(id){
		if (this.obtenerArticulo(id) != null) mostrar();
	}

	async function obtenerDesplegable_Rubros(){
		var items = await this.obtenerDesplegableRubros();
		$('#idFiltroRubro').empty().append(items.paraFiltro);
		$('#idRubro').empty().append(items.paraFormulario);
	}

	function calcularCosto(origen){
		var alicuotaIVA = parseFloat(( $('#idAlicuotaIVA').val() ).replace(',','.')).toFixed(3);
		var costoBrutoUSD = costoBaseUSD = costoNetoUSD = utilidad ='0.00';
		if(origen == 'idCostoNetoUSD'){
			costoNetoUSD = (isNaN(parseFloat( $('#idCostoNetoUSD').val() ))) ? '0.00' : parseFloat(( $('#idCostoNetoUSD').val() ).replace(',','.')).toFixed(3);
			costoBaseUSD = parseFloat(costoNetoUSD) / (100 + parseFloat(alicuotaIVA)) * parseFloat(alicuotaIVA);
			costoBrutoUSD = parseFloat(costoNetoUSD) - parseFloat(costoBaseUSD);
		}else{
			costoBrutoUSD = (isNaN(parseFloat( $('#idCostoBrutoUSD').val() ))) ? '0.00' : parseFloat(( $('#idCostoBrutoUSD').val() ).replace(',','.')).toFixed(3);
			costoBaseUSD = (parseFloat(costoBrutoUSD) / 100) * parseFloat(alicuotaIVA);
			costoNetoUSD = parseFloat(costoBrutoUSD) + parseFloat(costoBaseUSD);
		}
		if(origen == 'idPrecioUSD'){
			precioUSD = (isNaN(parseFloat( $('#idPrecioUSD').val() ))) ? '0.00' : parseFloat(( $('#idPrecioUSD').val() ).replace(',','.')).toFixed(3);
			margenUSD = (costoBrutoUSD == 0.00) ? precioUSD : parseFloat(precioUSD) - parseFloat(costoNetoUSD);
			utilidad = (costoBrutoUSD == 0.00) ? 100.00 : (100 / parseFloat(costoNetoUSD)) * parseFloat(margenUSD);
		}else{
			utilidad = (costoBrutoUSD == 0.00) ? 100.00 : (isNaN(parseFloat( $('#idUtilidad').val() ))) ? '0.00' : parseFloat(( $('#idUtilidad').val() ).replace(',','.')).toFixed(3);
			if (costoBrutoUSD != 0.00) margenUSD = (parseFloat(costoNetoUSD) / 100) * parseFloat(utilidad);
			if (costoBrutoUSD != 0.00) precioUSD = parseFloat(costoNetoUSD) + parseFloat(margenUSD);
		}
		var costoNetoAR = parseFloat(costoNetoUSD) * parseFloat(this.cotizacionDolar); 
		var margenAR = parseFloat(margenUSD) * parseFloat(this.cotizacionDolar);
		var precioPublicoAR = (parseFloat(precioUSD) * (1 + (parseFloat(this.comisionMedioDeCobro) / 100))) * parseFloat(this.cotizacionDolar);
		var precioGremioAR = parseFloat(precioUSD) * parseFloat(this.cotizacionDolar);
		$('#idCostoBrutoUSD').val(parseFloat(costoBrutoUSD).toFixed(3));
		$('#idCostoBaseUSD').val(parseFloat(costoBaseUSD).toFixed(3));
		$('#idCostoNetoUSD').val(parseFloat(costoNetoUSD).toFixed(3));
		$('#idUtilidad').val(parseFloat(utilidad).toFixed(3));
		$('#idMargenUSD').val(parseFloat(margenUSD).toFixed(3));
		$('#idPrecioUSD').val(parseFloat(precioUSD).toFixed(3));
		$('#idCostoNetoAR').text('$' + parseFloat(costoNetoAR).toFixed(2));
		$('#idMargenAR').text('$' + parseFloat(margenAR).toFixed(2));
		$('#idPrecioPublicoAR').text('$' + parseFloat(precioPublicoAR).toFixed(2));
		$('#idPrecioGremioAR').text('$' + parseFloat(precioGremioAR).toFixed(2));
	}

	$('document').ready( function() { obtenerDesplegable_Rubros(); irPaginaInicial('listaARTICULO'); });
	$('#idFiltroTipo, #idFiltroRubro, #idFiltroEstadoActivo').change( function() { irPaginaInicial('listaARTICULO'); });
	$('#idFiltroTexto').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaARTICULO'); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

	$('#idImagen').change( function(e) {
		let lector = new FileReader();
		if(e.target.files[0] != null){
			lector.readAsDataURL(e.target.files[0]); //Lee el archivo subido 
			lector.onloadend = () => { 
				var image = new Image(100, 200);
				image.src = lector.result;
				image.onload = function() { $('#idImagenVista').attr('src', image.src); }; //Muestra la imagen cuando ha terminado su lectura 
			}
		}
		else $('#idImagenVista').attr('src', '');
	});

</script>
@endsection