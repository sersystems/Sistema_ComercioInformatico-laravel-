class Venta {
    constructor(
        id = 0,
        estado = 'ACTIVO',
        cbte_tipo = 'FAC-C',
        cbte_tpv = '00002',
        cbte_nro = '',
        cbte_fecha = Date.now(),
        cliente_id = '',
        cliente_denominacion = '',
        cliente_cuit = '',
        cliente_iva = '',
        cliente_saldo = '',
        cliente_lista_precio = '',
        ar_subtotal = '0.00',
        ar_descuento_taza = '0.000',
        ar_descuento_monto = '0.00',
        ar_iva105 = '0.00',
        ar_iva210 = '0.00',
        ar_iva270 = '0.00',
        ar_total = '0.00',
        ar_costo = '0.00',
        ar_margen = '0.00',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.estado = estado,
            this.cbte_tipo = cbte_tipo,
            this.cbte_tpv = cbte_tpv,
            this.cbte_nro = cbte_nro,
            this.cbte_fecha = cbte_fecha,
            this.cliente_id = cliente_id,
            this.cliente_denominacion = cliente_denominacion,
            this.cliente_cuit = cliente_cuit,
            this.cliente_iva = cliente_iva,
            this.cliente_saldo = cliente_saldo,
            this.cliente_lista_precio = cliente_lista_precio,
            this.ar_subtotal = ar_subtotal,
            this.ar_descuento_taza = ar_descuento_taza,
            this.ar_descuento_monto = ar_descuento_monto,
            this.ar_iva105 = ar_iva105,
            this.ar_iva210 = ar_iva210,
            this.ar_iva270 = ar_iva270,
            this.ar_total = ar_total,
            this.ar_costo = ar_costo,
            this.ar_margen = ar_margen,
            this.created_at = created_at,
            this.updated_at = updated_at
        }

    obtenerObjeto(id){
        $.ajax({
            type: "GET",
            url: '/ventas/' + id,
            dataType: 'json',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                $("#idEstadoProceso").text('');
                var ser = new Venta (
                    data.id,
                    data.estado,
                    data.cbte_tipo,
                    data.cbte_tpv,
                    data.cbte_nro,
                    data.cbte_fecha,
                    Cliente.obtenerObjeto(data.cliente_id),
                    data.ar_subtotal,
                    data.ar_descuento_taza,
                    data.ar_descuento_monto,
                    data.ar_iva105,
                    data.ar_iva210,
                    data.ar_iva270,
                    data.ar_total,
                    data.ar_costo,
                    data.ar_margen,
                    data.created_at,
                    data.updated_at
                );
                console.log(ser);
            },
            error: () => {
                $("#idEstadoProceso").text('Error durante la ejecución (registro No cargado).');
            }
        });		
    }
}

function eliminarVenta(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/ventas/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = true;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No eliminado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function guardarVenta(objVenta){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objVenta && objVenta.id) ? "PUT" : "POST",
            url: (objVenta && objVenta.id) ? '/ventas/' + objVenta.id : '/ventas',
            data: objVenta,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = true;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objVenta && objVenta.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerVenta(id){
    objVenta = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/ventas/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objVenta = new Venta (
                    data.id,
                    data.estado,
                    data.cbte_tipo,
                    data.cbte_tpv,
                    data.cbte_nro,
                    data.cbte_fecha,
                    data.cliente_id,
                    data.cliente_denominacion,
                    data.cliente_cuit,
                    data.cliente_iva,
                    data.cliente_saldo,
                    data.cliente_lista_precio,
                    data.ar_subtotal,
                    data.ar_descuento_taza,
                    data.ar_descuento_monto,
                    data.ar_iva105,
                    data.ar_iva210,
                    data.ar_iva270,
                    data.ar_total,
                    data.ar_costo,
                    data.ar_margen,
                    data.created_at,
                    data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objVenta;
}

function obtenerVentas(pagina = 1, filtros = ''){
    lista = new Array();
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/ventas_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach( elemento => { lista.push(elemento) }) 
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return lista;
}

function obtenerListaVenta(pagina = 1, filtros = '', boton = 'btnAGREGAR'){
    var Lista = '';
    boton = (boton == 'btnAGREGAR')?  'formarAgregacion' : 'formarEliminacion';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/ventas_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><a href="#" data-toggle="modal" data-target="#modalFormulario" onclick="formarEdicion(' + element.id + ')"><small>' + element.cbte_tipo + ' ' + element.cbte_tpv + '-' + String('00000000' + element.cbte_nro).slice(-8) + '  ' + formatearFecha(element.cbte_fecha, "DD-MM-YYYY") + '</small></a></th>' +
                        '<th><small>' + element.cliente_denominacion + '</small></th>' +
                        '<th><small>' + element.cliente_cuit + '</small></th>' +
                        '<th><small>$' + parseFloat(element.ar_total).toFixed(2) + '</small></th>' +
                        '<th class="d-flex justify-content-end">' +
                            ((boton == 'btnAGREGAR') ? '<button class="btn-sm btn-info" onclick="formarAgregacion(' + element.id + ')"><i class="fas fa-sign-in-alt"></i></button>' : '<button class="btn-sm btn-danger" onclick="formarEliminacion(' + element.id + ')"><i class="fas fa-trash"></i></button>') +
                        '</th>' + 
                    '</tr>';
                });
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return Lista;
}