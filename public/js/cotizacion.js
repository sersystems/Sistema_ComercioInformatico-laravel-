var cotizacionDolar = '46.00';

try {
    $.ajax({
        async: false,
        method: "GET",
        url: '/cotizacion_dolar',
        dataType: 'JSON',
        success: (data) => { 
            cotizacionDolar = data;
            $('#idCotizacionDolar').text(parseFloat(cotizacionDolar).toFixed(2));
        },
        error: (e) => { $("#idEstadoProceso").text('Cotización del Dolar No obtenida (ERROR-' + e.status + ')'); }
    });
} catch (error) { console.log(error) }

function regularPrecioPublico(valor) {
    var valorEntero = parseInt(valor);
    var valorUnidad = parseInt(valorEntero.toString().substring(valorEntero.toString().length - 1, valorEntero.toString().length));
    if (valorUnidad > 0 && valorUnidad <= 5) valorEntero += (5 - valorUnidad);
    else if (valorUnidad > 5) valorEntero += (10 - valorUnidad);
    return parseInt(valorEntero).toFixed(2);
}

function regularPrecioGremio(valor) {
    var valorEntero = parseInt(valor);
    var valorUnidad = parseInt(valorEntero.toString().substring(valorEntero.toString().length - 1, valorEntero.toString().length));
    if (valorUnidad > 0 && valorUnidad <= 5) valorEntero -= valorUnidad;
    else if (valorUnidad > 5) valorEntero -= (valorUnidad - 5);
    return parseInt(valorEntero).toFixed(2);
}