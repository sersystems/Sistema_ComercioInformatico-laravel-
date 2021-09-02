<div class="modal fade" id="modalClienteBuscador" tabindex="-1" role="dialog" aria-labelledby="titulo" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<span class="h6">Buscar Cliente</span>
				<div class="mt-3 justify-content-center">

					<!-- =================== Sector: Buscador ==================== -->
					<div class="col-12">
						<div class="input-group justify-content-center mb-1">
							<select class="custom-select custom-select-sm col-7 col-md-5" id="idFiltroTipoBuscadorCliente">
								<option value="denominacion">BUSCAR POR NOMBRE</option>
								<option value="id">BUSCAR POR ID</option>
							</select>  
							<input type="text" class="form-control form-control-sm col-5 col-md-5" id="idFiltroTextoBuscadorCliente" placeholder="Buscar...">
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
									<th class="align-text-top"><small></small></th>
								</tr>
							</thead>
							<tbody id="idTablaBuscadorCliente">
							</tbody>
						</table>
						<div id="idPaginacionBuscador"></div>
					</div>

					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>