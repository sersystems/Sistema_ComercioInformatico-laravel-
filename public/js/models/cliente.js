class Cliente {
    constructor(
        id = 0,
        apellido = '',
        nombre = '',
        cuit = '',
        iva = 'CONSUMIDOR FINAL',
        domicilio = 'X',
        provincia = 'SAN JUAN',
        distrito = 'RAWSON',
        cp = '5425',
        telefono = '',
        celular1 = '',
        celular2 = '',
        email = '',
        lista_precio = 'P.PUBLICO',
        saldo = '0.00',
        estado = 'ACTIVO',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.apellido = apellido,
            this.nombre = nombre,
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
            this.lista_precio = lista_precio,
            this.saldo = saldo,
            this.estado = estado,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function eliminarCliente(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/clientes/' + id,
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

function guardarCliente(objCliente){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objCliente && objCliente.id) ? "PUT" : "POST",
            url: (objCliente && objCliente.id) ? '/clientes/' + objCliente.id : '/clientes',
            data: objCliente,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = data.procesado;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objCliente && objCliente.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerCliente(id){
    objCliente = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/clientes/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objCliente = new Cliente (
                    data.id,
                    data.apellido,
                    data.nombre,
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
                    data.lista_precio,
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
    return objCliente;
}

function obtenerClientes(pagina = 1, filtros = ''){
    lista = new Array();
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/clientes_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach( elemento => { lista.push(elemento) }) 
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return lista;
}

function obtenerListaCliente(pagina = 1, filtros = '', boton = 'btnAGREGAR'){
    var Lista = '';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/clientes_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><a href="#" data-toggle="modal" data-target="#modalFormulario" onclick="formarEdicion(' + element.id + ')"><small>' + element.apellido + ' ' + element.nombre + '</small></a></th>' +
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