@extends('plantilla')
@section('title', 'Ventas')
@section('content')
	
	<!-- =================== Sector: Buscador ==================== -->
	<div class="col-12">
		<div class="input-group justify-content-center mb-1">
			<select class="custom-select custom-select-sm col-7 col-md-3 col-lg-3" id="idFiltroTipo">
				<option value="denominacion_cliente">BUSCAR POR NOMBRE</option>
				<option value="cuit_cliente">BUSCAR POR CUIT</option>
				<option value="id">BUSCAR POR ID</option>
			</select>  
			<input type="text" class="form-control form-control-sm col-5 col-md-3 col-lg-2" id="idFiltroTexto" placeholder="Buscar...">
		</div>
		<div class="input-group justify-content-center mb-1">
			<div class="form-control form-control-sm col-12">
				<input type="checkbox" class="form-check form-check-inline" checked id="idFiltroEstadoActivo">
				<small class="align-text-bottom">Solo Activos</small>
			</div>
		</div>
	</div>

	<!-- =============== Sector: Lista de Lista ================ -->
	<div class="col-12">
		<table class="table table-sm">
			<thead>
				<tr class="bg-secondary text-white">
					<th class="align-text-top" width="10%"><small>#</small></th>
					<th class="align-text-top"><small>Comprobante</small></th>
					<th class="align-text-top"><small>Denominación</small></th>
					<th class="align-text-top"><small>CUIT/CUIL</small></th>
					<th class="align-text-top"><small>Total</small></th>
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
					<form id="form">
						@csrf
						<div class="form-row">
							<div class="col-12 mb-2"><small>Comprobante (Cbte-TPV-Nro-Fecha-Estado)</small></div>
							<div class="input-group input-group-sm col-12 col-md-6 mb-1">
								<select class="tabFocus custom-select col-4" style="font-size: 9pt;" id="idCbteTipo">
									<option value="FAC-A">FAC-A</option>
									<option value="FAC-B">FAC-B</option>
									<option value="FAC-C">FAC-C</option>
									<option value="FAC-M">FAC-M</option>
									<option value="DES-X">DES-X</option>
									<option value="NDE-A">NDE-A</option>
									<option value="NDE-B">NDE-B</option>
									<option value="NDE-C">NDE-C</option>
									<option value="NDE-M">NDE-M</option>
									<option value="NCR-A">NCR-A</option>
									<option value="NCR-B">NCR-B</option>
									<option value="NCR-C">NCR-C</option>
									<option value="NCR-M">NCR-M</option>
									<option value="PRE-X">PRE-X</option>
									<option value="REM-R">REM-R</option>
									<option value="REM-X">REM-X</option>
								</select>
								<input type="number" class="tabFocus form-control col-3" id="idCbteTPV">
								<input type="number" class="tabFocus form-control col-5" id="idCbteNro">
							</div>
							<div class="input-group input-group-sm col-12 col-md-6 mb-1">
								<input type="date" class="tabFocus form-control col-8" id="idCbteFecha">
								<input type="text" class="tabFocus form-control col-4" id="idEstado" readonly>
							</div>
							<div class="col-12 my-2"><small>Cliente (ID-Denominación-CUIT-IVA-Saldo)</small></div>
							<div class="input-group input-group-sm col-12 mb-1">
								<input type="number" class="tabFocus form-control col-2" id="idClienteID" readonly>
								<input type="text" class="tabFocus form-control col-10" id="idClienteDenominacion" readonly>
								<div class="input-group-append"><span class="input-group-text" onclick="formarBuscadorCliente()"><i class="fas fa-search"></i></span></div>
							</div>
							<div class="input-group input-group-sm col-12 mb-1">
								<input type="text" class="tabFocus form-control col-4" id="idClienteCUIT" readonly>
								<input type="text" class="tabFocus form-control col-5" id="idClienteIVA" readonly>
								<input type="text" class="tabFocus form-control col-3" id="idClienteSaldo" readonly>
								<input type="text" id="idClienteListaPrecio" hidden>
							</div>
							<div class="input-group input-group-sm col-12 mb-1">
								<small class="col-9 text-right mt-1">SUBTOTAL $</small>
								<input type="number" class="tabFocus form-control form-control-sm col-3" id="idSubTotalAR" readonly>
							</div>
							<div class="form-group col-12 text-right">
								<div><small>(IVA: %10.5 $</small><small id="idIVA105AR">0.00</small><small> ~ %21.0 $</small><small id="idIVA210AR">0.00</small><small> ~ %27.0 $</small><small id="idIVA270AR">0.00</small><small>)</small></div>
							</div>							
							<div class="input-group input-group-sm col-12 mb-1">
								<small class="col-9 text-right mt-1">Descuento %</small>
								<input type="number" class="tabFocus form-control form-control-sm col-3" id="idDescuentoTaza">
							</div>
							<div class="input-group input-group-sm col-12 mb-1">
								<small class="col-9 text-right mt-1">Descuento $</small>
								<input type="number" class="tabFocus form-control form-control-sm col-3" id="idDescuentoAR">
							</div>
							<div class="input-group input-group-sm col-12 mb-1">
								<small class="col-9 text-right mt-1"><b>TOTAL $</b></small>
								<input type="number" class="tabFocus form-control form-control-sm col-3" id="idTotalAR" readonly>
							</div>
							<div class="form-group col-12 text-right">
								<div><small>COSTO $</small><small id="idCostoAR">0.00</small><small> ~ MARGEN $</small><small id="idMargenAR">0.00</small></div>
							</div>
						</div>
						<div class="text-center">
							<a class="btn btn-primary" data-dismiss="modal" onclick="guardar()">Guardar</a>
							<a class="btn btn-danger" data-dismiss="modal" onclick="anular()">Anular</a>
							<a class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
						</div>
					</form>
					<div id="idVer"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal: Msj de Confirmación -->
	 @include('clienteBuscador')

