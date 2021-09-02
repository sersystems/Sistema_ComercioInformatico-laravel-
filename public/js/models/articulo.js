var comisionMedioDeCobro = '5.00';

class Articulo {
    constructor(
        id = 0,
        tipo = '',
        marca = '',
        modelo = '',
        descripcion = '',
        rubro_id = '',
        rubro_denominacion = '',
        codigo_barras = '',
        garantia = '90d',
        unidad = 'UNI',
        stock = '0',
        stock_minimo = '0',
        stock_maximo = '0',
        usd_costo_bruto = '0.00',
        iva_alicuota = '0',
        usd_iva_base = '0.00',
        usd_costo_neto = '0.00',
        utilidad = '30.00',
        usd_margen = '0.00',
        usd_precio = '0.00',
        imagen_nombre = '',
        estado = 'ACTIVO',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.tipo = tipo,
            this.marca = marca,
            this.modelo = modelo,
            this.descripcion = descripcion,
            this.rubro_id = rubro_id,
            this.rubro_denominacion = rubro_denominacion,
            this.codigo_barras = codigo_barras,
            this.garantia = garantia,
            this.unidad = unidad,
            this.stock = stock,
            this.stock_minimo = stock_minimo,
            this.stock_maximo = stock_maximo,
            this.usd_costo_bruto = usd_costo_bruto,
            this.iva_alicuota = iva_alicuota,
            this.usd_iva_base = usd_iva_base,
            this.usd_costo_neto = usd_costo_neto,
            this.utilidad = utilidad,
            this.usd_margen = usd_margen,
            this.usd_precio = usd_precio,
            this.imagen_nombre = imagen_nombre,
            this.estado = estado,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function eliminarArticulo(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/articulos/' + id,
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

function guardarArticulo(objArticulo, imagenSeleccionada){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objArticulo && objArticulo.id) ? "PUT" : "POST",
            url: (objArticulo && objArticulo.id) ? '/articulos/' + objArticulo.id : '/articulos',
            data: objArticulo,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                if (imagenSeleccionada != undefined){
                    var imagen = new FormData();
                    imagen.append('id', data.id);
                    imagen.append('imagen', imagenSeleccionada);
                    $.ajax({
                        async: false,
                        method: "POST",
                        url: '/articulos_upload',
                        data: imagen,
                        contentType: false,
                        processData: false,
                        dataType: 'JSON',
                        beforeSend: () => { $("#idEstadoProceso").text("Subiendo... Por favor espere."); },
                        success: (upload) => { 
                            if(upload.message == undefined) $("#idEstadoProceso").text(data.message);
                            $("#idEstadoProceso").text(upload.message);
                            respuesta = data.procesado;
                        },
                        error: (e) => { $("#idEstadoProceso").text('Imagen No subida' + ' (ERROR-' + e.status + ')'); }
                    });
                }
                else $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objArticulo && objArticulo.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerArticulo(id){
    objArticulo = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/articulos/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objArticulo = new Articulo (
					data.id,
					data.tipo,
					data.marca,
					data.modelo,
					data.descripcion,
					data.rubro_id,
					data.rubro_denominacion,
					data.codigo_barras,
					data.garantia,
					data.unidad,
					data.stock,
					data.stock_minimo,
					data.stock_maximo,
					data.usd_costo_bruto,
					data.iva_alicuota,
					data.usd_iva_base,
					data.usd_costo_neto,
					data.utilidad,
					data.usd_margen,
                    data.usd_precio,
                    data.imagen_nombre,
					data.estado,
					data.created_at,
					data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objArticulo;
}

function obtenerArticulos(pagina = 1, filtros = ''){
    lista = new Array();
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/articulos_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach( elemento => { lista.push(elemento) }) 
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return lista;
}

function obtenerListaArticulo(pagina = 1, filtros = '', boton = 'btnAGREGAR'){
    var Lista = '';
    boton = (boton == 'btnAGREGAR')?  'formarAgregacion' : 'formarEliminacion';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/articulos_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><a href="#" data-toggle="modal" data-target="#modalFormulario" onclick="formarEdicion(' + element.id + ')"><small>' + element.tipo + ' ' + element.marca + ' ' + element.modelo + '</small></a></th>' +
                        '<th><small>' + element.stock + '</small></th>' +
                        '<th><small>$' + parseFloat(this.regularPrecioPublico(element.usd_precio * (1 + (this.comisionMedioDeCobro / 100)) * this.cotizacionDolar)).toFixed(2) + '</small></th>' +
                        '<th><small>$' + parseFloat(this.regularPrecioGremio(element.usd_precio * this.cotizacionDolar)).toFixed(2) + '</small></th>' +
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