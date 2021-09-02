class CompraDetalle {

    constructor(
        id = 0,
        compra_id = '',
        articulo_id = '',
        denominacion = '',
        garantia = '',
        cantidad = '0',
        usd_costo_bruto = '0.000',
        iva_alicuota = '00.0',
        usd_iva_base = '0.000',
        usd_costo_neto = '0.000',
        utilidad = '0.000',
        usd_margen = '0.000',
        usd_precio = '0.000',
        created_at = new Date(),
        updated_at = new Date() ) 
        {
            this.id = id,
            this.compra_id = compra_id,
            this.articulo_id = articulo_id,
            this.denominacion = denominacion,
            this.garantia = garantia,
            this.cantidad = cantidad,
            this.usd_costo_bruto = usd_costo_bruto,
            this.iva_alicuota = iva_alicuota,
            this.usd_iva_base = usd_iva_base,
            this.usd_costo_neto = usd_costo_neto,
            this.utilidad = utilidad,
            this.usd_margen = usd_margen,
            this.usd_precio = usd_precio,
            this.created_at = created_at,
            this.updated_at = updated_at
        }
}