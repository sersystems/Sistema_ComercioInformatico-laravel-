class Rubro {
    constructor(
        id = 0,
        denominacion = '',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.denominacion = denominacion,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}

function eliminarRubro(id){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: "DELETE",
            url: '/rubros/' + id,
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

function guardarRubro(objRubro){
    var respuesta = false;
    try {
        $.ajax({
            async: false,
            method: (objRubro && objRubro.id) ? "PUT" : "POST",
            url: (objRubro && objRubro.id) ? '/rubros/' + objRubro.id : '/rubros',
            data: objRubro,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Guardando... Por favor espere."); },
            success: (data) => { 
                respuesta = data.procesado;
                $("#idEstadoProceso").text(data.message); 
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No ' + ((objRubro && objRubro.id) ? 'editado' : 'creado') + ' (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return respuesta;
}

function obtenerRubro(id){
    objRubro = null;
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/rubros/' + id,
            dataType: 'JSON',
            beforeSend: () => { $("#idEstadoProceso").text("Cargando... Por favor espere."); },
            success: (data) => {
                objRubro = new Rubro (
                    data.id,
                    data.denominacion,
                    data.created_at,
                    data.updated_at
                );
                $("#idEstadoProceso").text('');
            },
            error: (e) => { $("#idEstadoProceso").text('Registro No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return objRubro;
}

function obtenerDesplegableRubros(){
    var Desplegable = { 'paraFiltro': '<option value="">TODOS LOS RUBROS</option>', 'paraFormulario': '' };
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/rubros_desplegable',
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Desplegable.paraFiltro += '<option value="' + element.denominacion + '">' + element.denominacion + '</option>';
                    Desplegable.paraFormulario += '<option value="' + element.id + '">' + element.denominacion + '</option>';
                });
            },
            error: (e) => { $("#idEstadoProceso").text('Desplegable No cargado (ERROR-' + e.status + ')'); }
        });
    } catch (error) { console.log(error) }
    return Desplegable;
}

function obtenerListaRubro(pagina = 1, filtros = '', boton = 'btnAGREGAR'){
    var Lista = '';
    boton = (boton == 'btnAGREGAR')?  'formarAgregacion' : 'formarEliminacion';
    try {
        $.ajax({
            async: false,
            method: "GET",
            url: '/rubros_list?pagina=' + pagina + filtros,
            dataType: 'JSON',
            success: (data) => { 
                data.forEach(element => {
                    Lista += 
                    '<tr>' +
                        '<th><small>' + element.id + '</small></th>' +
                        '<th><a href="#" data-toggle="modal" data-target="#modalFormulario" onclick="formarEdicion(' + element.id + ')"><small>' + element.denominacion + '</small></a></th>' +
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