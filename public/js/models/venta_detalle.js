class VentaDetalle {
    constructor(
        id = 0,
        venta_id = '',
        articulo_id = '',
        denominacion = '',
        garantia = '',
        cantidad = '0',
        ar_precio = '0.00',
        iva_alicuota = '00.0',
        ar_base = '0.00',
        ar_importe = '0.00',
        ar_costo = '0.00',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.venta_id = venta_id,
            this.articulo_id = articulo_id,
            this.denominacion = denominacion,
            this.garantia = garantia,
            this.cantidad = cantidad,
            this.ar_precio = ar_precio,
            this.iva_alicuota = iva_alicuota,
            this.ar_base = ar_base,
            this.ar_importe = ar_importe,
            this.ar_costo = ar_costo,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function eliminarVentaDetalle(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/venta_detalles/' + id,
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

function guardarVentaDetalle(objVentaDetalle){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objVentaDetalle && objVentaDetalle.id) ? "PUT" : "POST",
            url: (objVentaDetalle && objVentaDetalle.id) ? '/venta_detalles/' + objVentaDetalle.id : '/venta_detalles',
            data: objVentaDetalle,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = true;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objVentaDetalle && objVentaDetalle.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerVentaDetalle(id){
    objVentaDetalle = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/venta_detalles/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objVentaDetalle = new VentaDetalle (
                    data.id,
                    data.venta_id,
                    data.articulo_id,
                    data.denominacion,
                    data.garantia,
                    data.cantidad,
                    data.ar_precio,
                    data.iva_alicuota,
                    data.ar_base,
                    data.ar_importe,
                    data.ar_costo,
                    data.created_at,
                    data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objVentaDetalle;
}

function obtenerVentaDetalles(pagina = 1, filtros = ''){
    lista = new Array();
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/venta_detalles_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach( elemento => { lista.push(elemento) }) 
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return lista;
}