@endsection

@section('script')
<script src="{{ asset('js/cotizacion.js') }}" defer></script>
<script src="{{ asset('js/models/venta.js') }}" defer></script>
<script src="{{ asset('js/models/venta_detalle.js') }}" defer></script>
<script src="{{ asset('js/models/cliente.js') }}" defer></script>
<script>

	var objVenta = null;
	function formarBuscadorCliente(){
		$('#modalClienteBuscador').modal('toggle');
		formarLista('listaCLIENTE');
	}

	function formarCreacion(){
		$('#titulo').text('Crear Venta');
		this.objVenta = new Venta();
		mostrar();
	}

	function formarEdicion(id){
		$('#titulo').text('Editar Venta');
		this.obtener(id);
	}

	function formarEliminacion(id){
		$('#modalMesajeConfirmacion').modal('toggle');
		$('#idTituloMesajeConfirmacion').text('¿Esta seguro que desea eliminar este registro?');
		$('#idAceptarMesajeConfirmacion').attr('onclick', 'eliminar(' + id + ')');
	}

	function formarLista(listaPaginada = 'listaVENTA'){
		var filtros = '';
		if (listaPaginada == 'listaVENTA'){
			filtros += ( $('#idFiltroTipo').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroTipo').val() == 'id' ) ? '&id=' + $('#idFiltroTexto').val() : '';
			filtros += ( $('#idFiltroEstadoActivo').prop('checked') ) ? '&estado=ACTIVO' : '';
			this.crearPaginacion('/ventas_list', filtros, 'listaVENTA');
			$('#idTabla').empty().append(this.obtenerListaVenta(this.paginaSelecionada, filtros, 'btnELIMINAR'));
		}
		else if (listaPaginada == 'listaCLIENTE'){
			filtros += ( $('#idFiltroTipoBuscadorCliente').val() == 'denominacion' ) ? '&denominacion=' + $('#idFiltroTextoBuscadorCliente').val() : '';
			filtros += ( $('#idFiltroTipoBuscadorCliente').val() == 'id' ) ? '&id=' + $('#idFiltroTextoBuscadorCliente').val() : '';
			filtros += '&estado=ACTIVO';
			this.crearPaginacion('/clientes_list', filtros, 'listaCLIENTE');
			$('#idTablaBuscadorCliente').empty().append(this.obtenerListaCliente(this.paginaSelecionada, filtros, 'btnAGREGAR'));
		}
	}

	function eliminar(id){
		if (this.eliminarVenta(id)) this.formarLista();
	}

	function guardar(){
		this.objVenta.cbte_tipo = $('#idCbteTipo').val();
		this.objVenta.cbte_tpv = $('#idCbteTPV').val();
		this.objVenta.cbte_nro = $('#idCbteNro').val();
		this.objVenta.cbte_fecha = $('#idCbteFecha').val();
		this.objVenta.estado = $('#idEstado').val();
		this.objVenta.cliente_id = $('#idClienteID').val();
		this.objVenta.denominacion = $('#idClienteDenominacion').val();
		this.objVenta.cuit = $('#idClienteCUIT').val();
		this.objVenta.iva = $('#idClienteIVA').val();
		this.objVenta.saldo = $('#idClienteSaldo').val();
		this.objVenta.lista_precio = $('#idClienteListaPrecio').val();
		this.objVenta.ar_subtotal = $('#idSubTotalAR').val();
		this.objVenta.ar_iva105 = $('#idIVA105AR').text();
		this.objVenta.ar_iva210 = $('#idIVA210AR').text();
		this.objVenta.ar_iva270 = $('#idIVA270AR').text();
		this.objVenta.ar_descuento_taza = $('#idDescuentoTaza').val();
		this.objVenta.ar_descuento_monto = $('#idDescuentoAR').val();
		this.objVenta.ar_total = $('#idTotalAR').val();
		this.objVenta.ar_costo = $('#idCostoAR').text();
		this.objVenta.ar_margen = $('#idMargenAR').text();
		if (this.guardarVenta(this.objVenta)) this.formarLista();
	}

	function mostrar(){
		$('#idCbteTipo').val(this.objVenta.cbte_tipo);
		$('#idCbteTPV').val(String('00000' + this.objVenta.cbte_tpv).slice(-5));
		$('#idCbteNro').val(String('00000000' + this.objVenta.cbte_nro).slice(-8));
		$('#idCbteFecha').val(formatearFecha(this.objVenta.cbte_fecha));
		$('#idEstado').val(this.objVenta.estado);
		$('#idClienteID').val(this.objVenta.cliente_id);
		$('#idClienteDenominacion').val(this.objVenta.cliente_denominacion);
		$('#idClienteCUIT').val(this.objVenta.cliente_cuit);
		$('#idClienteIVA').val(this.objVenta.cliente_iva);
		$('#idClienteSaldo').val(parseFloat(this.objVenta.cliente_saldo).toFixed(2));
		$('#idClienteListaPrecio').val(this.objVenta.cliente_lista_precio);
		$('#idSubTotalAR').val(parseFloat(this.objVenta.ar_subtotal).toFixed(2));
		$('#idIVA105AR').text(parseFloat(this.objVenta.ar_iva105).toFixed(2));
		$('#idIVA210AR').text(parseFloat(this.objVenta.ar_iva210).toFixed(2));
		$('#idIVA270AR').text(parseFloat(this.objVenta.ar_iva270).toFixed(2));
		$('#idDescuentoTaza').val(parseFloat(this.objVenta.ar_descuento_taza).toFixed(3));
		$('#idDescuentoAR').val(parseFloat(this.objVenta.ar_descuento_monto).toFixed(2));
		$('#idTotalAR').val(parseFloat(this.objVenta.ar_total).toFixed(2));
		$('#idCostoAR').text(parseFloat(this.objVenta.ar_costo).toFixed(2));
		$('#idMargenAR').text(parseFloat(this.objVenta.ar_margen).toFixed(2));
	}

	function obtener(id){
		if (this.obtenerVenta(id) != null) mostrar();
	}

	function obtenerCliente(){

	}

	function obtenerArticulo(){

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
			margenUSD = parseFloat(precioUSD) - parseFloat(costoNetoUSD);
			utilidad = (100 / parseFloat(costoNetoUSD)) * parseFloat(margenUSD);
		}else{
			utilidad = (isNaN(parseFloat( $('#idUtilidad').val() ))) ? '0.00' : parseFloat(( $('#idUtilidad').val() ).replace(',','.')).toFixed(3);
			margenUSD = (parseFloat(costoNetoUSD) / 100) * parseFloat(utilidad);
			precioUSD = parseFloat(costoNetoUSD) + parseFloat(margenUSD);
		}
		var costoNetoAR = parseFloat(costoNetoUSD) * parseFloat(this.cotizacionDolar); 
		var margenAR = parseFloat(margenUSD) * parseFloat(this.cotizacionDolar);
		var precioPublicoAR = (parseFloat(precioUSD) * (1 + (parseFloat(this.comisionPago) / 100))) * parseFloat(this.cotizacionDolar);
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

	function formatearFecha(fecha, formato = "YYYY-MM-DD"){
		var dia = ("0" + new Date(fecha).getDate()).slice(-2);
		var mes = ("0" + (new Date(fecha).getMonth() + 1)).slice(-2);
		var anio = new Date(fecha).getFullYear();
		return (formato == "DD-MM-YYYY") ? (dia + '-' + mes + '-' + anio) : (anio + '-' + mes + '-' + dia);
	}

	$('document').ready( function() { irPaginaInicial('listaVENTA'); });
	$('#idFiltroTipo, #idFiltroEstadoActivo').change( function() { irPaginaInicial('listaVENTA'); });
	$('#idFiltroTexto').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaVENTA'); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

	$('#idFiltroTipoBuscadorCliente, #idFiltroEstadoActivoBuscadorCliente').change( function() { irPaginaInicial('listaCLIENTE'); });
	$('#idFiltroTextoBuscadorCliente').keypress( function(e) { if(e.which == 13) irPaginaInicial('listaCLIENTE'); });

</script>
@endsection