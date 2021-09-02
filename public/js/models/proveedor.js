class Proveedor {
    constructor(
        id = 0,
        denominacion = '',
        cuit = '',
        iva = 'RESPONSABLE INSCRIPTO',
        domicilio = 'X',
        provincia = 'SAN JUAN',
        distrito = 'RAWSON',
        cp = '5425',
        telefono = '',
        celular1 = '',
        celular2 = '',
        email = '',
        saldo = '0.00',
        estado = 'ACTIVO',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.denominacion = denominacion,
            this.cuit = cuit,
            this.iva = iva,
            this.domicilio = domicilio,
            this.provincia = provincia,
            this.distrito = distrito,
            this.cp = cp,
            this.telefono = telefono,
            this.celular1 = celular1,
            this.celular2 = celular2,
            this.email = email,
            this.saldo = saldo,
            this.estado = estado,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function eliminarProveedor(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/proveedores/' + id,
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

function guardarProveedor(objProveedor){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objProveedor && objProveedor.id) ? "PUT" : "POST",
            url: (objProveedor && objProveedor.id) ? '/proveedores/' + objProveedor.id : '/proveedores',
            data: objProveedor,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = data.procesado;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objProveedor && objProveedor.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerProveedor(id){
    objProveedor = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/proveedores/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objProveedor = new Proveedor (
                    data.id,
                    data.denominacion,
                    data.cuit,
                    data.iva,
                    data.domicilio,
                    data.provincia,
                    data.distrito,
                    data.cp,
                    data.telefono,
                    data.celular1,
                    data.celular2,
                    data.email,
                    data.saldo,
                    data.estado,
                    data.created_at,
                    data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objProveedor;
}

function obtenerProveedores(pagina = 1, filtros = ''){
    lista = new Array();
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/proveedores_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach( elemento => { lista.push(elemento) }) 
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return lista;
}

function obtenerListaProveedor(pagina = 1, filtros = '', boton = 'btnAGREGAR'){
    var Lista = '';
    boton = (boton == 'btnAGREGAR')?  'formarAgregacion' : 'formarEliminacion';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/proveedores_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><a href="#" data-toggle="modal" data-target="#modalFormulario" onclick="formarEdicion(' + element.id + ')"><small>' + element.denominacion + '</small></a></th>' +
                        '<th><small>' + element.cuit + '</small></th>' +
                        '<th><small>$' + element.saldo + '</small></th>' +
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