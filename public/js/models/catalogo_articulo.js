var comisionMedioDeCobro = '5.00';

class CatalogoArticulo {
    constructor(
        id = 0,
        tipo = '',
        marca = '',
        modelo = '',
        descripcion = '',
        rubro_id = '',
        rubro_denominacion = '',
        garantia = '90d',
        unidad = 'UNI',
        stock = '0',
        iva_alicuota = '0',
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
            this.garantia = garantia,
            this.unidad = unidad,
            this.stock = stock,
            this.iva_alicuota = iva_alicuota,
            this.usd_precio = usd_precio,
            this.imagen_nombre = imagen_nombre,
            this.estado = estado,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function obtenerCatalogoArticulo(id){
    objCatalogoArticulo = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/catalogo_articulos/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objCatalogoArticulo = new CatalogoArticulo (
					data.data.id,
					data.data.tipo,
					data.data.marca,
					data.data.modelo,
					data.data.descripcion,
					data.data.rubro_id,
                    data.data.rubro_denominacion,
					data.data.garantia,
					data.data.unidad,
                    data.data.stock,
                    data.data.iva_alicuota,
                    ((data.sesion != 'GREMIO') ? this.regularPrecioPublico(data.data.usd_precio * (1 + (this.comisionMedioDeCobro/100)) * this.cotizacionDolar) : this.regularPrecioGremio(data.data.usd_precio * this.cotizacionDolar)),
                    data.data.imagen_nombre,
					data.data.estado,
					data.data.created_at,
					data.data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objCatalogoArticulo;
}

function obtenerListaCatalogoArticulo(pagina = 1, filtros = ''){
    var Lista = '';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/catalogo_articulos_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.data.forEach(element => {
                    let precio = parseFloat(element.usd_precio * this.cotizacionDolar * ((data.sesion != 'GREMIO') ? 1 + (this.comisionMedioDeCobro / 100) : 1)).toFixed(2);
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><small>' + element.tipo + ' ' + element.marca + ' ' + element.modelo + '</small></th>' +
                        '<th><small>$' + ((data.sesion != 'GREMIO') ? this.regularPrecioPublico(precio) : this.regularPrecioGremio(precio)) + '</small></th>' +
                        '<th class="d-flex justify-content-end">' +
                            '<button class="btn-sm btn-info" data-toggle="modal" data-target="#modalFormulario" onclick="formarVisualizacion(' + element.id + ')"><i class="far fa-eye"></i></button></th>' +
                        '</th>' + 
                    '</tr>';
                });
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return Lista;
}