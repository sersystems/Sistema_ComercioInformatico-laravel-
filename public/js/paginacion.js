var paginaTotal = 1;
var paginaSelecionada = 1;

function crearPaginacion(ruta, filtros, lista){
    $.ajax({
        async: false,
        method: "GET",
        url: ruta + '?count=true' + filtros,
        dataType: 'JSON',
        success: (data) => {
            if (this.paginaTotal != data){
                this.paginaTotal = data;
                irPaginaInicial(lista);
            }
         },
        error: () => {
            if (this.paginaTotal != 1){
                this.paginaTotal = 1;
                irPaginaInicial(lista);
            }
        }
    });
    $('#idPaginacion, #idPaginacionBuscador').empty().append('<nav aria-label="Page navigation example">' +
        '<ul class="pagination pagination-sm justify-content-center">' +
            '<li class="page-item"><button class="page-link" onclick="irPaginaInicial(\'' + lista + '\')"><i class="fas fa-angle-double-left"></i></button></li>' +
            '<li class="page-item"><button class="page-link" onclick="irPaginaAnterior(\'' + lista + '\')"><i class="fas fa-angle-left"></i></button></li>' +
            '<li class="page-item active"><span class="page-link"><small>' + this.paginaSelecionada + '</small></span></li>' + 
            '<li class="page-item"><button class="page-link" onclick="irPaginaSiguiente(\'' + lista + '\')"><i class="fas fa-angle-right"></i></button></li>' +
            '<li class="page-item"><button class="page-link" onclick="irPaginaFinal(\'' + lista + '\')"><i class="fas fa-angle-double-right"></i></button></li>' +
        '</ul>' +
    '</nav>');
}

function irPaginaInicial(lista){
    this.paginaSelecionada = 1;
    this.formarLista(lista);
}

function irPaginaAnterior(lista){
    var pagina = (this.paginaSelecionada - 1);
    this.paginaSelecionada = (pagina >= 1) ? pagina : 1;
    this.formarLista(lista);
}

function irPaginaSiguiente(lista){
    var pagina = (this.paginaSelecionada + 1);
    this.paginaSelecionada = (pagina <= paginaTotal) ? pagina : paginaTotal;
    this.formarLista(lista);
}

function irPaginaFinal(lista){
    this.paginaSelecionada = paginaTotal;
    this.formarLista(lista);
}