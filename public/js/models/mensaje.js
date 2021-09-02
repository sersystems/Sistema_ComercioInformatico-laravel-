class Mensaje {
    constructor(
        id = 0,
        denominacion = '',
        celular = '',
        email = '',
        consulta = '',
        respuesta = '',
        estado = 'S/RESPONDER',
        captcha = 'NO-CAPTCHA', //Importante: Valor requerido para actualizar un registro
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.denominacion = denominacion,
            this.celular = celular,
            this.email = email,
            this.consulta = consulta,
            this.respuesta = respuesta,
            this.estado = estado,
            this.captcha = captcha,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function eliminarMensaje(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/mensajes/' + id,
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

function guardarMensaje(objMensaje){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objMensaje && objMensaje.id) ? "PUT" : "POST",
            url: (objMensaje && objMensaje.id) ? '/mensajes/' + objMensaje.id : '/contacto',
            data: objMensaje,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = data.procesado;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objMensaje && objMensaje.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerMensaje(id){
    objMensaje = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/mensajes/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objMensaje = new Mensaje (
                    data.id,
                    data.denominacion,
                    data.celular,
                    data.email,
                    data.consulta,
                    data.respuesta,
                    data.estado,
                    'no-captcha',
                    data.created_at,
                    data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objMensaje;
}

function obtenerMensajes(pagina = 1, filtros = ''){
    lista = new Array();
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/mensajes_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach( elemento => { lista.push(elemento) }) 
            },
            error: (e) => { $("#idEstadoProceso").text('Registros No cargados (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return lista;
}

function obtenerListaMensaje(pagina = 1, filtros = '', boton = 'btnAGREGAR'){
    var Lista = '';
    boton = (boton == 'btnAGREGAR')?  'formarAgregacion' : 'formarEliminacion';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/mensajes_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><a href="#" data-toggle="modal" data-target="#modalFormulario" onclick="formarVisualizacion(' + element.id + ')"><small>' + element.denominacion + '</small></a></th>' +
                        '<th><small>' + element.celular + '</small></th>' +
                        '<th><small class="' + ((element.estado == 'S/RESPONDER') ? 'text-danger' : 'text-success' ) + '">' + element.estado + '</small></th>' +
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